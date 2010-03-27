<?php

	class sqltest extends controller
	{
		function index()
		{
			$news = $this->model->news->orderByTimeAsc()->limit(10);
			$this->template->assign("news", $news);
			$this->template->output("main.tpl");
		}
		
		function add()
		{
			$news = $this->model->news->create();
			$news->content = $_POST['content'];
			$news->headline = $_POST['headline'];
			$news->data = time();
			$news->save();
		}
		
		function remove($which)
		{
			$this->model->idEQ($witch)->delete();
			redirect('../');
		}
		
		function install()
		{
			$this->model->news->createTable();
			echo "good";
		}
	}

?>