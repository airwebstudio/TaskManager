<?php
	namespace Libs\Request;
	class Request {
		
		public static function getList(array $names):array {
				$out = array();
				foreach ($names as $n) {
					$out[] = self::getVar($n);
				}
				
				return $out;
		}
		
		public static function getVar($name, $def = ''){
			$res = empty($_REQUEST[$name]) ? $def : $_REQUEST[$name];
			return $res;
		}

		public static function getVarInt($name, $def = 0) {
			return (int)self::getVar($name, (int)$def);
		}

		public static function getVarBool($name, $def = false) {
			return (bool)self::getVar($name, (bool)$def);
		}

		public static function getVarArray($name, $def = Array()) {
			return (array)self::getVar($name, (array)$def);
		}
		
		
		public static function getVarObject($name, $def = Array()) {
			return (object)self::getVar($name, (object)$def);
		}

		public static function getVarString($name, $def = '') {
			return (string)self::getVar($name, (string)$def);
		}

		public static function set($name, $val) {
			$_REQUEST[$name] = $val;
		}

		public static function has($name) {
			return (!empty($_REQUEST[$name]));
		}
	
	}
?>