<?php

class Router {

	protected static $route = [];
	protected static $routes = [];



	public static function add($uriRegexp, $routeParams = array()) {
		self::$routes[$uriRegexp] = $routeParams;
	}

	public static function getRouteAll() {
		return self::$routes;
	}

	public static function getRoute() {
		return self::$route;
	}

	public static function setRoute($uri) {
		foreach (self::$routes as $pattern => $route) {
			if ($uri === $pattern) {
				self::$route = $route;
				return true;
			}
		}
	}

}