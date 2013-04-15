import nltk, re, codecs, pickle, nltk.data, nltk.tree
# tagger = nltk.data.load('taggers/cess_esp_aubt.pickle')
tagger = nltk.data.load('taggers/conll2002_aubt.pickle')
chunker = nltk.data.load('chunkers/conll2002_chunker.pickle')
from nltk.tag.simplify import simplify_brown_tag
from nltk.tokenize import PunktWordTokenizer
twitter = nltk.corpus.PlaintextCorpusReader('/Users/stephan/nltk_data/corpora/twitter/tweets/', '.*\.txt', encoding="utf", word_tokenizer=PunktWordTokenizer())
twitter_sents = twitter.sents()
print twitter_sents

counter = 0


# #Tag mappi
tags = {}
tags['FP'] = 15
tags['DN'] = 18
tags['FS'] = 15
tags['DI'] = 1
tags['FX'] = 15
tags['DD'] = 3
tags['DA'] = 1
tags['Y'] = 20
tags['FC'] = 15
tags['FD'] = 15
tags['FE'] = 15
tags['FG'] = 15
tags['VAN',] =4
tags['FAA'] =15
tags['DP'] = 3
tags['PR'] =3
tags['PP'] =3
tags['PT'] =3
tags['PX'] =3
tags['NC'] = 2
tags['FAT'] =15
tags['I'] = 9
tags['RG'] =6
tags['PD'] =3
tags['NP'] = 2
tags['RN'] = 6
tags['PI'] =3
tags['PN'] =3
tags['P0'] = 3
tags['FZ'] =15
tags['VSP'] = 4
tags['P15'] = 3
tags['VAI'] = 4
tags['FPA'] =15
tags['FIT'] = 15
tags['CC'] = 8
tags['AO'] = 18
tags['AQ'] =5
tags['FPT'] = 15
tags['-NONE-'] =15
tags['-None-'] = 15
tags['VSS'] = 4
tags['CS'] = 8
tags['VAS'] = 4
tags['Z'] =18
tags['VMN'] =4
tags['VMM'] =4
tags['VMI'] =4
tags['VMG'] =4
tags['SP'] = 7
tags['VSM',] = 4
tags['VMP'] = 4
tags['VSG'] = 4
tags['VSI'] = 4
tags['VMS'] = 4
tags['VSN'] = 4
tags['VAN'] = 4
tags['VSM'] = 4

ner_tags = {}

ner_tags['B-PER'] = 11
ner_tags['I-PER'] = 11
ner_tags['B-LOC'] = 12
ner_tags['I-LOC'] = 12
ner_tags['B-ORG'] = 13
ner_tags['I-ORG'] = 13
ner_tags['B-MISC'] = 16
ner_tags['I-MISC'] = 16
ner_tags['O'] = 15


sent = []
tagged = []
ner = []
for item in twitter_sents:
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



fileids = twitter.fileids()


sentFile = codecs.open("sent_new.txt","w","utf-8")
taggedFile = codecs.open("tagged_new.txt","w","utf-8")
nerFile = codecs.open("ner_new.txt","w","utf-8")

counter = 0
counterSents = 0
for i in sent:
  id = re.findall(r'\d+',fileids[counter])
  counter  = counter + 1
  sentence = "insert into tweets(id, tweet) values ("+str(id[0])+", '"+" ".join(sent[counterSents])+"');"
  sentence
  sentFile.write(unicode(sentence)+"\n")
  counterPartSent = 0
  while counterPartSent < len(sent[counterSents]):
    linked = 1 if ner[counterSents][counterPartSent] != "O" else 0
    tagLine = "insert into tweets_users (tweet_id, position_tweet, tag_id, ner_tag_id, linked, word) values("+str(id[0])+", "+str(counterPartSent+1)+","+str(tags[tagged[counterSents][counterPartSent].upper()])+",'"+str(ner_tags[ner[counterSents][counterPartSent]])+"', '"+str(linked)+"' '"+sent[counterSents][counterPartSent]+"');"
    taggedFile.write(tagLine+"\n")
    counterPartSent = counterPartSent + 1
  counterSents = counterSents + 1;








  #file.write(unicode(ner_tagged))

# for item in twitter_sents:
#   counter = counter +1
#   # file = open('tweets_tagged/tweet_'+str(counter)+"_tagged_cess.txt","w")
#   tagged_sent = tagger.tag(item)
#   ner_tagged = nltk.pos_tag(item)
#   print ner_tagged
#   # simplified = [(word, simplify_brown_tag(tag)) for word, tag in tagged_sent]
#   sent = ""
#   for item in tagged_sent:
#     sent += item[0]+"/"+item[1]+" "

#   # file.write(sent.encode("UTF-8"))

