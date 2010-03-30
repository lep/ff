<?php
	class authmodule extends module
	{
		
		const LOGIN_TIME= 60*60*24;
		
		private function hashFunction($what)
		{
			return sha1($what);
		}
		
		function create($name, $password)
		{
			$user = $this->model->user->create();
			$user->name = $name;
			$pass = $password.$name;
			$user->password = this->hashFunction($pass);
			return $user;
		}
		
		function generateSessionID($user)
		{
			$id="";
			do
			{
				$id = md5(uniqid(rand(), true));
			}while (count($this->model->user->sessionidEQ($id)) > 0);
			return $id;
		}
		
		function updateSession($user)
		{
			$user->loginexpired = time()+self::LOGIN_TIME;
			$user->sessionid = $this->generateSessionId($user);
			setcookie("auth_id", $user->sessionid, time()+self::LOGIN_TIME);
		}
		
		function getUser()
		{
			if (!isset($_COOKIE['auth_id']))
				return null;
			$sessionid = $_COOKIE['auth_id'];
			try{
				$user = $this->model->user->sessionidEQ($sessionid)->loginexpiredGT(time())->get();
				$user->updateSession();
				$user->save();
				return $user;
			}catch(exection $e)
			{
				setcookie("auth_id", "äh", 0);
				return null;
			}

		}
		
		function needsUser()
		{
			$user = $this->getUser();
			if ($user == null)
				throw new ErrorNotAllowed();
			else
				return $user;
		}
		
		function authUser($name, $password)
		{
			$user = $this->model->user->nameEQ($name)->passwordEQ($this->hashFunction($password))->get();
			$this->updateSession($user);
			$user->save();
		}
	}

?>