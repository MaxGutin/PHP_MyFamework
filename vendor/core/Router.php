<?php


class Router
{
	protected static $routes = [];
	protected static $route = [];

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

	public static function matchRoute($url)
	{
		foreach(self::$routes as $pattern => $route){
			if($url == $pattern){
				self::$route = $route;
				return true;
			}
		}
		return false;
	}

}