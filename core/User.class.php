<?php

class User {
	public $model;
	public $data;
	public $isAuthorized;

	public function __construct () {
		/*
		 * Определяем имя класса, для того чтобы подключать
		 * "Виды" и "Модели" соответсвенно контроллеру
		*/ 
		$this->controllerClassName = get_class($this);
		$modelClassName = $this->controllerClassName."Model";
		include(ROOT."/apps/models/".$modelClassName.".class.php");
		$this->model = new $modelClassName();
	}
	
	public function checkUserPermission($permission, $userId) {
		$isAllow = $this->model->userCheckPermissions($permission, $userId);
		return $isAllow;
	}

	public function isUserAuthorized() {
		$dataSet = $this->model->getAuthorizedUserData();
		if (!empty($dataSet)) {
			$this->data = $dataSet;
			$this->isAuthorized = true;
		} else {
			$this->isAuthorized = false;
		}
	}
}

?>