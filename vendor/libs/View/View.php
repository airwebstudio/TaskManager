<?php
namespace Libs\View;

use Twig\Loader;
 
class View {
		private $vars = array();
		private $twig;
		private $view_name;
		private $params;
		
		function __set($var, $val) {
				$this->vars[$var] = $val;
		}
		
		function __get($var) {
				return $this->vars[$var];
		}
		
		public function __construct($name, $params = Array()) {
				$this->view_name = $name;
				$this->params = $params;
				
		}
		
		public function with($params = Array()) {
				$this->params = array_merge($params, $this->params);
		}
			
		public function render() {
			$fn = APP_DIR.'/views/'.$this->view_name;
			if (file_exists($fn.'.php')) {
				
					
				foreach ($this->params as $v_name => $p) {
					$this->$v_name = $p;
				}
				
				ob_start();
					http_response_code(200);
					include $fn.'.php';
				$res = ob_get_contents();
				ob_end_clean();
				
				return $res;
				
			}
			elseif(file_exists($fn.'.twig.php')) {
				if (!isset($this->twig)) {
					$loader = new \Twig\Loader\FilesystemLoader(APP_DIR.'/views/');
					$this->twig = new \Twig\Environment($loader);
				}
				
				/*$this->twig->load($this->view_name.'.twig.php',  [
					'cache' => APP_DIR.'/cache',
				]);*/
				
				
				
				return $this->twig->render($this->view_name.'.twig.php', $this->params);
			}
		}
}

?>