import nltk, re, codecs, pickle
reader = nltk.corpus.TaggedCorpusReader('/Users/stephan/nltk_data/corpora/twitter/tweets_tagged','.*\.txt', encoding="utf")
#clean the input from *
sent = []
tagged = []
for sents in reader.tagged_sents():
  thisSent = []
  thisTagged = []
  flag = False
  for taggedSent in sents:
    if taggedSent[0] != '*' and taggedSent[0] != '\\':
      if taggedSent[0] != "@":
        if flag:
          thisSent.append("@"+taggedSent[0].replace('\\',''))
        else:
          thisSent.append(taggedSent[0].replace('\\',''))
        thisTagged.append(taggedSent[1])
        flag = False
      else:
        flag = True


  sent.append(thisSent)
  tagged.append(thisTagged)

counter = 0
fileids = reader.fileids()
# sentFile = open("sents.txt","w")
# taggedFile = open("tagged.txt","w")

#Tag mapping
tags = {}
tags['FP'] = 15
tags['DN'] = 15
tags['FS'] = 15
tags['DI'] = 15
tags['FX'] = 15
tags['DD'] = 15
tags['DA'] = 15
tags['Y'] = 15
tags['FC'] = 15
tags['FD'] = 15
tags['FE'] = 15
tags['FG'] = 15
tags['VAN',] =4
tags['FAA'] =15
tags['DP'] = 15
tags['PR'] =15
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
tags['VSS'] = 4
tags['CS'] = 8
tags['VAS'] = 4
tags['Z'] =15
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


#End tag mapping

sentFile = codecs.open("sent.txt","w","utf-8")
taggedFile = codecs.open("tagged.txt","w","utf-8")


counterSents = 0
for i in sent:
  print fileids[counter]
  id = re.findall(r'\d+',fileids[counter])
  counter  = counter + 1
  sentence = "insert into tweets(id, tweet) values ("+str(id[0])+", '"+" ".join(sent[counterSents])+"');"
  sentence
  sentFile.write(unicode(sentence)+"\n")
  counterPartSent = 0
  while counterPartSent < len(sent[counterSents]):
    tagLine = "insert into tweets_users (tweet_id, position_tweet, tag_id, word) values("+str(id[0])+", "+str(counterPartSent+1)+","+str(tags[tagged[counterSents][counterPartSent]])+", '"+sent[counterSents][counterPartSent]+"');"
    taggedFile.write(tagLine+"\n")
    counterPartSent = counterPartSent + 1
  counterSents = counterSents + 1;















  # AN    normal adjective
  #     AC    cardinals
  #     AO    ordinals
  #     CC    coordinating conjunction
  #     CS    subordinating conjunction
  #     I   interjection
  #     NP    proper noun
  #     NC    common noun
  #     PP    personal pronoun
  #     PD    demonstrative pronoun
  #     PI    indefinite pronoun
  #     PT    interrogative/relative pronoun
  #     PC    reciprocal pronoun
  #     PO    possessive pronoun
  #     RG    adverb
  #     SP    preposition
  #     U   unique
  #     VA    main verb
  #     VE    medial verb
  #     XA    abbreviation
  #     XF    foreign word
  #     XP    punctuation
  #     XR    formulae
  #     XS    symbol
  #     XX    other