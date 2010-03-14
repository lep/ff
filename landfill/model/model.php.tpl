{%macro escape(var, type) %}
{% if type == "id"%}
	sql()->escapeInt({{var}})
{% elif type == "int"%} 
 	sql()->escapeInt({{var}})
{% elif type == "string"%}
	sql()->escapeString({{var}})
{% elif type == "float"%}
	sql()->escapeFloat({{var}})
{% endif%}
{% endmacro%}

<?php
	error_reporting(E_ALL);
	{% for tablename in tables %}
	{% set table = tables[tablename] %}
	class FETCH_{{tablename}}{
		var $cond;
		var $ord;
		var $sql;
		function __construct(){
			$this->cond = array();
			$this->ord = array();
			$this->sql = sql({{prefix}});
		}
		{% for columnname in table%}
			{% set column = table[columnname]%}
			{% set type = column["type"]%}
			{% for op in operations[type] %}
				function {{columnname}}{{op}}($to){
					$this->cond[]={{escape("$to", type)}}."{{operations[type][op]}} {{columnname}}";
					return $this;
				}
			{% endfor %}
			{% if orderable[type] %}
				function orderBy{{columnname|capitalize}}Desc(){
					$this->ord[] = "{{columnname}} DESC";
					return $this;
				}
				function orderBy{{columnname|capitalize}}Asc(){
					$this->ord[] = "{{columnname}} ASC";
					return $this;
				}
			{% endif %}
			
		{% endfor %}
		
		function where(){
			$args=func_get_args();
			$this->cond[]=$this->sql->createQuery(array_shift($args), $args);
			return $this;
		}
		
		private function buildOrderClause(){
			if (count($this->ord)>0)
				return " ORDER BY ".implode(',', $this->ord);
			else
				return "";
		}
		
		private function buildWhereClause(){
			if (count($this->cond)>0)
				return ' WHERE '.implode(' AND ', $this->cond);
			else 
				return "";
		}
		
		private function buildFromClause(){
			return ' FROM {{"{"}}{{tablename}}{{"}"}}';
		}
		
		private function  buildCompleteSelectClause(){
			return 'SELECT *'.
				$this->buildFromClause().
			    $this->buildWhereClause().
			    $this->buildOrderClause();
		}
		
		
		function offsetAndLimit($offset, $limit){
			return $this->buildCompleteSelectClause().
			    'LIMIT '.$limit.' OFFSET '.$offset;
		}
		
		function limit($limit){
			return $this->buildCompleteSelectClause().
			    'LIMIT '.$limit;
		}
		function all(){
			$sql = $this->buildCompleteSelectClause();
			return $this->sql->query($sql);
		}
		
	}
	
	class {{tablename}}{
		{% for columnname in table %}
			var ${{columnname}};
		{% endfor %}
		function __construct(){
		{% for columnname in table %}
			{% set column = table[columnname]%}
			{%if column.has_key("default")%}
				$this->{{columnname}} = {{column.default|phpvar}};
			{%endif%}
		{% endfor %}
		}
		
		private function update(){
			echo "updates";
			$sql = "UPDATE {{tablename}} SET
			{% for columnname in table%}
			{% set column = table[columnname]%}
				{{columnname}} =" .$this->{{ columnname }}."
				{% if not loop.last %}
				,
				{% endif %}
			{% endfor %}
			WHERE id = ".$this->id;
			echo "update";
			sql({{prefix}})->query($sql);
		}
		
		private function insert(){
			echo "inserts";
			$sql =  "INSERT INTO {{tablename}}(
				{% for columnname in table %}
					{% if columnname != "id" %}
						{% if not loop.first -%}	
						,
						{%- endif %}
						{{ columnname }}
					{% endif %}
				{% endfor %}
				) VALUES (".
				{% for columnname in table %}
					{% if columnname != "id" %}
						{% if not loop.first -%}	
						','.
						{%- endif %}
						{{escape("$this->"+columnname, table[columnname]["type"])}}.
					{% endif %}
				{% endfor %}		
				")";
				echo "insert";
			sql({{prefix}})->query($sql);
		}
		
		static function createTable()
		{
			$sql = "CREATE TABLE {{tablename}} (
				{% for columnname in table-%}
					{% set column = table[columnname]%}
					{% set type = column["type"]%}
						{{columnname}}
						{% if type == "int"-%}
							INT
						{% elif type == "string"%}
							TEXT
						{% else %}
							{{type}}
						{%- endif %}
					{% if not loop.last -%}
					,
					{%- endif %}
				{%- endfor %}
				)";
				sql({{prefix}})->query($sql);
		}
		
		static function dropTable()
		{
			$sql = "DROP TABLE {{tablename}}";
			sql("prefix")->query($sql);
		}
		
		static function dropTable()
		{
			$sql = "DROP TABLE {{tablename}}";
			sql("prefix")->query($sql);
		}

		function save(){
			echo "save";
			if ($this->id != False)
				$this->update();
			else
				$this->insert();
		}
		
		static function fetch(){
			return new FETCH_{{tablename}}();
		}
	}
	{% endfor %}
	
?>
