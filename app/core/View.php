<?php

class View {

	private $route = null;
	private $view = null;

	public function __construct($route, $view) {

		$this->route = $route;
		$this->view = $view;


		//-- Собрать шаблоны
		$arView = ['MAIN' => 'home'];
		$arResult = ['TEST' => 'bokpokpok'];
		define('_TEMPLATE_PATH_', 'theme/' . Config::get('theme'));
		require __DIR__ . '/../../' . _TEMPLATE_PATH_ . '/index.php';

	}

}