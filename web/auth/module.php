<?php
	class authmodule extends module
	{
		
		const LOGIN_TIME= 86400;
		
		private function hashFunction($what)
		{
			return sha1($what);
		}
		
		function createUser($name, $password)
		{
			if (count($this->model->user->nameLIKE($name)->all())>0)
				throw new Exception("user exists");
			$user = $this->model->user->create();
			$user->name = $name;
			$pass = $password.$name;
			$user->password = $this->hashFunction($pass);
			$user->save();
			return $user;
		}
		
		function generateSessionID($user)
		{
			$id="";
			do
			{
				$id = md5(uniqid(rand(), true));
			}while (count($this->model->user->sessionidEQ($id)->all()) > 0);
			return $id;
		}
		
		function updateSession($user)
		{
			global $web_dir;
			$user->loginexpired = time()+self::LOGIN_TIME;
			$user->sessionid = $this->generateSessionId($user);
			setcookie("auth_id", $user->sessionid, time()+self::LOGIN_TIME, $web_dir);
		}
		
		function getUser()
		{
			if (!isset($_COOKIE['auth_id']))
				return null;
			$sessionid = $_COOKIE['auth_id'];
			try{
				$user = $this->model->user->sessionidEQ($sessionid)->loginexpiredGT(time())->get();
				$this->updateSession($user);
				$user->save();
				return $user;
			}catch(SqlError $e)
			{
				setcookie("auth_id", "äh", 0, $web_dir);
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
			$user = $this->model->user->nameEQ($name)->passwordEQ($this->hashFunction($password.$name))->get();
			$this->updateSession($user);
			$user->save();
		}
	}

?>