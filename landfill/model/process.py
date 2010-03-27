def process(data):
	for tablename in data.keys():
		table = data[tablename]
		for name in table:
			if isinstance(table[name], basestring):
				table[name] = {"type": table[name]}
	return data