<?php
	error_Reporting(E_ALL);
	class main extends controller{
		function index(){
			$this->template->output('index.tpl');
		}
		function wildcard(){
			echo "<h1>Fallback to main.wildcard</h1>";
			echo "<p>Got arguments:<p>";
			echo "<pre>";
			print_r(func_get_args());
			echo "</pre>";
		}
	}
?>