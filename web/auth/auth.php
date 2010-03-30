<?php
	class auth extends controller{
		function install()
		{
			$this->model->user->createTable();
		}
	}

?>