<?php
	error_Reporting(E_ALL);
	include_once($server_dir."/dwoo/dwooAutoload.php");
	
	class Template{
		private $data;
		private $dwoo;
		function __construct($controller)
		{
			$this->controller = $controller;
			$this->dwoo = new Dwoo();
			$this->data = new Dwoo_Data();
		}
		
		function assign($key, $value){
			$this->data->assign($key, $value);
		}
		
		function output($file){
			global $server_dir;
			$path = "/web/". $this->controller ."/template/". $file;
			$absolutepath = $server_dir.$path;
			if (file_exists($absolutepath))
				$this->dwoo->output($absolutepath, $this->data);
			else
				throw new ErrorNotFound("Template '".$file."' not found");
		}
	
	}

	require_once $server_dir .'/core/twig/lib/Autoloader.php';
	class TwigTemplate{
		private $data;
		private $twig;
		private $controller

		function __construct($controller){
			global $server_dir;

			#TODO: add multiple directories
			$loader= new Twig_Loader_Filesystem(
					$server_dir .'/web/'. $controller .'/templates/');
			$this->twig= new Twig_Enviroment($loader, array(
				'cache'=> $server_dir .'/core/twig/cache/'
			));

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
			$this->twig->display($this->data);
		}
	}

?>
