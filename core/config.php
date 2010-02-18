<?php
	#TODO: use namespaces?
	error_reporting(E_ALL);
	/*
	Ich weiss nicht, ob das hier ein einziger Hack ist oder doch ganz
	nett und zu Gebrauchen...
	*/

	require_once $server_dir .'/lib/Yaml/sfYaml.php';

	class ConfigException
	extends Exception {}

	abstract class config{
		protected static $config =null;

		protected static function _load(){
			global $server_dir;
			if(self::$config===null){
				if(! file_exists($server_dir .'/config.yml')){
					throw new ErrorNotFound('Config not found');
				}
				self::$config=sfYaml::load($server_dir .'/config.yml');
					#spyc_load_file($server_dir .'/config.yml');
			}
		}

	}
	
	abstract class sql_config extends config{
		#TODO: add driver-options support
		private static function _get($data, $name, $required, $f=true){
			if(empty($data[$name]) && $required){
				#TODO: maybe use ErrorNotFound-exception?
				throw new ConfigException("Required value ($name) not set");
			}elseif(! empty($data[$name])){
				if($f)
					return "$name=". $data[$name] .";";
				else
					return @$data[$name];
			}
		}
	
		static function get(){
			self::_load();

			$sql= self::_get(self::$config, 'sql', true, false);
			$driver=self::_get($sql, 'driver', true, false);
			$dsn="$driver:";
			
			if($driver=='sqlite'){
				$dsn.=self::_get($sql, 'dbname', true, false);
				return array(
					'dsn'=>$dsn,
					'password'=>self::_get($sql, 'password', false, false),
					'user'=>''
				);
				
			}elseif($driver=='sqlite2'){
				$dsn.=self::_get($sql, 'dbname', true, false);
				return array('dsn'=>$dsn, 'password'=>'', 'user'=>'');
				
			}elseif($driver=='mysql' || $driver=='pgsql'){
				$dsn.=self::_get($sql, 'dbname', true);
				$dsn.=self::_get($sql, 'host', true);
				$dsn.=self::_get($sql, 'port', false);
				return array(
					'dsn'=>$dsn,
					'password'=>self::_get($sql, 'password', true, false),
					'user'=>self::_get($sql, 'user', true, false)
				);
				
			}else{
				throw new ConfigException('Driver not supported');
			}
		}
	}


?>
