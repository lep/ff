<?php

	class modelhelper{
		private $name;
		
		function __construct($name){
			$this->name = $name;
		}
		
		function __get($name){
			return dispatcher::loadModel($this->name, $name)->objects();
		}
		
	}
	
	class modulehelper{
		function __get($name){
			return dispatcher::loadModule($name);
		}
		
	}
	
	abstract class basecontroller{
		const NOSQL = 0x1;
		const NOTEMPLATE = 0x2;
		const NOORM = 0x4;
		
		function __construct($name, $opts = 0){
			if (($opts & self::NOSQL) == 0){
				$this->sql = sql($name);
			}
			
			if ((($opts & self::NOSQL) == 0) && (($opts & self::NOORM)) == 0){
				$this->model = new modelhelper($name);
			}
			
			
		}
	}
	
	abstract class module extends basecontroller{
		
	}
	
	
	abstract class controller extends basecontroller{
		protected $template;
		
		const NOTEMPLATE = 0x2;
		const NOMODULE = 0x8;
		
		function __construct($name, $opts = 0){
			parent::__construct($name, $opts);
			
			global $server_dir, $web_dir;
			
			if (($opts & controller::NOTEMPLATE) == 0){
				$this->template = new Template($name);
				$this->template->assign("dir", 
							array('server'=>$server_dir, 
							      'web'=>$web_dir,
							      'controller'=>$server_dir.
							         "/web/".$name.
							         "/template/"
							));
			}
			if (($opts & self::NOMODULE) == 0)
			{
				$this->module = new modulehelper();
			}
			
		}
	}
?>