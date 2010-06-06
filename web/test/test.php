<?php
	class test extends controller
	{
		function a(){
			print "hallo welt";
		}
		function wildcard(){
			print_r(func_get_args());
		}
		function pure(){
			$config = HTMLPurifier_Config::createDefault();
			$config->set('Core.Encoding', 'utf-8'); // replace with your encoding
			$config->set('HTML.Doctype', 'HTML 4.01 Transitional'); // replace with your doctype
			$config->set('HTML.Allowed', 'h1,h2');
			$purifier = new HTMLPurifier($config);
			header("Content-type: text/plain");
			#header("Content-Type: text/html; charset=UTF-8");
			echo $purifier->purify("<h1> <h2>");
			echo $_GET['A'];
			
		}
	}

?>