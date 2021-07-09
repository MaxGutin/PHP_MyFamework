<?php


class Router
{
	protected static array $routes = [];
	protected static array $route = [];

	public static function add( $regexp, $route = [] )
	{
		self::$routes[$regexp] = $route;
	}

	public static function getRoutes(): array
	{
		return self::$routes;
	}

	public static function getRoute(): array
	{
		return self::$route;
	}

	/**
	 * Finding URL in Routes Table
	 * @param string $url insert URL
	 * @return boolean
	 */
	public static function matchRoute(string $url): bool
	{
		foreach (self::$routes as $pattern => $route) {
			if (preg_match("#$pattern#i", $url, $matches)) {
				foreach ($matches as $k => $v) {
					if (is_string($k)) {
						$route[$k] = $v;
					}
				}
				if (!isset($route['action'])) {
					$route['action'] = 'index';
				}
				self::$route = $route;
				return true;
			}
		}
		return false;
	}

	/**
	 * Direct URL to correct Route
	 * @param string $url insert URL
	 * @return void
	 */
	public static function dispatch(string $url)
	{
		if (self::matchRoute($url)) {
			$controller = self::studlyCaps(self::$route['controller']);
			if ( class_exists($controller) ) {
				$controllerObject = new $controller;
				$action = self::camelCase(self::$route['action']) . 'Action';
				if ( method_exists($controllerObject, $action) ) {
					$controllerObject->$action();
				} else {
					echo "Method <b>\"$action\"</b> in controller <b>\"$controller\"</b> not found!";
				}
			} else {
				echo "Controller <b>\"$controller\"</b> not found!";
			}
		} else {
			http_response_code(404);
			include '404.html';
		}
	}

	/**
	 * Converting string-like-that to StudlyCaps
	 * @param $name
	 * @return string
	 */
	protected static function studlyCaps($name): string
	{
		return str_replace(' ', '', ucwords( str_replace('-', ' ', $name) ) );
	}

	/**
	 * Converting string-like-that to CamelCase
	 * @param $name
	 * @return string
	 */
	protected static function camelCase($name): string
	{
		return lcfirst(self::studlyCaps($name));
	}

}