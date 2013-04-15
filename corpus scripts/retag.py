import nltk, re, codecs, pickle, nltk.data, nltk.tree, os
# tagger = nltk.data.load('taggers/cess_esp_aubt.pickle')
tagger = nltk.data.load('taggers/conll2002_aubt.pickle')
chunker = nltk.data.load('chunkers/conll2002_chunker.pickle')
from nltk.tag.simplify import simplify_brown_tag
from nltk.tokenize import PunktWordTokenizer
path = "totag/"
listing = os.listdir(path)
for infile in listing:
  f = open(path+infile,"r")
  item = unicode(f.readline(), errors="ignore").split(" ")
  ner_tagged = chunker.parse(tagger.tag(item))

  chunks_tagged = nltk.chunk.util.tree2conlltags(ner_tagged)
  tagged_file = codecs.open(path+"tagged"+infile, "w","utf-8")
  for chunks in chunks_tagged:
    line = chunks[0]+" "+chunks[1]+"\n"
    tagged_file.write(line)