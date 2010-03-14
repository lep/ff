<?php

	class pgsql extends sql_escaper{
		function escapeStr($s){
			return "'".pg_escape_string($s)."'";
		}
	}

?>
