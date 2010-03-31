<?php
	class auth extends controller{
		function install()
		{
			$this->model->user->createTable();
		}
		
		function index()
		{
			$user = $this->getUser();
			$this->template->assign("user", $user);
			$this->template->output("index.tpl");	
		}
		
		function create()
		{
			$this->createUser($_POST['name'], $_POST['password']);
		}
		
		function login()
		{
			if ($this->authUser($_POST['name'], $_POST['password']))
				print "ok";
			else
				print "wrong";
		}
	}

?>