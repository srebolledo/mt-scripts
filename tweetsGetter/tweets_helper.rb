
require 'net/http'
require 'rubygems' #used by json/pure
require 'json' #used to parse json
require 'htmlentities'
require 'database_helper'
require 'iconv'
$files = 1
#Function get_tweet, it receives a search term and returns a hash containing the data
def get_tweet(search,since_id = 0, throtle = 100, recursively = 0)
	filename = search
	if search[0] != 63
		search = "?q="+search+"&rpp="+throtle.to_s
	end
	url = 'http://search.twitter.com/search.json'+search
	print "Asking with this url " + url+ "\n"
	resp = Net::HTTP.get_response(URI.parse(url))
	begin
		response_hash = JSON.parse(resp.body)
	rescue 
		print resp.body
	end
	file = File.new($files.to_s+".json","w")
	$files = $files+1;
	file.write(resp.body)
	file.close
	#save_tweets(response_hash)
	#print response_hash
	#print "\n"
	 if response_hash.nil?
	 else
	 	if !response_hash["next_page"].nil?
	 		recursively = recursively+1
	 		tweets = get_tweet(response_hash["next_page"],0,throtle,recursively)
	 	end
	 end


end

def print_tweets(tweets_hash)
	ids = []
	tweets_hash.each_pair do |key,value|
		#print key +"   ====>  "+ value.to_s
		if key == "results"
			i = 0
			value.each do |tweet|
				print tweet['id_str'] + " " +tweet['text'] + "\n"
				ids.push(tweet['id_str'])
			end
		end
	end

	return ids.max
end

def save_tweets(tweets_hash)
	connection = connect()
	ids = []
	htmlent = HTMLEntities.new
	tweets_hash["results"].each do |tweet|
		begin
			sql = "insert into new_tweets values (NULL,'"+tweet['id_str'].to_s+"','"+htmlent.encode(tweet["from_user"].to_s)+"','200','"+unicode_utf8(tweet["created"].to_s)+"','0','none','lat','long','Here','check','"+unicode_utf8(quote_string(tweet['text']).to_s)+"','ES','Chile');"
			#print sql+"\n"
			#connection.query(sql)
			rescue
				print Iconv.conv('UTF-8','UTF-8',sql)	
				print "Duplicado!\n"
		end
	end

	# tweets_hash.each_pair do |key,value|
	# 	print key +"   ====>  "+ value.to_s
	# 	if key == "results"
	# 		i = 0
	# 		value.each do |tweet|
	# 			sql = "insert into new_tweets values ('',"+tweet['id_str']+"','"+tweet["from_user"]+"','200','"+tweet["created"]+"','0','none','lat','long','Here','check','"+htmlent.encode(tweet['text'])+"','ES','Chile');"
	# 			print sql+"\n"
	# 			connection.query(sql)
	# 		end
	# 	end
	# end
end

def unicode_utf8(unicode_string)
	unicode_string.gsub(/\\u\w{4}/) do |s|
		str = s.sub(/\\u/,"").hex.to_s(2)
		if str.length < 8
			CGI.unescape(str.to_i(2).to_s(16).insert(0,"%"))
		else
			arr = str.reverse.scan(/\w{0,6}/).reverse.select{|a| a != ""}.map{|b| b.reverse}
			hex = lambda do |s|
				(arr.first == s ? "1" * arr.length + "0" * (8 - arr.length - s.length) + s : "10" + s).to_i(2).to_s(16).insert(0, "%")
			end
			CGI.unescape(arr.map(&hex).join)
		end
	end
end

def quote_string(v)
  v.to_s.gsub(/\\/, '\&\&').gsub(/'/, "''")
end

