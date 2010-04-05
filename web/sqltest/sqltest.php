<?php

	class sqltest extends controller
	{
		function index()
		{
			$this->module->moduletest->oO();
			$news = $this->model->news->orderByTimeAsc()->limit(10);
			$this->template->assign("news", $news);
			$this->template->output("main.tpl");
		}
		
		function add()
		{
			$news = $this->model->news->create();
			$news->content = $_POST['content'];
			$news->headline = $_POST['headline'];
			$news->author = $this->model->author->nameEQ("peter")->get();
			
			$news->save();
		}
		
		function remove($which)
		{
			$this->model->news->idEQ($which)->delete();
			redirect('../..');
		}
		
		function install()
		{
			$this->model->author->createTable();
			$a = $this->model->author->create();
			$a->name = "peter";
			$a->save();
			echo "good";
		}
	}

?>
