

<?php
	error_reporting(E_ALL);
	
	
	class FETCH_table{
		var $cond;
		var $ord;
		var $sql;
		function __construct(){
			$this->cond = array();
			$this->ord = array();
			$this->sql = sql();
		}
		
			
			
			
				function columnGE($to){
					$this->cond[]=
 
 	$this->sql->escapeInt($to)

.">= column";
					return $this;
				}
			
				function columnGT($to){
					$this->cond[]=
 
 	$this->sql->escapeInt($to)

."> column";
					return $this;
				}
			
				function columnEQ($to){
					$this->cond[]=
 
 	$this->sql->escapeInt($to)

."= column";
					return $this;
				}
			
				function columnLT($to){
					$this->cond[]=
 
 	$this->sql->escapeInt($to)

."> column";
					return $this;
				}
			
				function columnLE($to){
					$this->cond[]=
 
 	$this->sql->escapeInt($to)

."<= column";
					return $this;
				}
			
			
				function orderByColumnDesc(){
					$this->ord[] = "column DESC";
					return $this;
				}
				function orderByColumnAsc(){
					$this->ord[] = "column ASC";
					return $this;
				}
			
			
		
			
			
			
				function asdEQ($to){
					$this->cond[]=

	$this->sql->escapeString($to)

."= asd";
					return $this;
				}
			
			
				function orderByAsdDesc(){
					$this->ord[] = "asd DESC";
					return $this;
				}
				function orderByAsdAsc(){
					$this->ord[] = "asd ASC";
					return $this;
				}
			
			
		
		
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
			return ' WHERE '.implode(' AND ', $this->cond);
		}
		
		private function buildFromClause(){
			return ' FROM {table}';
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
			echo $sql;
			return $this->sql->query($sql);
		}
		
	}
	
	class table{
		
			var $column;
		
			var $asd;
		
		function __construct(){
		
			
			
		
			
			
				$this->asd = 1;
			
		
		}
		
		private function update(){
			
		}
		
		private function insert(){
			return "INSERT INTO table(
				
				) VALUES ("
						
				.")";
		}
		
		static function createTable()
		{
			$sql = "CREATE TABLE (
				
					
						column
						INT
						
					,
					
						asd
						INT
						
					
				)";
				sql()->query($sql);
		}
		
		function save(){
			if ($this->id != False)
				$this->update();
			else
				$this->insert();
		}
		
		static function fetch(){
			return new FETCH_table();
		}
	}
	
	#table::createTable();
	
	#print_r(sql()->query("INSERT INTO test (column, asd) VALUES ('1', '123afwr'))"));
	#print_r (sql()->query("SELECT * FROM TEST"));
	#echo "test";
	#echo asd::fetch()->aGT(11)->bEQ("asd")->cEQ(true)->orderByBDesc()->orderByStrAsc()->all()
	#print_r( table::fetch()/*->columnEQ(1)->where("%s = %d", "asd", 12)*/->all());
	#table:: createTable();
	#echo "\n";
?>