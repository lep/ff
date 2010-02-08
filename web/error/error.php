<?php
class error extends Controller{
	function notallowed($error, $trace){
		$this->template->assign("title", "403 - Forbidden");
		$this->template->assign("error", $error);
		$this->template->assign("trace", $trace);
		//FIXME check if referrer is set^
		$this->template->assign("referrer", @$_SERVER['HTTP_REFERER']);
		$this->template->output("error.tpl");
	}
	function notfound($error, $trace){
		$this->template->assign("title", "404 - Not found");
		$this->template->assign("error", $error);
		$this->template->assign("trace", $trace);
		$this->template->assign("referrer",@ $_SERVER['HTTP_REFERER']);
		$this->template->output("error.tpl");
	}
}

?>
