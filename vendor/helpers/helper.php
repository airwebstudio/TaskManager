<?php
	use Libs\Request\Request;
	use Libs\View\View;

	function response($data, $code = 200) { //get response var
		http_response_code($code);
		return $data;
	}
	
	function request() { //get request var
		return new Request();
	}
	
	function view($view_name, $params = Array()) { //get view var
		$v = new View($view_name, $params);
		return $v->render();
			
	}
	
?>