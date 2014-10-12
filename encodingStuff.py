import chardet
import os
import codecs
import sys

extensionsToReincode=[".php",".html",".css",".js"]

def reincodeMyFile(fullpath,filename):
    global count
    if(isToBeReincoded(filename)):
        enc=getEncoding(fullpath)
            sys.exit()
        if(enc!="utf-8"):
            print(fullpath, " previously encoded in ", enc)
            sourceFile=codecs.open(fullpath, "r", enc)
            sourceString=sourceFile.read()
            sourceFile.close()
            with codecs.open(fullpath, "w", "utf-8") as targetFile:
                targetFile.write(sourceString)           

def walkToEncode():
    for root, dirs, files in os.walk("."):
        dirs[:] = [d for d in dirs if d not in [".git",".project"]]
        for filename in files:
            reincodeMyFile(root+"\\"+filename,filename)

def isToBeReincoded(filename):
    fileName, fileExtension = os.path.splitext(filename)
    return (fileExtension in extensionsToReincode)

def getEncoding(fullpath):
    rawdata = open(fullpath, "r").read()
    result = chardet.detect(rawdata)
    charenc = result['encoding']
    return charenc


walkToEncode()
