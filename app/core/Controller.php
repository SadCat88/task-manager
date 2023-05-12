<?php

class Controller {

	private $route = null;
	private $view = null;

	public function __construct($route) {

		$this->route = $route;

		//-- Получить $view
		$routeControllerName = $route['controller'] . 'Controller';
		$routeControllerMethod = $route['action'] ?? 'show';
		$this->view = $routeControllerName::$routeControllerMethod();


		//-- Запустить представление
		new View($this->route, $this->view);

	}

}