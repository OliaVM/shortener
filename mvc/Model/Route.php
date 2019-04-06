<?php
class Route
{
	public static function start($connectionDb)
	{
		// Controller and default action
		$controllerName = 'Index';
		$actionName = 'index';	

		$routes = explode('/', $_SERVER['REQUEST_URI']); 
		if (!empty($routes[2]))	{	
			$controllerName = $routes[2];
		}
		
		// Method of controller
		if (!empty($routes[3])) {
			$actionName = $routes[3];
		}

		$modelName = $controllerName . 'Model';
		$viewName = $controllerName . 'View';
		$controllerName = $controllerName . 'Controller';
		$actionName = $actionName . "Action";
 		
		// get Model file
		$modelFile = $modelName .'.php';
		$modelPath = __DIR__ . "/".$modelFile;

		if (file_exists($modelPath))
		{
			require_once $modelPath;
		} else {
			Route::ErrorPage404();
		}

		// get Controller file
		$controllerFile = $controllerName.'.php';
		$controllerPath = __DIR__ . "/../Controller/".$controllerFile;

		if (file_exists($controllerPath))
		{
			require_once __DIR__ . "/../Controller/".$controllerFile;
		} else {
			Route::ErrorPage404();
		}
		
		// get View file
		$viewFile = $viewName.'.php';
		$viewPath = __DIR__ . "/../View/".$viewFile;
		if (file_exists($viewPath))
		{
			require_once __DIR__ . "/../View/".$viewFile;
		} else {
			Route::ErrorPage404();
		}

		// Create Controller
		$controller = new $controllerName;
		$action = $actionName;
		
		if (method_exists($controller, $action))
		{
			//path from template.php to content of our page
			if (!empty($routes[3])) {

				switch ($routes[3]) {
					default:
						$pathToPage = "/";
						$contentOfPage = 'index';
				}
			}
			else {
				$pathToPage = "/";
				$contentOfPage = 'index';
			}	

			
			// Do action
			$controller->$action($connectionDb, $pathToPage, $contentOfPage);

		} else {
			Route::ErrorPage404();
		}
	}
	
	public static function ErrorPage404()
	{
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404.php');
    }
}
