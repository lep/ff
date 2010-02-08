<?php

	class sqlite2 extends sql{
		function escape($s){
			return sqlite_escape_string($s);
		}
	}

?>