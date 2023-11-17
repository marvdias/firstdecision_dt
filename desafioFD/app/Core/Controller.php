<?php

namespace MarcusDias\FirstDecisionDT\Core;

defined('ROOTPATH') || exit('Access Denied!');

trait Controller
{

	public function view($name, $data = [])
	{
		// Torna os dados disponiveis na view
		if(!empty($data)) {
			extract($data);
		}

		$header = "../app/View/template/header.php";
		$footer = "../app/View/template/footer.php";
		$filename = "../app/View/".$name.".view.php";
		if(!file_exists($filename)) {
			$filename = "../app/View/404.view.php";
		}
		require_once $header;
		require_once $filename;
		require_once $footer;
		
	}
}