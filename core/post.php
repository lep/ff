<?php
	class post {
		private static $nice_names=array(

			'type'=> array(
				'int'=>FILER_VALIDATE_INT,
				'bool'=>FILTER_VALIDATE_BOOLEAN,
				'float'=>FILTER_VALIDATE_FLOAT,
				'url'=>FILTER_VALIDATE_URL,
				'email'=>FILTER_VALIDATE_EMAIL,
				'string'=>FILTER_DEFAULT
			),

			'filter' => array(
				'sanitize-string' => FILTER_SANITIZE_STRING,
				'escape-string' => FILTER_SANITIZE_ENCODED
			)

			/*'flag'=>array(
				
			)*/
		);

		private $form=array();

		private static function process(&$array, $data){
			if(array_key_exists($vs, self::$nice_names['type'])){
		    	$array['type'] |= self::$nice_names['type'][$vs];
			}#else throw error

		}

		function __construct($controller_name){
			global $server_dir;
			$yaml=sfYaml::load( $server_dir .'/web/'. $controller_name .'/form.yml');

			foreach($yaml as $form_name=>$form){
				foreach($form as $name=>$data){
				
					if(is_array($data)){
						foreach($data as $k=>$v){
							if($k === 'type'){
								$this->form[$form_name][$name]['type'] |= 
									self::$nice_names['type'][$v];
							}elseif($k === 'filter'){
								if(is_array($v)){
									foreach($v as $i){
										$this->form[$form_name][$name]['type'] |= 
											self::$nice_names['type'][$i];
									}
								}else{
									$this->form[$form_name][$name]['type'] |= 
										self::$nice_names['type'][$v];
								}
							}
						}
					}else{
						#TODO: check if $data exists as a key
						$this->form[$form_name][$name] = self::$nice_names[$data];
					}
				
				
				}
			}

			/*
			$data=sfYaml::load($yaml);
			
			$type_array=array();

			foreach($data as $k=>$v){
				$type_array[$k]=array();
				
				foreach($v as $ks=>$vs){
					if(is_array($vs)){
						foreach($vs as $kss=>$vss){
						}
					}else{
						
					}

				}
			}
			*/
		}


	}

?>
