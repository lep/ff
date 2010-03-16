from yaml import load
from os import listdir
from os.path import exists
from template import render

def handleFile(source, destination):
	data = None
	with open(source, "r") as f:
		data = load(f.read())
	with open(destination, "w") as f:
		f.write(render(data))

def main():
	for dir in listdir("web"):
		path = "web/"+dir+"/model.yaml"
		if exists(path):
			handleFile(path, "web/"+dir+"/model.php")