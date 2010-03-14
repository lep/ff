

<?php
	error_reporting(E_ALL);
	
	
	class FETCH_testtable{
		var $cond;
		var $ord;
		var $sql;
		function __construct(){
			$this->cond = array();
			$this->ord = array();
			$this->sql = sql();
		}
		
			
			
			
				function oOGE($to){
					$this->cond[]=
 
 	$this->sql->escapeInt($to)

.">= oO";
					return $this;
				}
			
				function oOGT($to){
					$this->cond[]=
 
 	$this->sql->escapeInt($to)

."> oO";
					return $this;
				}
			
				function oOEQ($to){
					$this->cond[]=
 
 	$this->sql->escapeInt($to)

."= oO";
					return $this;
				}
			
				function oOLT($to){
					$this->cond[]=
 
 	$this->sql->escapeInt($to)

."> oO";
					return $this;
				}
			
				function oOLE($to){
					$this->cond[]=
 
 	$this->sql->escapeInt($to)

."<= oO";
					return $this;
				}
			
			
				function orderByOoDesc(){
					$this->ord[] = "oO DESC";
					return $this;
				}
				function orderByOoAsc(){
					$this->ord[] = "oO ASC";
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
			return ' FROM {testtable}';
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
	
	class testtable{
		
			var $oO;
		
			var $asd;
		
		function __construct(){
		
			
			
		
			
			
				$this->asd = 1;
			
		
		}
		
		private function update(){
			
		}
		
		private function insert(){
			return "INSERT INTO testtable(
				
				) VALUES ("
						
				.")";
		}
		
		static function createTable()
		{
			$sql = "CREATE TABLE testtable (
				
					
						oO
						INT
						
					,
					
						asd
						
							TEXT
						
					
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
			return new FETCH_testtable();
		}
	}
		

	testtable::createTable();
	
	#print_r(sql()->query("INSERT INTO test (column, asd) VALUES ('1', '123afwr'))"));
	#print_r (sql()->query("SELECT * FROM TEST"));
	#echo "test";
	#echo asd::fetch()->aGT(11)->bEQ("asd")->cEQ(true)->orderByBDesc()->orderByStrAsc()->all()
	#print_r( table::fetch()/*->columnEQ(1)->where("%s = %d", "asd", 12)*/->all());
	#table:: createTable();
	#echo "\n";
?>