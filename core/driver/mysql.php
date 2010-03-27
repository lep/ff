<?php

	class mysql extends sql_escaper{
		function escapeStr($s){
			return "'". mysql_real_escape_str($s) ."'";
		}
	}

?>
