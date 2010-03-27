from yaml import load
from os import listdir
from os.path import exists
from template import render
from process import process
from validation import validate

def handleFile(source, destination, prefix):
	data = None
	with open(source, "r") as f:
		data = load(f.read())
	with open(destination, "w") as f:
		f.write(render(validate(process(data)), prefix=prefix))

def main():
	for dir in listdir("web"):
		path = "web/"+dir+"/model.yml"
		if exists(path):
			handleFile(path, "web/"+dir+"/model.php", prefix=dir)
