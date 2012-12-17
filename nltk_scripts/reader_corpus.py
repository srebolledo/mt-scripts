import nltk, re

twitter = nltk.corpus.PlaintextCorpusReader('/Users/stephan/nltk_data/corpora/twitter/tweets/', '.*\.txt')
twitter_sents = twitter.sents()
counter = 0
for item in twitter_sents:
  counter = counter +1
  file = open('tweets/tweet_'+str(counter)+"_tagged.txt","w")
  file.write(str(nltk.pos_tag(item)))
  
