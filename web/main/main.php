<?php
	error_Reporting(E_ALL);
	class main extends controller{
		function index(){
			$this->template->output('index.tpl');
			$this->model->testtable->create();
		}
	}
?>