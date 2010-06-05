<?php

	class articles extends controller{
		function show(id){
			$article = $this->model->article->idEQ(id)->get();
			$this->template->assign("article", $article);
			$this->template->output("show.tpl");
		}
		function create(){
			
		}
	}

?>