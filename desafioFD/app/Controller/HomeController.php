<?php

namespace MarcusDias\FirstDecisionDT\Controller;

defined('ROOTPATH') || exit('Access Denied!');

class HomeController
{
	use \MarcusDias\FirstDecisionDT\Core\Controller;

	public function index()
	{
		$this->view('home',[]);
	}

}
