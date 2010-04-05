from jinja2 import FunctionLoader, Environment

#TODO:
# - LIKE clause for strings
# - the final querys (get limit all delete)
# - save operations
# - foreign keys
# - manual where clause

operations_all = {
	"EQ": "=",
	"GT": ">",
	"GE": ">=",
	"LT": ">",
	"LE": "<=",
}

operations_string= {
	"EQ": "=",
	"GT": ">",
	"GE": ">=",
	"LT": ">",
	"LE": "<=",
	"LIKE": " LIKE "
}

operations_equal = {
	"EQ": "=",
}

operations = {
	"int": operations_all,
	"float": operations_all,
	"datetime": operations_all,
	"id": operations_all,
	"string": operations_equal,
	"bool": operations_equal,
}

orderable = {
	"int": True,
	"id": True,
	"float": True,
	"datetime": True,
	"string": True,
	"bool": False
}



def render(data, prefix=""):
	def isforeign(typename):
		return typename not in ["string", "int", "float", "id", "bool"]
		
	def phpvar(value):
		if isinstance(value, basestring):
			return "\"%s\"" % value
		else:
			return value
	
	def template(name):
		content = None
		with open("landfill/model/model.php.tpl", "r") as f:
			content = f.read()
		return content
		
	def tableexists(name):
		return name in data.keys()
	
	for table in data.keys():
		data[table]["id"] = {
			"type": "id",
			"default": False
		}
		
	env = Environment(loader=FunctionLoader(template))
	env.filters["phpvar"] = phpvar
	env.filters["tableexits"] = tableexists
	env.filters["isforeign"] = isforeign
	template = env.get_template("asd")
	return template.render({
		"tables": data, 
		"operations": operations,
		"orderable": orderable,
		"prefix": prefix+"_"
	})
