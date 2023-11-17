<?php

namespace MarcusDias\FirstDecisionDT\Model;

defined('ROOTPATH') || exit('Access Denied!');

/**
 * UserModel class
 */
class User
{
	
	use \MarcusDias\FirstDecisionDT\Core\Model;

	protected $table = 'users';

	// Colunas adicionadas neste array serão inseridas no BD
	protected $allowedColumns = [
		'name',
		'email',
		'password',
	];
	
	// Regras que cada campo irá passar antes de ser inserido no BD
	protected $onInsertValidationRules = [

		'email' => [
			'email',
			'required',
		],
		'name' => [
			'more_than_3_less_than_50_chars',
			'required',
		],
		'password' => [
			'more_than_6_less_than_20_chars',
			'password_must_match',
			'required',
		],
	];

	public function register($data)
	{
		if($this->validate($data))
		{
			//Para colocar hash remover comentário abaixo:
			//$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

			if ($result = $this->insert($data)){
				return $result;
			}
			// Sendo utilizado como backend-API
			//redirect('user/list');
		}
	}
}