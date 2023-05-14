<?php

class Controller {

	private $route = null;
	private $view = null;

	public function __construct($route) {

		$this->route = $route;

		//-- Получить $view
		$routeControllerName = $route['controller'] . 'Controller';
		$routeControllerMethod = $route['action'] ?? 'show';
		try {
			$this->view = $routeControllerName::$routeControllerMethod();
		} catch (Throwable $e) {
			dd(['Line:' . $e->getLine(), 'File:' . $e->getFile(), 'Error: ' . $e->getMessage()]);
		}


		//-- Запустить представление
		new View($this->route, $this->view);

	}

}