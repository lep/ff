<?php



	error_reporting(E_ALL);
	
	
	class auth_objects_user{
		var $cond;
		var $ord;
		var $sql;
		
		
		
		function __construct(){
			$this->cond = array();
			$this->ord = array();
			$this->sql = sql("auth_");
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
					
				
			
		
			
			
			
				
					function loginexpiredGE($to){
						$this->cond[]=
 
 	sql()->escapeInt($to)

.">= loginexpired";
						return $this;
					}
					
					function loginexpiredGT($to){
						$this->cond[]=
 
 	sql()->escapeInt($to)

."> loginexpired";
						return $this;
					}
					
					function loginexpiredEQ($to){
						$this->cond[]=
 
 	sql()->escapeInt($to)

."= loginexpired";
						return $this;
					}
					
					function loginexpiredLT($to){
						$this->cond[]=
 
 	sql()->escapeInt($to)

."> loginexpired";
						return $this;
					}
					
					function loginexpiredLE($to){
						$this->cond[]=
 
 	sql()->escapeInt($to)

."<= loginexpired";
						return $this;
					}
					
					
					function orderByLoginexpiredDesc(){
						$this->ord[] = "loginexpired DESC";
						return $this;
					}
					function orderByLoginexpiredAsc(){
						$this->ord[] = "loginexpired ASC";
						return $this;
					}
					
				
			
		
			
			
			
				
					function passwordEQ($to){
						$this->cond[]=

	sql()->escapeString($to)

."= password";
						return $this;
					}
					
					
					function orderByPasswordDesc(){
						$this->ord[] = "password DESC";
						return $this;
					}
					function orderByPasswordAsc(){
						$this->ord[] = "password ASC";
						return $this;
					}
					
				
			
		
			
			
			
				
					function sessionidEQ($to){
						$this->cond[]=

	sql()->escapeString($to)

."= sessionid";
						return $this;
					}
					
					
					function orderBySessionidDesc(){
						$this->ord[] = "sessionid DESC";
						return $this;
					}
					function orderBySessionidAsc(){
						$this->ord[] = "sessionid ASC";
						return $this;
					}
					
				
			
		
			
			
			
				
					function nameEQ($to){
						$this->cond[]=

	sql()->escapeString($to)

."= name";
						return $this;
					}
					
					
					function orderByNameDesc(){
						$this->ord[] = "name DESC";
						return $this;
					}
					function orderByNameAsc(){
						$this->ord[] = "name ASC";
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
			return ' FROM {user}';
		}
		
		private function  buildCompleteSelectClause(){
			return 'SELECT *'.
				$this->buildFromClause().
			    $this->buildWhereClause().
			    $this->buildOrderClause();
		}
		
		function delete()
		{
			$sql = "DELETE FROM {user} ".
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
			return auth_user::objectsFromRows($this->sql->query($sql));
		}
		
		function limit($limit){
			$sql = $this->buildCompleteSelectClause().
			    ' LIMIT '.
 
 	sql()->escapeInt($limit)

;
			return auth_user::objectsFromRows($this->sql->query($sql));
		}
		function all(){
			$sql = $this->buildCompleteSelectClause();
			return auth_user::objectsFromRows($this->sql->query($sql));
		}
		
		function get(){
			$sql = $this->buildCompleteSelectClause();
			$result = auth_user::objectsFromRows($this->sql->query($sql));
			if (count($result) == 0)
				throw new SqlError("user .get() found no row");
			return $result[0];
		}
		
		function create(){
			return new auth_user();
		}
		
		function createTable()
		{
			$sql = "CREATE TABLE {user} (
				
					
						id
						
							SERIAL
						
					,
					
						loginexpired
						INT
						
					,
					
						password
						
							TEXT
						
					,
					
						sessionid
						
							TEXT
						
					,
					
						name
						
							TEXT
						
					
				)";
				$this->sql->query($sql);
		}
		
		function dropTable()
		{
			$sql = "DROP TABLE {user}"  ;
			$this->sql->query($sql);
		}
		
	}
	
	class auth_user{
		
			
			
			private $id;
			
		
			
			
			var $loginexpired;
			
		
			
			
			var $password;
			
		
			
			
			var $sessionid;
			
		
			
			
			var $name;
			
		
		
		
		
		
		var $__get_schema = array(
		
			
			
				
					
				'id'
			
		
			
			
		
			
			
		
			
			
		
			
			
		
		);
	
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
		
		function __set($name, $what)
		{
			switch($name){
			
				
				
			
				
				
			
				
				
			
				
				
			
				
				
			
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
			
		
			
			
				$this->loginexpired = 0;
			
		
			
			
		
			
			
				$this->sessionid = "empty";
			
		
			
			
		
		}
		
		private function update(){
			$sql = "UPDATE {user} SET
			
			
				
				id =" .

	sql()->escapeInt($this->id)

."

			
			
				
					,
				
				loginexpired =" .
 
 	sql()->escapeInt($this->loginexpired)

."

			
			
				
					,
				
				password =" .

	sql()->escapeString($this->password)

."

			
			
				
					,
				
				sessionid =" .

	sql()->escapeString($this->sessionid)

."

			
			
				
					,
				
				name =" .

	sql()->escapeString($this->name)

."

			
			WHERE id = ".$this->id;
			sql(auth_)->query($sql);
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
			
				$object->id = $row['id'];
			
				$object->loginexpired = $row['loginexpired'];
			
				$object->password = $row['password'];
			
				$object->sessionid = $row['sessionid'];
			
				$object->name = $row['name'];
			
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
			$sql =  "INSERT INTO {user}(
				
				
					
				
					
						
							
						loginexpired
					
				
					
						,
						
						password
					
				
					
						,
						
						sessionid
					
				
					
						,
						
						name
					
				
				) VALUES (".
				
				
					
				
					
						
							
						
 
 	sql()->escapeInt($this->loginexpired)

.
					
				
					
						",".
						
						

	sql()->escapeString($this->password)

.
					
				
					
						",".
						
						

	sql()->escapeString($this->sessionid)

.
					
				
					
						",".
						
						

	sql()->escapeString($this->name)

.
					
						
				")";
			sql("auth_")->query($sql);
		}
		
		function save(){
			if ($this->id != False)
				$this->update();
			else
				$this->insert();
		}
		
		static function objects(){
			return new auth_objects_user();
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