<?php
	class FException
		extends Exception{}
	
	class ErrorNotFound 
		extends Exception{};
	
	class ErrorNotAllowed 
		extends Exception{};

	function HandleException($e){
		try{
			if ($e instanceof ErrorNotFound)
			{
				dispatcher::executeControllerAction("error", "notfound",
					array($e->getMessage(), $e->getTraceAsString()));
			}elseif($e instanceof ErrorNotAllowed){
				dispatcher::executeControllerAction("error", "notallowed",
					array($e->getMessage(), $e->getTraceAsString()));
			}
			else{
				die("Unhandled error: ".$e->getMessage()."\n".
					$e->getTraceAsString());
			}
		}catch(Exception $e){
			die("DOUBLEFAULT: ".$e->getMessage()."\n".
				$e->getTraceAsString());
		}
	}
?>
