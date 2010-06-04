<?php
	class test extends controller
	{
		function a(){
			print "hallo welt";
		}
		function wildcard(){
			print_r(func_get_args());
		}
	}

?>