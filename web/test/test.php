<?php
	error_Reporting(E_ALL);
	
	class test extends main{
		function index(){
			$this->template->output('index.tpl');
		}
	}
?>