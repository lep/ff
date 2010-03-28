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
			$this->model->news->dropTable();
			$this->model->news->createTable();
			
			$this->model->author->dropTable();
			$this->model->author->createTable();
			$a = $this->model->author->create();
			$a->name = "peter";
			$a->save();
			echo "good";
		}
	}

?>

