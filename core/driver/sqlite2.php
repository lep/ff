<?php

	class sqlite2 extends sql_escaper{
		function escapeStr($str){
			return "'". sqlite_escape_string($str) ."'";
		}
	}

?>