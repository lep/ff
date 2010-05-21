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
		
			
			
			
				
					function nameGT($to){
						$this->cond[]="name > ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function nameLIKE($to){
						$this->cond[]="name  LIKE  ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function nameLT($to){
						$this->cond[]="name > ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function nameGE($to){
						$this->cond[]="name >= ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function nameLE($to){
						$this->cond[]="name <= ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function nameEQ($to){
						$this->cond[]="name = ".

	sql()->escapeString($to)

;
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
					
				
			
		
			
			
			
				
					function sessionidGT($to){
						$this->cond[]="sessionid > ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function sessionidLIKE($to){
						$this->cond[]="sessionid  LIKE  ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function sessionidLT($to){
						$this->cond[]="sessionid > ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function sessionidGE($to){
						$this->cond[]="sessionid >= ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function sessionidLE($to){
						$this->cond[]="sessionid <= ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function sessionidEQ($to){
						$this->cond[]="sessionid = ".

	sql()->escapeString($to)

;
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
					
				
			
		
			
			
			
				
					function loginexpiredGE($to){
						$this->cond[]="loginexpired >= ".
 
 	sql()->escapeInt($to)

;
						return $this;
					}
					
					function loginexpiredGT($to){
						$this->cond[]="loginexpired > ".
 
 	sql()->escapeInt($to)

;
						return $this;
					}
					
					function loginexpiredEQ($to){
						$this->cond[]="loginexpired = ".
 
 	sql()->escapeInt($to)

;
						return $this;
					}
					
					function loginexpiredLT($to){
						$this->cond[]="loginexpired > ".
 
 	sql()->escapeInt($to)

;
						return $this;
					}
					
					function loginexpiredLE($to){
						$this->cond[]="loginexpired <= ".
 
 	sql()->escapeInt($to)

;
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
					
				
			
		
			
			
			
				function testEQ($to){
					$this->cond[]=
 
 	sql()->escapeInt($to->id)

." =  test";
					return $this;
				}
			
		
			
			
			
				
					function passwordGT($to){
						$this->cond[]="password > ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function passwordLIKE($to){
						$this->cond[]="password  LIKE  ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function passwordLT($to){
						$this->cond[]="password > ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function passwordGE($to){
						$this->cond[]="password >= ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function passwordLE($to){
						$this->cond[]="password <= ".

	sql()->escapeString($to)

;
						return $this;
					}
					
					function passwordEQ($to){
						$this->cond[]="password = ".

	sql()->escapeString($to)

;
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
					
				
			
		
			
			
			
				
					function idGE($to){
						$this->cond[]="id >= ".

	sql()->escapeInt($to)

;
						return $this;
					}
					
					function idGT($to){
						$this->cond[]="id > ".

	sql()->escapeInt($to)

;
						return $this;
					}
					
					function idEQ($to){
						$this->cond[]="id = ".

	sql()->escapeInt($to)

;
						return $this;
					}
					
					function idLT($to){
						$this->cond[]="id > ".

	sql()->escapeInt($to)

;
						return $this;
					}
					
					function idLE($to){
						$this->cond[]="id <= ".

	sql()->escapeInt($to)

;
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
				
					
						name
						
							TEXT
						
					,
					
						sessionid
						
							TEXT
						
					,
					
						loginexpired
						INT
						
					,
					
						test
						
							INT
					,
					
						password
						
							TEXT
						
					,
					
						id
						
							SERIAL
						
					
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
		
			
			
			var $name;
			
		
			
			
			var $sessionid;
			
		
			
			
			var $loginexpired;
			
		
			
			
			private $test;
			private $_foreign_test = False;
			
		
			
			
			var $password;
			
		
			
			
			private $id;
			
		
		
		
		
		
		var $__get_schema = array(
		
			
			
		
			
			
		
			
			
		
			
			
				
					
					'test'
			
		
			
			
		
			
			
				,
				
				'id'
			
		
		);
	
		function __get($name)
		{
			switch($name){
			
				
				
			
				
				
			
				
				
			
				
				
					case 'test':
						if($this->_foreign_test == false)
							return $this->_load_test();
						else
							return $this->_foreign_test;
				
			
				
				
			
				
				
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
			
				
				
			
				
				
			
				
				
			
				
				
					case 'test':
						$this->_foreign_test = $what;
						$this->test = $what->id;
						return;
				
			
				
				
			
				
				
			
			}
			
			$trace = debug_backtrace();
		        trigger_error(
		            'Undefined property via __get(): ' . $name .
		            ' in ' . $trace[0]['file'] .
		            ' on line ' . $trace[0]['line'],
		            E_USER_NOTICE);
		        return null;
		}
		
		
			
			
			
		
			
			
			
		
			
			
			
		
			
			
			
				function _load_test()
				{
					$this->_foreign_test = 
					
						dispatcher::loadModel("ab", "b")->objects()
					
					->idEQ($this->test)->get();
					return $this->_foreign_test;
				}
			
		
			
			
			
		
			
			
			
		
	
		function __construct(){
		
			
			
		
			
			
				$this->sessionid = "empty";
			
		
			
			
				$this->loginexpired = 0;
			
		
			
			
		
			
			
		
			
			
				$this->id = False;
			
		
		}
		
		private function update(){
			$sql = "UPDATE {user} SET
			
			
				
				name =" .

	sql()->escapeString($this->name)

."

			
			
				
					,
				
				sessionid =" .

	sql()->escapeString($this->sessionid)

."

			
			
				
					,
				
				loginexpired =" .
 
 	sql()->escapeInt($this->loginexpired)

."

			
			
				
					,
				
				test =" .

	sql()->escapeInt($this->test)

."

			
			
				
					,
				
				password =" .

	sql()->escapeString($this->password)

."

			
			
				
					,
				
				id =" .

	sql()->escapeInt($this->id)

."

			
			WHERE id = ".$this->id;
			sql("auth_")->query($sql);
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
			
				$object->name = $row['name'];
			
				$object->sessionid = $row['sessionid'];
			
				$object->loginexpired = $row['loginexpired'];
			
				$object->test = $row['test'];
			
				$object->password = $row['password'];
			
				$object->id = $row['id'];
			
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
				
				
					
						
							
						name
					
				
					
						,
						
						sessionid
					
				
					
						,
						
						loginexpired
					
				
					
						,
						
						test
					
				
					
						,
						
						password
					
				
					
				
				) VALUES (".
				
				
					
						
							
						

	sql()->escapeString($this->name)

.
					
				
					
						",".
						
						

	sql()->escapeString($this->sessionid)

.
					
				
					
						",".
						
						
 
 	sql()->escapeInt($this->loginexpired)

.
					
				
					
						",".
						
						

	sql()->escapeInt($this->test)

.
					
				
					
						",".
						
						

	sql()->escapeString($this->password)

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