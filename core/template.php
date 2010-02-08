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

			#TODO: add multiple directories
			$loader= new Twig_Loader_Filesystem(
					$server_dir .'/web/'. $controller .'/template/');
			$this->twig= new Twig_Environment($loader, array(
				'cache'=> $server_dir .'/tmp/twig/cache/'
			));
			
			$this->controller = $controller;
			$this->data=array();
		}

		function assign($key, $value){
			$this->data[$key]=$value;
		}

		function output($file){
			global $server_dir;
			
			$path= $server_dir .'/web/'. 
					$this->controller .'/template/'. $file;
			if(! file_exists($path)){
				throw new ErrorNotFound("Template ". $file ." not found");
			}
			$template = $this->twig->loadTemplate($file);
			echo $template->render($this->data);
		}
	}

?>
