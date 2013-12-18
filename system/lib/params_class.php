<?php 
class Params extends Stdclass {
	function __construct($extra = Array()) {
		$params = array_merge($_REQUEST, $extra);
		foreach ($params as $param => $val) {
			$this->{$param} = $val;
		}
	}

	function __get($key) {
		return null;
	}
  
  function _agregar($params) {
    foreach ($params as $key => $val) {
      $this->{$key} = $val;
    }
  }
}
?>