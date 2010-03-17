<?php
	error_Reporting(E_ALL);

	require_once $server_dir .'/lib/Twig/Autoloader.php';
	Twig_Autoloader::register();

	class Template{
		private $data;
		private $twig;
		private $controller;

		function __construct($controller){
			global $server_dir;
			
			#print "Con $controller ";
			
			$this->controller = $controller;
			$this->data=array();
			
			$path=array();
			foreach(classHierachy($this->controller) as $class){
				if($class!="controller")
					$path[]= $server_dir .'/web/'. $class .'/template/';
			}
			#print_r($path);

			$loader= new Twig_Loader_Filesystem($path);
			$this->twig= new Twig_Environment($loader, array(
				'cache'=> $server_dir .'/tmp/twig/cache/'
			));
			
			
		}

		function assign($key, $value){
			$this->data[$key]=$value;
		}

		function output($file){
			global $server_dir;
			
			#$path= $server_dir .'/web/'. 
			#		$this->controller .'/template/'. $file;
			#if(! file_exists($path)){
			#	throw new ErrorNotFound("Template ". $file ." not found");
			#}
			$template = $this->twig->loadTemplate($file);
			echo $template->render($this->data);
		}
	}

?>