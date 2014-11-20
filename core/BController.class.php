<?php

class BController extends Error{
	public $user;
	public $model;
	public $content;
	public $controllerClassName;
	public $tamplate;
	public $mainTamplate = "index.php";
	
	public function __construct () {
		$this->user = new User();
		/*
		 * Определяем имя класса, для того чтобы подключать
		 * "Виды" и "Модели" соответсвенно контроллеру
		*/ 
		$this->controllerClassName = get_class($this);
		$modelClassName = $this->controllerClassName."Model";
		include(ROOT."/apps/models/".$modelClassName.".class.php");
		$this->model = new $modelClassName();
	}

	public function render($tamplateName = "index", $nested = false, $common = false) {
		$this->tamplate = $tamplateName;
		if ($nested) {
			if ($common) {
				$fullPath = ROOT."/apps/views/common".
						"/".$tamplateName.".php";
			} else {
				$fullPath = ROOT."/apps/views/".
						strtolower($this->controllerClassName).
						"/".$tamplateName.".php";
			}
		} else {
			$fullPath = ROOT."/public/".$this->mainTamplate;
		}
		include_once($fullPath);
	}
}

?>
