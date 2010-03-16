<?php
	error_Reporting(E_ALL);
	include_once($server_dir."web/main/model.php");
	class main extends controller{
		function index(){
			$this->template->output('index.tpl');
			$this->model->testtable->create();
		}
	}
?>