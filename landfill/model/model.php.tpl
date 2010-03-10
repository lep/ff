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
					$this->cond[]=$this->sql->
					{% if type == "id"%}
						escapeInt($to)
					{% elif type == "int"%} 
						escapeInt($to)
					{% elif type == "string"%}
						escapeString($to)
					{% elif type == "float"%}
						escapeFloat($to)
					{% endif%}
						."{{operations[type][op]}} {{columnname}}";
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
			return $this;
		}
		
		private function buildOrderClause(){
			if (count($this->ord)>0)
				return " ORDER BY ".implode(',', $this->ord);
			else
				return "";
		}
		
		private function buildWhereClause(){
			return ' WHERE '.implode(' AND ', $this->cond);
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
			return $this->buildCompleteSelectClause();
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
			
		}
		
		private function insert(){
			return "INSERT INTO {{tablename}}(
				{{columns|join(",")}}
				) VALUES ("
				{% for columnname in columns%}
					.$this->{{ columnname }}.
					{% if not loop.last %}
					.','.
					{% endif %}
				{% endfor %}		
				.")";
		}
		
		
		function save(){
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
	#echo asd::fetch()->aGT(11)->bEQ("asd")->cEQ(true)->orderByBDesc()->orderByStrAsc()->all();
	echo "\n";
?>