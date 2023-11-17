<?php

namespace MarcusDias\FirstDecisionDT\Core;

defined('ROOTPATH') || exit('Access Denied!');

trait Database
{

	private function connect()
	{
		try {
			$string = DBTYPE.":host=".DBHOST.";dbname=".DBNAME;
			$pdo = new \PDO($string,DBUSER,DBPASS);
			$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			return $pdo;
		} catch (PDOException $e) {
			echo "Conexão com BD falhou: " . $e->getMessage();
			return false;
		}
	}

	public function queryi($query, $data = [])
	{
		$con = $this->connect();
		$stm = $con->prepare($query);

		$check = $stm->execute($data);
		if($check) {
			return $con->lastInsertId();
		}
		

		
	}
	public function query($query, $data = [])
	{
		$con = $this->connect();
		$stm = $con->prepare($query);

		$check = $stm->execute($data);
		if($check) {
			$result = $stm->fetchAll(\PDO::FETCH_OBJ);
			if(is_array($result) && count($result))
			{
				return $result;
			}
		}

		return false;
	}
	
}
