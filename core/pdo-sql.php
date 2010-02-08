<?php
	error_reporting(E_ALL);

	class SqlException
	extends Exception{}
	
	class SqlQueryException
	extends SqlException{}

	abstract class sql extends PDO{
	
		abstract function escape($val);
	
		private $cache;
	
		protected function createQuery($query){
			#Nur ausführen, wenn wir weitere Parameter haben.
			$query=preg_replace('_\{(\w[\w\d]+)\}_', DB_PREFIX .'\1', $query); 
			$offset=0;
			$pos=0;
			$q="";
			$len=strlen($query);
			$i=0;
			$binds=array();
			while(($pos=strpos($query, '%', $offset))!==false){
				if(isset($query[$pos+1])){
					$type=$query[$pos+1];
					if($type=='%'){
						$q.=substr($query, $offset, $pos-$offset).'%';
					}else{
						$q.=substr($query, $offset, $pos-$offset);
						if($type=='s'){
							#$q.=$this->escape($args[$i++]);
							$binds[]=PDO::PARAM_STR;
						}elseif($type=='d'){
							#$q.=intval($args[$i++]);
							$binds[]=PDO::PARAM_INT;
						}elseif($type=='f'){
							#$q.=floatval($args[$i++]);
							$binds[]=PDO::PARAM_FLOAT;
						}else{
							throw new SqlQueryException('Unknownd modifer');
						}
						$q.='?';
					}
					$offset=$pos+2;
				}
			}
			$q.=substr($query, $offset);
			return array($binds, $q);
		}
	
		function __construct($dsn, $username='', $password='', $driver_options=array()){
			try{
				parent::__construct($dsn, $username, $password, $driver_options);
			}catch(PDOException $e){
				throw new SqlException('Connection failed: '. $e->getMessage());
			}
			$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->cache=array();
		}
		
		function prepare($q){
		
			list($binds, $query)=$this->createQuery($q);
			$args=func_get_args();
			array_shift($args);
			if(sizeof($args) != sizeof($binds)){
				throw new SqlQueryException('Wrong num of attributes');
			}
			
			$statement=parent::prepare($query);
			$i=1;
			foreach($binds as $type){
				$value=array_shift($args);
				if($type==PDO::PARAM_STR){
					$value=$this->escape($value);
				}
				$statement->bindValue($i, $value, $type);
				$i++;
			}
			return $statement;
		}
	
	}
	
	function sql(){
		//FIXME
		global $server_dir;
		if(DB_TYPE=='sqlite2'){
			require_once $server_dir .'/core/sql-driver/sqlite2.php';
			return new sqlite2('sqlite2:' . $server_dir .'/'. DB_NAME);
		}
		
		else{
			throw new SqlException('Unknown driver');
		}
	}

?>
