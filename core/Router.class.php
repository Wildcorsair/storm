<?php

	class Router {
		public $routeParts = array();

		public function __construct() {
			//echo "This is Router constructor!";
		}

		public function run() {
			$this->routeParts = $this->extractParts();
			$this->runController();

		}

		public function extractParts() {
			/*	
				Функция которая проверяет строку из GET переменной
				и если она не пустая, то разбирает ее на части.
				На выходе получаем массив, который гарантировано
				имеет три элемента (имя контроллера, имя экшена и параметр)
			*/
			$defaultParts = array(0 =>"main", 1 =>"index", 2 =>"default", 3 => "default");
			if (!empty($_GET['route'])) {
				$route = rtrim($_GET['route'], "/");
				setcookie("currRoute", $route, time()+3600, '/');
				$routeParts = explode("/", $route);
				for ($i = 0; $i < count($routeParts); $i++) {
					$part = trim($routeParts[$i]);
					if (!empty($part)) {
						$routeParts[$i] = $part;
					} else {
						$routeParts[$i] = $defaultParts[$i];
					}
				}
				/*
					Если получаем массив в котором меньше 3 элементов,
					то возвращаем исходный массив, но изменив в нем те 
					элементы которые есть в полученом массиве 
				*/
				if (count($routeParts) < 4) {
					for ($i=0; $i < count($routeParts); $i++) { 
						
						$defaultParts[$i] = $routeParts[$i];
					}
				} else {
					return $routeParts;
				}

			}
			return $defaultParts;
		}

		public function runController() {
			$fullPath = ROOT."/apps/controllers/".ucfirst($this->routeParts[0]).".class.php";
			$action = $this->routeParts[1];
			$param = $this->routeParts[2];
			$errorNo = $this->routeParts[3];
			try {
				if (file_exists($fullPath)) {
					require_once($fullPath);
					$this->controller = new $this->routeParts[0]();
					
					if (method_exists($this->controller, $action)) {
						$this->controller->$action($param, $errorNo);
					} else {
						throw new Exception("Error: No action found!");
					}
				} else {
					throw new Exception("Error 404: Page not found!");
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}
?>