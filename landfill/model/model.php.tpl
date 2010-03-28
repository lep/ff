<?php

{% macro escape(var, type) %}
{% if type == "id"%}
	sql()->escapeInt({{var}})
{% elif type == "int"%} 
 	sql()->escapeInt({{var}})
{% elif type == "string"%}
	sql()->escapeString({{var}})
{% elif type == "float"%}
	sql()->escapeFloat({{var}})
{% else %}
	sql()->escapeInt({{var}})
{% endif%}
{% endmacro%}

	error_reporting(E_ALL);
	{% for tablename in tables %}
	{% set table = tables[tablename] %}
	class {{prefix}}objects_{{tablename}}{
		var $cond;
		var $ord;
		var $sql;
		
		
		
		function __construct(){
			$this->cond = array();
			$this->ord = array();
			$this->sql = sql("{{prefix}}");
		}
		{% for columnname in table%}
			{% set column = table[columnname]%}
			{% set type = column["type"]%}
			{% if not type|isforeign %}
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
				
			{% else %}
				function {{columnname}}EQ($to){
					$this->cond[]={{escape("$to->id", "int")}}." =  {{columnname}}";
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
		
		function delete()
		{
			$sql = "DELETE FROM {{'{'}}{{tablename}}{{'}'}} ".
				$this->buildWhereClause();
			$this->sql->query($sql);
		}
		

		
		function offsetAndLimit($offset, $limit){
			$sql = $this->buildCompleteSelectClause().
			    ' LIMIT '.{{escape("$limit","int")}}.' OFFSET '.{{escape("$offset","int")}};
			return {{prefix}}{{tablename}}::objectsFromRows($this->sql->query($sql));
		}
		
		function limit($limit){
			$sql = $this->buildCompleteSelectClause().
			    ' LIMIT '.{{escape("$limit","int")}};
			return {{prefix}}{{tablename}}::objectsFromRows($this->sql->query($sql));
		}
		function all(){
			$sql = $this->buildCompleteSelectClause();
			return {{prefix}}{{tablename}}::objectsFromRows($this->sql->query($sql));
		}
		
		function get(){
			$sql = $this->buildCompleteSelectClause();
			$result = {{prefix}}{{tablename}}::objectsFromRows($this->sql->query($sql));
			if (count($result) == 0)
				throw new SqlError("{{tablename}} .get() found no row");
			return $result[0];
		}
		
		function create(){
			return new {{prefix}}{{tablename}}();
		}
		
		function createTable()
		{
			$sql = "CREATE TABLE {{'{'}}{{tablename}}{{'}'}} (
				{% for columnname in table-%}
					{% set column = table[columnname]%}
					{% set type = column["type"]%}
						{{columnname}}
						{% if type == "int"-%}
							INT
						{% elif type == "id" %}
							SERIAL
						{% elif type == "string"%}
							TEXT
						{% else %}
							INT
						{%- endif %}
					{% if not loop.last -%}
					,
				 	{%- endif %}
				{%- endfor %}
				)";
				$this->sql->query($sql);
		}
		
		function dropTable()
		{
			$sql = "DROP TABLE {{'{'}}{{tablename}}{{'}'}}"  ;
			$this->sql->query($sql);
		}
		
	}
	
	class {{prefix}}{{tablename}}{
		{% for columnname in table %}
			{% set column = table[columnname]%}
			{% if  column["type"] == "id"%}
			private ${{columnname}};
			{% elif column["type"]|isforeign %}
			private ${{columnname}};
			private $_foreign_{{columnname}} = False;
			{% else%}
			var ${{columnname}};
			{%endif%}
		{% endfor %}
		
		
		
		{% set first = 1 %}
		var $__get_schema = array(
		{% for columnname in table %}
			{% set column = table[columnname]%}
			{% if  column["type"] == "id"%}
				{% if first == 0 -%}	
				,
				{% else %}
					{% set first = 0 %}
				{%- endif %}
				'{{columnname}}'
			{% elif  column["type"]|isforeign %}
				{% if first == 0 -%}	
				,
				{% else %}
					{% set first = 0 %}
				{%- endif %}
					'{{columnname}}'
			{%endif%}
		{% endfor %}
		);
	
		function __get($name)
		{
			switch($name){
			{% for columnname in table %}
				{% set column = table[columnname]%}
				{% if  column["type"] == "id"%}
					case '{{columnname}}':
						return $this->{{columnname}};
				{% elif column["type"]|isforeign%}
					case '{{columnname}}':
						if($this->_foreign_{{columnname}} == false)
							return $this->_load_{{columnname}}();
						else
							return $this->_foreign_{{columnname}};
				{%endif%}
			{% endfor %}
			}
			
			$trace = debug_backtrace();
		        trigger_error(
		            'Undefined property via __get(): ' . $name .
		            ' in ' . $trace[0]['file'] .
		            ' on line ' . $trace[0]['line'],
		            E_USER_NOTICE);
		        return null;
		}
		
		function __set($name, $what)
		{
			switch($name){
			{% for columnname in table %}
				{% set column = table[columnname]%}
				{% if column["type"]|isforeign%}
					case '{{columnname}}':
						$this->_foreign_{{columnname}} = $what;
						$this->{{columnname}} = $what->id;
						return;
				{%endif%}
			{% endfor %}
			}
			
			$trace = debug_backtrace();
		        trigger_error(
		            'Undefined property via __get(): ' . $name .
		            ' in ' . $trace[0]['file'] .
		            ' on line ' . $trace[0]['line'],
		            E_USER_NOTICE);
		        return null;
		}
		
		{% for columnname in table %}
			{% set column = table[columnname]%}
			{% if column["type"]|isforeign%}
				function _load_{{columnname}}()
				{
					$this->_foreign_{{columnname}} = {{prefix}}{{column["type"]}}::objects()->idEQ($this->{{columnname}})->get();
					return $this->_foreign_{{columnname}};
				}
			{%endif%}
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
			$sql = "UPDATE {{'{'}}{{tablename}}{{'}'}} SET
			{% for columnname in table%}
			{% set column = table[columnname]%}
				{% if not loop.first %}
					,
				{% endif %}
				{{columnname}} =" .{{escape("$this->"+columnname, column["type"])}}."

			{% endfor %}
			WHERE id = ".$this->id;
			sql({{prefix}})->query($sql);
		}
		
		function delete()
		{
			if ($this->id == False)
				throw new SqlError("{{columname}} tried to delete object no stored in db");
			
			self::objects()->idEQ($this->id)->delete();
			
		}
		
		static function objectFromRow($row)
		{
			$object = new self();
			#this does no checking at all. Don't be evil!
			{% for columnname in table %}
				$object->{{columnname}} = $row['{{columnname}}'];
			{% endfor %}
			return $object;
		}
		
		static function objectsFromRows($rows)
		{
			$arr = array();
			foreach($rows as $key => $value)
				$arr[$key] = self::objectFromRow($value);
			return $arr;
			// TODO: find nice way to do this
		}
		
		private function insert(){
			$sql =  "INSERT INTO {{'{'}}{{tablename}}{{'}'}}(
				{% set first = 1 %}
				{% for columnname in table %}
					{% if columnname != "id" %}
						{% if first == 0 -%}	
						,
						{% else %}
							{% set first = 0 %}
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
			sql("{{prefix}}")->query($sql);
		}
		
		function save(){
			if ($this->id != False)
				$this->update();
			else
				$this->insert();
		}
		
		static function objects(){
			return new {{prefix}}objects_{{tablename}}();
		}
		
	}
	{% endfor %}	
	
	/*testtable::dropTable();
	testtable::createTable();
	for ($i = 0; $i != 10; $i++)
	{
		$r = new testtable();
		$r->oo = $i;
		$r->asd = "test";
		$r->save();
	}
	
	$obj = testtable::objects()->idEQ(3)->get();
	print $obj->id;
	$obj->asd = "wichtig";
	$obj->save();
	$obj->delete();
	
	testtable::objects()->delete();*/
	
	#print_r(sql()->query("INSERT INTO test (column, asd) VALUES ('1', '123afwr'))"));
	#print_r (sql()->query("SELECT * FROM TEST"));
	#echo "test";
	#echo asd::objects()->aGT(11)->bEQ("asd")->cEQ(true)->orderByBDesc()->orderByStrAsc()->all()
	#print_r( table::objects()/*->columnEQ(1)->where("%s = %d", "asd", 12)*/->all());
	#table:: createTable();
	#echo "\n";
?>