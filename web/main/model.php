

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
 
 	sql()->escapeInt($to)

.">= oO";
					return $this;
				}
			
				function oOGT($to){
					$this->cond[]=
 
 	sql()->escapeInt($to)

."> oO";
					return $this;
				}
			
				function oOEQ($to){
					$this->cond[]=
 
 	sql()->escapeInt($to)

."= oO";
					return $this;
				}
			
				function oOLT($to){
					$this->cond[]=
 
 	sql()->escapeInt($to)

."> oO";
					return $this;
				}
			
				function oOLE($to){
					$this->cond[]=
 
 	sql()->escapeInt($to)

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
			
			
		
			
			
			
				function idGE($to){
					$this->cond[]=

	sql()->escapeInt($to)

.">= id";
					return $this;
				}
			
				function idGT($to){
					$this->cond[]=

	sql()->escapeInt($to)

."> id";
					return $this;
				}
			
				function idEQ($to){
					$this->cond[]=

	sql()->escapeInt($to)

."= id";
					return $this;
				}
			
				function idLT($to){
					$this->cond[]=

	sql()->escapeInt($to)

."> id";
					return $this;
				}
			
				function idLE($to){
					$this->cond[]=

	sql()->escapeInt($to)

."<= id";
					return $this;
				}
			
			
				function orderByIdDesc(){
					$this->ord[] = "id DESC";
					return $this;
				}
				function orderByIdAsc(){
					$this->ord[] = "id ASC";
					return $this;
				}
			
			
		
			
			
			
				function asdEQ($to){
					$this->cond[]=

	sql()->escapeString($to)

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
			if (count($this->cond)>0)
				return ' WHERE '.implode(' AND ', $this->cond);
			else 
				return "";
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
		
			var $id;
		
			var $asd;
		
		function __construct(){
		
			
			
		
			
			
				$this->id = False;
			
		
			
			
				$this->asd = 1;
			
		
		}
		
		private function update(){
			echo "updates";
			$sql = "UPDATE testtable SET
			
			
				oO =" .$this->oO."
				
				,
				
			
			
				id =" .$this->id."
				
				,
				
			
			
				asd =" .$this->asd."
				
			
			WHERE id = ".$this->id;
			echo "update";
			sql()->query($sql);
		}
		
		private function insert(){
			echo "inserts";
			$sql =  "INSERT INTO testtable(
				
					
						
						oO
					
				
					
				
					
						,
						asd
					
				
				) VALUES (".
				
					
						
						
 
 	sql()->escapeInt($this->oO)

.
					
				
					
				
					
						','.
						

	sql()->escapeString($this->asd)

.
					
						
				")";
				echo "insert";
			sql()->query($sql);
		}
		
		static function createTable()
		{
			$sql = "CREATE TABLE testtable (
				
					
						oO
						INT
						
					,
					
						id
						
							SERIAL
						
					,
					
						asd
						
							TEXT
						
					
				)";
				sql()->query($sql);
		}
		
		static function dropTable()
		{
			$sql = "DROP TABLE testtable";
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
			return new FETCH_testtable();
		}
	}
		
	
	#testtable::dropTable();
	#testtable::createTable();
	$r = new testtable();
	$r->oO = 11;
	$r->asd = "test";
	$r->save();
	#testtable::dropTable();
	#testtable::createTable();
	
	#print_r(sql()->query("INSERT INTO test (column, asd) VALUES ('1', '123afwr'))"));
	#print_r (sql()->query("SELECT * FROM TEST"));
	#echo "test";
	#echo asd::fetch()->aGT(11)->bEQ("asd")->cEQ(true)->orderByBDesc()->orderByStrAsc()->all()
	#print_r( table::fetch()/*->columnEQ(1)->where("%s = %d", "asd", 12)*/->all());
	#table:: createTable();
	#echo "\n";
?>