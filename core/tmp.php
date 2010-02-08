<?php

	abstract class Pdo_Singletone{
		private static $pdo_instance=null;

		private __copy(){}
		private __construct(){}

		static function &get($dsn, $username="", 
			$password="", $driver_options=array())
		{
			if(self::$pdo_instance===null){
				self::$pdo_instance=& new PDO($dsn, $username, 
												$password, $driver_options);
			}
			return &self::$pdo_instance;
		}	
	}

	abstract class sql{
		protected $pdo=null;
		protected $table_name;

		bstract function escapeString($str);
        function escapeInteger($int){
            return intval($int);
        }
        function escapeFloat($real){
            return floatval($real);
        }
        #abstract function escapeBinary($bin);

        function createArrayQuery($query, $args){
        #Nur ausführen, wenn wir weitere Parameter haben.
            $query=preg_replace('
                _\{(\w[\w\d]+)\}_',
                $this->table_name .'\1',
                $query
            );
            $offset=0;
            $pos=0;
            $q="";
            $len=strlen($query);
            $i=0;
            while(($pos=strpos($query, '%', $offset))!==false){
                if(isset($query[$pos+1])){
                    $type=$query[$pos+1];
                    if($type=='%'){
                        $q.=substr($query, $offset, $pos-$offset).'%';
                    }else{
                        $q.=substr($query, $offset, $pos-$offset);
                        if($type=='s'){
                            $q.=$this->escapeString($args[$i++]);
                        }elseif($type=='d'){
                            $q.=$this->escapeInteger($args[$i++]);
						 }elseif($type=='f'){
                            $q.=$this->escapeFloat($args[$i++]);
                        }else{
                            throw new SqlQueryException('Unknownd modifer');
                        }
                    }
                    $offset=$pos+2;
                }
            }
            $q.=substr($query, $offset);
            return $q;
        }

        function createQuery($query){
            $args=func_get_args();
            array_shift($args);

            return $this->createArrayQuery($query, $args);
        }

        function query($query){
            $args=func_get_args();
            array_shift($args);
            $query=$this->createArrayQuery($query, $args);
            return self::$pdo->instance->query($query);
        }


		function __construct($table_name){
			$this->table_name=$table_name;
		}

		function injectPdo(&$pdo){
			if($this->pdo!==null)
				$this->pdo=&$pdo;
		}
	}

	function sql(){
		global $controllername;
		static $sql=null;
		if($sql===null){
			#TODO Alle sql-typen klug (als ob) hier einbauen
			$sql=new Sqlite($controllername);
			$sql->injectPdo(Pdo_Singletone("sqlite:
		}
	}



?>
