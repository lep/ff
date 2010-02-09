<?php

	class sqlite extends sql{
		function escape($s){
			return sqlite_escape_string($s);
		}
	}

?>