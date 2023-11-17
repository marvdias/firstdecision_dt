<?php

namespace MarcusDias\FirstDecisionDT\Core;

defined('ROOTPATH') || exit('Access Denied!');

class App
{
	private $controller = 'Home';
	private $method 	= 'index';

	private function splitURL()
	{
		$url = $_GET['url'] ?? 'home';
		$url = explode("/", trim($url,"/"));
		return $url;
	}

	public function loadController()
	{
		$url = $this->splitURL();

		/** select controller **/
		$filename = "../app/Controller/".ucfirst($url[0])."Controller.php";
		if(file_exists($filename)) {
			$this->controller = 'MarcusDias\\FirstDecisionDT\\Controller\\'.ucfirst($url[0]).'Controller';
			unset($url[0]);
		} else {
			// $filename = "../app/Controller/_404.php";
			$this->controller = 'MarcusDias\\FirstDecisionDT\\Controller\\_404';
		}
		//require_once $filename;
		// show($filename);die();

		$controller = new $this->controller;

		/** select method **/
		if(!empty($url[1]))	{
			if(method_exists($controller, $url[1])) {
				$this->method = $url[1];
				unset($url[1]);
			}
		}

		call_user_func_array([$controller,$this->method], $url);

	}

}
