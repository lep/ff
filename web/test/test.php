<?php
	error_Reporting(E_ALL);
	
	class test extends main{
		function add(){
			print'<pre>';
			$data = $this->postData->post;
			var_dump($data);
			print'</pre>';
		
		}

		function register(){
			print'<pre>';
			$data = $this->postData->register;
			var_dump($data);
			print'</pre>';
		}

		function index(){
			$this->template->output('index.tpl');
		}
	}
?>
