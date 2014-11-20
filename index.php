<?php 
	error_reporting(E_ALL);
	define ("ROOT", $_SERVER['DOCUMENT_ROOT']);
	
	function __autoload ($className) {
		$fullPath = ROOT."/core/".$className.".class.php";
		if (file_exists($fullPath)) {
			include_once ($fullPath);
		}
	}
	
	$router = new Router();
	$router->run();

?>
