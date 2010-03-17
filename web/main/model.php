<?php



	error_reporting(E_ALL);
	
	
	class main_objects_testtable{
		var $cond;
		var $ord;
		var $sql;
		function __construct(){
			$this->cond = array();
			$this->ord = array();
			$this->sql = sql("main_");
		}
		
			
			
			
				function ooGE($to){
					$this->cond[]=
 
 	sql()->escapeInt($to)

.">= oo";
					return $this;
				}
			
				function ooGT($to){
					$this->cond[]=
 
 	sql()->escapeInt($to)

."> oo";
					return $this;
				}
			
				function ooEQ($to){
					$this->cond[]=
 
 	sql()->escapeInt($to)

."= oo";
					return $this;
				}
			
				function ooLT($to){
					$this->cond[]=
 
 	sql()->escapeInt($to)

."> oo";
					return $this;
				}
			
				function ooLE($to){
					$this->cond[]=
 
 	sql()->escapeInt($to)

."<= oo";
					return $this;
				}
			
			
				function orderByOoDesc(){
					$this->ord[] = "oo DESC";
					return $this;
				}
				function orderByOoAsc(){
					$this->ord[] = "oo ASC";
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
		
		function delete()
		{
			$sql = "DELETE FROM {testtable} ".
				$this->buildWhereClause();
			$this->sql->query($sql);
		}
		

		
		function offsetAndLimit($offset, $limit){
			$sql = $this->buildCompleteSelectClause().
			    ' LIMIT '.
 
 	sql()->escapeInt($limit)

.' OFFSET '.
 
 	sql()->escapeInt($offset)

;
			return main_testtable::objectsFromRows($this->sql->query($sql));
		}
		
		function limit($limit){
			$sql = $this->buildCompleteSelectClause().
			    ' LIMIT '.
 
 	sql()->escapeInt($limit)

;
			return main_testtable::objectsFromRows($this->sql->query($sql));
		}
		function all(){
			$sql = $this->buildCompleteSelectClause();
			return main_testtable::objectsFromRows($this->sql->query($sql));
		}
		
		function get(){
			$sql = $this->buildCompleteSelectClause();
			$result = main_testtable::objectsFromRows($this->sql->query($sql));
			if (count($result) == 0)
				throw new SqlError("testtable .get() found no row");
			return $result[0];
		}
		
		function create(){
			return new main_testtable();
		}
		
		function createTable()
		{
			$sql = "CREATE TABLE {testtable} (
				
					
						oo
						INT
						
					,
					
						id
						
							SERIAL
						
					,
					
						asd
						
							TEXT
						
					
				)";
				$this->sql->query($sql);
		}
		
		function dropTable()
		{
			$sql = "DROP TABLE {testtable}"  ;
			$this->sql->query($sql);
		}
		
	}
	
	class main_testtable{
		
			
			
			var $oo;
			
		
			
			
			private $id;
			
		
			
			
			var $asd;
			
		
	
		function __get($name)
		{
			switch($name){
			
				
				
			
				
				
					case 'id':
						return $this->id;
				
			
				
				
			
			}
			
			$trace = debug_backtrace();
		        trigger_error(
		            'Undefined property via __get(): ' . $name .
		            ' in ' . $trace[0]['file'] .
		            ' on line ' . $trace[0]['line'],
		            E_USER_NOTICE);
		        return null;
		}
	
		function __construct(){
		
			
			
		
			
			
				$this->id = False;
			
		
			
			
				$this->asd = 1;
			
		
		}
		
		private function update(){
			$sql = "UPDATE {testtable} SET
			
			
				
				oo =" .
 
 	sql()->escapeInt($this->oo)

."

			
			
				
					,
				
				id =" .

	sql()->escapeInt($this->id)

."

			
			
				
					,
				
				asd =" .

	sql()->escapeString($this->asd)

."

			
			WHERE id = ".$this->id;
			sql(main_)->query($sql);
		}
		
		function delete()
		{
			if ($this->id == False)
				throw new SqlError(" tried to delete object no stored in db");
			
			self::objects()->idEQ($this->id)->delete();
			
		}
		
		static function objectFromRow($row)
		{
			$object = new self();
			#this does no checking at all. Don't be evil!
			
				$object->oo = $row['oo'];
			
				$object->id = $row['id'];
			
				$object->asd = $row['asd'];
			
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
			$sql =  "INSERT INTO {testtable}(
				
				
					
						
							
						oo
					
				
					
				
					
						,
						
						asd
					
				
				) VALUES (".
				
					
						
						
 
 	sql()->escapeInt($this->oo)

.
					
				
					
				
					
						','.
						

	sql()->escapeString($this->asd)

.
					
						
				")";
			sql("main_")->query($sql);
		}
		
		
		function save(){
			if ($this->id != False)
				$this->update();
			else
				$this->insert();
		}
		
		static function objects(){
			return new main_objects_testtable();
		}
		
	}
		
	
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