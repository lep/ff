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
	
	
	abstract class controller{
		protected $template;
		
		const NOSQL = 0x1;
		const NOTEMPLATE = 0x2;
		const NOORM = 0x4;
		
		function __construct($opts = 0){
			global $server_dir, $web_dir;
			$controllername = get_class($this);
			if (($opts & controller::NOTEMPLATE) == 0){
				$this->template = new Template($controllername);
				$this->template->assign("dir", 
							array('server'=>$server_dir, 'web'=>$web_dir));
			}
			if (($opts & controller::NOSQL) == 0){
				$this->sql = sql($controllername);
			}
			
			if ((($opts & controller::NOSQL) == 0) && (($opts & controller::NOORM)) == 0){
				$this->model = new modelhelper($controllername);
			}
			
			
		}
	}
?>