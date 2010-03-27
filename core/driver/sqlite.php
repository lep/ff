<?php

	class sqlite extends sql_escaper{
		function escapeStr($s){
			return "'". SQLite3::escapeString ($s) ."'";
		}
	}

?>