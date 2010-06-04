<?php
	error_reporting(E_ALL);

	class dispatcher {
		private static $method_unknown = "missing";
	
		static function executeControllerAction($controller, $action, $args){
			self::loadController($controller);

			if(! class_exists($controller)){
				if(method_exists("main", self::$method_unknown)){
					$controller	=	"main";
					$action		=	self::$method_unknown;
					array_unshift($args, $controller, $action);
				}else{
					throw new ErrorNotFound("Controller ". $controller .
					                    " not found.");
				}
			}elseif(! method_exists($controller, $action)){
				if(method_exists($controller, self::$method_unknown)){
                    $action     =   self::$method_unknown;
					array_unshift($args, $controller, $action);
                }else{
                	throw new ErrorNotFound("Classmethod ". $controller
				                     .".".  $action ." not found.");
				}
	
			}

			#check for parameter-count
			$method = new ReflectionMethod($controller, $action);
			$parametercount = $method->getNumberOfRequiredParameters();
			if(count($args) < $parametercount){
				throw new ErrorNotAllowed("Can't call ". 
					$controller .".". $action .".\n".
					"Got ". count($args) ." arguments but at least ".
					$parametercount ." are required.");
			}

			#call it
			$instance = new $controller($controller);
			call_user_func_array(array($instance, $action), $args);
		}
	
		static function dispatchRequest(){
			global $controllername, $actionname;
			$args=array();

			if(! isset($_GET['id'])){
				$controller="main";
				$action="index";
			}else{
				$parts=  preg_split('_/_', $_GET['id'], -1,
							PREG_SPLIT_NO_EMPTY);

				if(count($parts) == 1){
					$controller	=	$parts[0];
					$action		= 	"index";
				}elseif(count($parts) > 2){
					$controller	=	$parts[0];
					$action		=	$parts[1];
					$args		=	array_slice($parts, 2);
				}
			}

			$controller = str_replace(array('-', '.'), '_', $controller);
			$action 	= str_replace(array('-', '.'), '_', $action);


			#set global vars
			$controllername=$controller;
			$actioname=$action;

			self::executeControllerAction($controller, $action, $args);
		}


		 static function loadFile($path){
            global $server_dir;

            $absolutepath = realpath($server_dir.$path);
            if (file_exists($absolutepath)){
                include_once($absolutepath);
            }else{
                throw new ErrorNotFound("File '".$path."' not found.");
            }
        }

        static function loadController($controller){
            global $server_dir;

            $path = "/web/".$controller."/".$controller.".php";
            self::loadFile($path);
        }

        static function instantiateClass($class){
            if(!class_exists($class))
                throw new ErrorNotFound("Controller ".$class.
                    " not found.");
            return new $class;
        }

        static function loadModel($controller, $model){
            $path = "/web/".$controller."/model.php";
            self::loadFile($path);
            $class = $controller."_".$model;
            return self::instantiateClass($class);
        }

        static function loadModule($module){
            $path = "/web/".$module."/module.php";
            self::loadFile($path);
            $class = $module."module";
        	if(!class_exists($class))
				throw new ErrorNotFound("module ".$class.
					" not found.");
			return new $class($module);
		}

	}
	

?>
