import nltk, re, codecs, pickle, nltk.data, nltk.tree
# tagger = nltk.data.load('taggers/cess_esp_aubt.pickle')
tagger = nltk.data.load('taggers/conll2002_brill_NaiveBayes_aubt.pickle')
chunker = nltk.data.load('chunkers/chunker_naiveBayes_espTrain6.pickle')
from nltk.tag.simplify import simplify_brown_tag
from nltk.tokenize import PunktWordTokenizer
twitter = nltk.corpus.PlaintextCorpusReader('/Users/stephan/nltk_data/corpora/twitter/tweets/', '.*\.txt', encoding="utf", word_tokenizer=PunktWordTokenizer())
twitter_sents = twitter.sents()

sent = []
tagged = []
ner = []
counter = 0;
print "Empezando."
for item in twitter_sents:
  print "Tweet: "+str(counter+1)+"\r";
  counter = counter +1
  thisSent = []
  thisTagged = []
  thisNer = []
  flag = False
  # file = codecs.open('tweets_ner_tagged_new/tweet_'+str(counter)+"_tagged.txt","w", "utf-8")
  ner_tagged = chunker.parse(tagger.tag(item))
  chunks_tagged = nltk.chunk.util.tree2conlltags(ner_tagged)
  for chunk in chunks_tagged:
    taggedSent = chunk
#     print taggedSent
    if taggedSent[0] != '*' and taggedSent[0] != '\\':
      if taggedSent[0] != "@":
        if flag:
          thisSent.append("@"+taggedSent[0].replace('\\',''))
        else:
          thisSent.append(taggedSent[0].replace('\\',''))
        thisTagged.append(taggedSent[1])
        thisNer.append(taggedSent[2])
        flag = False
      else:
        flag = True
  sent.append(thisSent)
  tagged.append(thisTagged)
  ner.append(thisNer)

corpus_tagged = codecs.open("tweet_conll2002_tagged.txt","w","utf-8")

i=0
while i<len(sent):
  j=0
  while j < len(sent[i]):
    corpus_tagged.write(sent[i][j]+" "+tagged[i][j]+" "+ner[i][j]+"\n")
    j+=1
  corpus_tagged.write("\n")
  i+=1

print "Fin"
# fileids = twitter.fileids()


# sentFile = codecs.open("sent_new.txt","w","utf-8")
# taggedFile = codecs.open("tagged_new.txt","w","utf-8")
# nerFile = codecs.open("ner_new.txt","w","utf-8")

# counter = 0
# counterSents = 0
# for i in sent:
#   id = re.findall(r'\d+',fileids[counter])
#   counter  = counter + 1
#   sentence = "insert into tweets(id, tweet) values ("+str(id[0])+", '"+" ".join(sent[counterSents])+"');"
#   sentence
#   sentFile.write(unicode(sentence)+"\n")
#   counterPartSent = 0
#   while counterPartSent < len(sent[counterSents]):
#     linked = 1 if ner[counterSents][counterPartSent] != "O" else 0
#     tagLine = "insert into tweets_users (tweet_id, position_tweet, tag_id, ner_tag_id, linked, word) values("+str(id[0])+", "+str(counterPartSent+1)+","+str(tags[tagged[counterSents][counterPartSent].upper()])+",'"+str(ner_tags[ner[counterSents][counterPartSent]])+"', '"+str(linked)+"' '"+sent[counterSents][counterPartSent]+"');"
#     taggedFile.write(tagLine+"\n")
#     counterPartSent = counterPartSent + 1
#   counterSents = counterSents + 1;








#   #file.write(unicode(ner_tagged))

# # for item in twitter_sents:
# #   counter = counter +1
# #   # file = open('tweets_tagged/tweet_'+str(counter)+"_tagged_cess.txt","w")
# #   tagged_sent = tagger.tag(item)
# #   ner_tagged = nltk.pos_tag(item)
# #   print ner_tagged
# #   # simplified = [(word, simplify_brown_tag(tag)) for word, tag in tagged_sent]
# #   sent = ""
# #   for item in tagged_sent:
# #     sent += item[0]+"/"+item[1]+" "

# #   # file.write(sent.encode("UTF-8"))

