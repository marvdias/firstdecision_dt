<?php

namespace MarcusDias\FirstDecisionDT\Controller;

defined('ROOTPATH') || exit('Access Denied!');

class UserController
{
	use \MarcusDias\FirstDecisionDT\Core\Controller;

	public function index()
	{
		$user = new \MarcusDias\FirstDecisionDT\Model\User;

		$data['users'] = $user->findAll();
		$this->view('user',$data);
	}

	public function create(){

		$this->view('create',[]);

	}

	public function register()
	{
		header('Content-Type: application/json');
		try {

			$data['user'] = new \MarcusDias\FirstDecisionDT\Model\User;
			
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if ($result = $data['user']->register($_POST)) {
					http_response_code(201);
					echo json_encode(['data' => $result, 'status' => 'sucesso']);
					die(1);
				} else {
					throw new \Exception(implode(",", $data['user']->errors));
				}
			}

			
		} catch (\Exception $e) {
			http_response_code(400);
			echo json_encode(['status' => 'erro', 'message' => $e->getMessage()]);
		}
	}

	public function list()
	{
		header('Content-Type: application/json');
		try {

			$data['user'] = new \MarcusDias\FirstDecisionDT\Model\User;
			
			if($_SERVER['REQUEST_METHOD'] == "GET") {
				if ($result = $data['user']->findAll()) {
					http_response_code(200);
					echo json_encode(["data" => $result, "status" => "sucesso"]);
					die(1);
				} else {
					throw new \Exception(implode(",", $data['user']->errors));
				}
			}

			$this->view('register',$data);
		} catch (\Exception $e) {
			http_response_code(500);
			echo json_encode(['erro' => $e->getMessage()]);
		}
	}

}
