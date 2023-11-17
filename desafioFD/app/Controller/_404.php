<?php


namespace MarcusDias\FirstDecisionDT\Controller;

defined('ROOTPATH') || exit('Access Denied!');

class _404
{
	use \MarcusDias\FirstDecisionDT\Core\Controller;
	
	public function index()
	{
		$this->view('404',[]);
	}
}
