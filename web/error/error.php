<?php
class error extends Controller{
	function __construct(){
		parent::__construct(controller::NOSQL);
	}
	
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
	//TODO: fix typo :)
	function unkownexception($error, $trace){
		$this->template->assign("title", "Unknown exception");
		$this->template->assign("error", $error);
		$this->template->assign("trace", $trace);
		//FIXME check if referrer is set^
		$this->template->assign("referrer", @$_SERVER['HTTP_REFERER']);
		$this->template->output("error.tpl");
	}
	
}

?>
