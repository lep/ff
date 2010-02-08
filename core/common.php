<?php
	function error404(){
		header("HTTP/1.0 404 Not Found");
		die("404-Error");
	}
	
	function error405($req_m){
		header("HTTP/1.0 405 Method Not Allowed");
		header("Allow: $req_m");
		die("405-Error");
	}
	
	function redirect($to){
		header("Location: $to");
	}
	
	function post_only(){
		if($_SERVER['REQUEST_METHOD']!='POST')
			error405('POST');
	}
	
	function inc($f){
		global $server_dir, $controllername;
		
		$local_path=($server_dir .'/web/'. $controllername ."/inc/");
		$global_path=($server_dir .'/inc/');
		
		if(file_exists($local_path . $f .'.php')){
			include_once $local_path . $f .'.php';
		}elseif(file_exists($global_path . $f .'.php')){
			include_once $global_path . $f .'.php';
		}else{
			throw new ErrorNotFound("File ". $f ." not found");
		}
	}
?>
