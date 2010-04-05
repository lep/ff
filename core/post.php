<?php
	error_Reporting(E_ALL);

	class post /*implements ArrayAccess*/ {
		private static $nice_names=array(
			'string'	=> FILTER_DEFAULT,
			'int'		=> FILTER_VALIDATE_INT,
			'float'		=> FILTER_VALIDATE_FLOAT,
			'url'		=> FILTER_VALIDATE_URL,
			'email'		=> FILTER_VALIDATE_EMAIL,
			'sanitize'	=> FILTER_SANITIZE_STRING,
			'escape'	=> FILTER_SANITIZE_SPECIAL_CHARS
		
		);
	
		private $form=array();
		private $hasForm=true;

		private function parseFields($name, $fields){
			foreach($fields as $name_=>$data){
				if(is_array($data)){

					if(isset($data['filter']) and ! is_array($data['filter'])){
						$data['filter']=array($data['filter']);
					}

					$this->form[$name][$name_]=$data;
				}else{
					$this->form[$name][$name_]=array(
						'type'=>$data,
						'filter'=>array(),
						'default'=>null
					);
				}
			}
		}

		private function checkDefault($k, $v){
			if(! isset($_POST[$k]) or empty($_POST[$k]) ){
            	if(isset($v['default'])){
                	return $v['default'];
				}else{
                	throw new Exception('Required value not set');
				}
			}else{
            	return $_POST[$k];
            }		
		}

		private function checkType($value, $k, $v){
			if(! isset($v['type'])){
            	throw new Exception('Type required');
            }
			if(empty($value) and isset($v['default'])){
				return $value;
			}

            $tmp=filter_var($value, 
							self::$nice_names[$v['type']], 
							FILTER_NULL_ON_FAILURE);
            if($tmp===null){
                throw new Exception('Type error');
            }
            return $tmp;
		}

		private function applyFilter($value, $filter){
			if(! isset(self::$nice_names[$filter])){
				throw new Exception('Unknown Filter');
			}
			return 
			 filter_var($value, self::$nice_names[$filter]);
		}
		
		private function checkBounds($value, $min, $max){
			if(! isset($min) && ! isset($max)){
				return;
			}

			$type=gettype($value);
			if($type=='string')
				$value=strlen($value);
			elseif(! ($type=='integer' || $type=='double'))
				throw new Exception('Unsupported type for bound-checking');
			
			if(isset($min) and $value < $min){
				throw new Exception('Value not in range');
			}
			if(isset($max) and $value > $max){
				throw new Exception('Value not in range');
			}
		}
		
		private function checkRegex($value, $regex){
			if(! isset($regex))
				return;
				
			if(gettype($value) != 'string'){
				throw new Exception('Only strings are allowed '.
									'to be pattern-matched');
			}
			
			if(is_array($regex)){
				foreach($regex as $r){
					$this->regexHelper($value, $r);
				}
			}else{
				$this->regexHelper($value, $regex);
			}
		}#where
		private function regexHelper($value, $r){
			if(! preg_match($r, $value)){
				throw new Exception('Value does not match pattern');
			}
		}

		function __get($name){
			if(! $this->hasForm){
				throw new Exception('Post has no definioton');
			}

			if(! isset($this->form[$name])){
				throw new Exception('Post-data is non-existant');
			}

			$ret=array();
			foreach($this->form[$name] as $k=>$v){
				#check for default values
				$ret[$k]=$this->checkDefault($k, $v);

				#typechecking
				$ret[$k]=$this->checkType($ret[$k], $k, $v);				

				#filter
				if(isset($v['filter'])){
					foreach($v['filter'] as $filter){
						$ret[$k]=$this->applyFilter($ret[$k], $filter);
					}
				}
				
				#min-max
				$this->checkBounds($ret[$k], @$v['min'], @$v['max']);
				
				#regex
				$this->checkRegex($ret[$k], @$v['pattern']);
			}
			return $ret;
		}


		function __construct($controller_name){
			global $server_dir;
			
			$path = $server_dir .'/web/'. 
					$controller_name .'/form.yml';
			if(! file_exists($path)){
				$this->hasForm=false;
				return;
			}

			$yaml=sfYaml::load($path);

			foreach($yaml as $name=>$fields){
				$this->parseFields($name, $fields);
			}

		}
	}

?>
