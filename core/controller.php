<?php
	abstract class controller{
		protected $template;
		
		function __construct(){
			global $server_dir, $web_dir;
			$controllername = get_class($this);
			$this->template = new Template($controllername);
			$this->template->assign("dir", 
						array('server'=>$server_dir, 'web'=>$web_dir));
			
			//$this->sql = sql();
		}
	}
?>
