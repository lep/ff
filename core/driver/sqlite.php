<?php

	class sqlite extends sql_escaper{
		function escape($s){
			return SQLite3::escapeString ($s);
		}
	}

?>
