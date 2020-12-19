<?php
namespace Libs\Router;

	class Router {
		 public static function __callStatic($name, $arguments) {
			if (!in_array($name, Array('get', 'post', 'put' , 'delete'))) {
				throw new Exception('Unknown request type');
			}
						
			if (!isset($arguments[0]) || !isset($arguments[1])) {
				throw new Exception('Not enought arguments for Router');			
			}
						
			$action = $_REQUEST['_action'] ?? '';			
			$action = strtolower($action);			
			$params = Array();
						
			$_url = strtolower($arguments[0]);
			
			preg_match_all("/\{(.*?)\}/u", $_url, $outs);
			
			if (sizeof($outs)) {
				
				$param_names = array();
				foreach ($outs[1] as $o_item) {
					$param_names[] = $o_item;
				}
				
				$__url = addcslashes($_url, ".\\/");
				
				$regexp = '/^'.preg_replace("/\{.*?\}/u", '([^\/]*?)', $__url).'$/u';
				
				if (preg_match_all($regexp, $action, $res)) {
					if (isset($res[1]))
					$params = $res[1];
				}
					
				else {
					return false;
				}
			}
			
			elseif ($action != $_url) {
				return false;
			}
			
			if (strtolower($_SERVER['REQUEST_METHOD']) !== strtolower($name)) {
				return false;
			}
						
			$c_arr = explode('@', $arguments[1]);
			
			$class_name = '\Controllers\\'.$c_arr[0];
			
			$controller = new $class_name;
			$res = call_user_func_array(array($controller, $c_arr[1]), $params);
			
			if (is_array($res)) {
				
				$res = json_encode($res);
			}
			
			echo $res;			
			exit(200);				
				
			
		 }	
	}

?>