import landfill.model.template as template
import yaml

data=None
with open('landfill/model/test.yaml', 'r') as f:
	data = yaml.load(f.read())

with open('web/main/model.php', 'w') as f:
	f.write(template.render(data))