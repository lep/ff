<?php



	error_reporting(E_ALL);
	
	
	class sqltest_objects_news{
		var $cond;
		var $ord;
		var $sql;
		function __construct(){
			$this->cond = array();
			$this->ord = array();
			$this->sql = sql("sqltest_");
		}
		
			
			
			
				function contentEQ($to){
					$this->cond[]=

	sql()->escapeString($to)

."= content";
					return $this;
				}
			
			
				function orderByContentDesc(){
					$this->ord[] = "content DESC";
					return $this;
				}
				function orderByContentAsc(){
					$this->ord[] = "content ASC";
					return $this;
				}
			
			
		
			
			
			
				function headlineEQ($to){
					$this->cond[]=

	sql()->escapeString($to)

."= headline";
					return $this;
				}
			
			
				function orderByHeadlineDesc(){
					$this->ord[] = "headline DESC";
					return $this;
				}
				function orderByHeadlineAsc(){
					$this->ord[] = "headline ASC";
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
			
			
		
			
			
			
				function timeGE($to){
					$this->cond[]=
 
 	sql()->escapeInt($to)

.">= time";
					return $this;
				}
			
				function timeGT($to){
					$this->cond[]=
 
 	sql()->escapeInt($to)

."> time";
					return $this;
				}
			
				function timeEQ($to){
					$this->cond[]=
 
 	sql()->escapeInt($to)

."= time";
					return $this;
				}
			
				function timeLT($to){
					$this->cond[]=
 
 	sql()->escapeInt($to)

."> time";
					return $this;
				}
			
				function timeLE($to){
					$this->cond[]=
 
 	sql()->escapeInt($to)

."<= time";
					return $this;
				}
			
			
				function orderByTimeDesc(){
					$this->ord[] = "time DESC";
					return $this;
				}
				function orderByTimeAsc(){
					$this->ord[] = "time ASC";
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
			return ' FROM {news}';
		}
		
		private function  buildCompleteSelectClause(){
			return 'SELECT *'.
				$this->buildFromClause().
			    $this->buildWhereClause().
			    $this->buildOrderClause();
		}
		
		function delete()
		{
			$sql = "DELETE FROM {news} ".
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
			return sqltest_news::objectsFromRows($this->sql->query($sql));
		}
		
		function limit($limit){
			$sql = $this->buildCompleteSelectClause().
			    ' LIMIT '.
 
 	sql()->escapeInt($limit)

;
			return sqltest_news::objectsFromRows($this->sql->query($sql));
		}
		function all(){
			$sql = $this->buildCompleteSelectClause();
			return sqltest_news::objectsFromRows($this->sql->query($sql));
		}
		
		function get(){
			$sql = $this->buildCompleteSelectClause();
			$result = sqltest_news::objectsFromRows($this->sql->query($sql));
			if (count($result) == 0)
				throw new SqlError("news .get() found no row");
			return $result[0];
		}
		
		function create(){
			return new sqltest_news();
		}
		
		function createTable()
		{
			$sql = "CREATE TABLE {news} (
				
					
						content
						
							TEXT
						
					,
					
						headline
						
							TEXT
						
					,
					
						id
						
							SERIAL
						
					,
					
						time
						INT
						
					
				)";
				$this->sql->query($sql);
		}
		
		function dropTable()
		{
			$sql = "DROP TABLE {news}"  ;
			$this->sql->query($sql);
		}
		
	}
	
	class sqltest_news{
		
			
			
			var $content;
			
		
			
			
			var $headline;
			
		
			
			
			private $id;
			
		
			
			
			var $time;
			
		
	
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
			
		
			
			
		
		}
		
		private function update(){
			$sql = "UPDATE {news} SET
			
			
				
				content =" .

	sql()->escapeString($this->content)

."

			
			
				
					,
				
				headline =" .

	sql()->escapeString($this->headline)

."

			
			
				
					,
				
				id =" .

	sql()->escapeInt($this->id)

."

			
			
				
					,
				
				time =" .
 
 	sql()->escapeInt($this->time)

."

			
			WHERE id = ".$this->id;
			sql(sqltest_)->query($sql);
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
			
				$object->content = $row['content'];
			
				$object->headline = $row['headline'];
			
				$object->id = $row['id'];
			
				$object->time = $row['time'];
			
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
			$sql =  "INSERT INTO {news}(
				
				
					
						
							
						content
					
				
					
						,
						
						headline
					
				
					
				
					
						,
						
						time
					
				
				) VALUES (".
				
					
						
						

	sql()->escapeString($this->content)

.
					
				
					
						','.
						

	sql()->escapeString($this->headline)

.
					
				
					
				
					
						','.
						
 
 	sql()->escapeInt($this->time)

.
					
						
				")";
			sql("sqltest_")->query($sql);
		}
		
		
		function save(){
			if ($this->id != False)
				$this->update();
			else
				$this->insert();
		}
		
		static function objects(){
			return new sqltest_objects_news();
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