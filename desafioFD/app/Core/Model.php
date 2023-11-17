<?php

namespace MarcusDias\FirstDecisionDT\Core;

defined('ROOTPATH') || exit('Access Denied!');

/**
 * Main Model trait
 */
trait Model
{
	use Database;

	public $limit 		= 50;
	public $offset 		= 0;
	public $order_type 	= "asc";
	public $order_column = "id";
	public $errors 		= [];

	public function findAll()
	{
	 
		$query = "SELECT * from $this->table ";
		$query .= "ORDER BY $this->order_column $this->order_type ";
		$query .= "LIMIT $this->limit OFFSET $this->offset";
		return $this->query($query);
	}

	public function where($data, $data_not = [])
	{
		$keys = array_keys($data);
		$keys_not = array_keys($data_not);
		$query = "select * from $this->table where ";

		foreach ($keys as $key) {
			$query .= $key . " = :". $key . " && ";
		}

		foreach ($keys_not as $key) {
			$query .= $key . " != :". $key . " && ";
		}
		
		$query = trim($query," && ");

		$query .= " order by $this->order_column $this->order_type limit $this->limit offset $this->offset";
		$data = array_merge($data, $data_not);

		return $this->query($query, $data);
	}

	public function first($data, $data_not = [])
	{
		$keys = array_keys($data);
		$keys_not = array_keys($data_not);
		$query = "select * from $this->table where ";

		foreach ($keys as $key) {
			$query .= $key . " = :". $key . " && ";
		}

		foreach ($keys_not as $key) {
			$query .= $key . " != :". $key . " && ";
		}
		
		$query = trim($query," && ");

		$query .= " limit $this->limit offset $this->offset";
		$data = array_merge($data, $data_not);
		
		$result = $this->query($query, $data);
		if($result) {
			return $result[0];
		}
			
		return false;
	}

	public function insert($data)
	{
		
		/** remove unwanted data **/
		if(!empty($this->allowedColumns)) {
			foreach ($data as $key => $value) {
				
				if(!in_array($key, $this->allowedColumns))
				{
					unset($data[$key]);
				}
			}
		}

		$keys = array_keys($data);

		$query = "insert into $this->table (".implode(",", $keys).") values (:".implode(",:", $keys).")";
		if ($result = $this->queryi($query, $data)) {

			return $this->first(['id' => $result]);
		}

		return false;
	}

	public function update($id, $data, $id_column = 'id')
	{

		/** remove unwanted data **/
		if(!empty($this->allowedColumns)) {
			foreach ($data as $key => $value) {
				
				if(!in_array($key, $this->allowedColumns))
				{
					unset($data[$key]);
				}
			}
		}

		$keys = array_keys($data);
		$query = "update $this->table set ";

		foreach ($keys as $key) {
			$query .= $key . " = :". $key . ", ";
		}

		$query = trim($query,", ");

		$query .= " where $id_column = :$id_column ";

		$data[$id_column] = $id;

		return $this->query($query, $data);

	}

	public function delete($id, $id_column = 'id')
	{

		$data[$id_column] = $id;
		$query = "delete from $this->table where $id_column = :$id_column ";
		if ($this->query($query, $data)) {
			return true;
		}

		return false;

	}

	public function getError($key)
	{
		if(!empty($this->errors[$key])) {
			return $this->errors[$key];
		}

		return "";
	}

	protected function getPrimaryKey(){

		return $this->primaryKey ?? 'id';
	}

	public function validate($data)
	{

		$this->errors = [];

		if(!empty($this->primaryKey) && !empty($data[$this->primaryKey])) {
			$validationRules = $this->onUpdateValidationRules;
		} else {
			$validationRules = $this->onInsertValidationRules;
		}

		if(!empty($validationRules)) {
			foreach ($validationRules as $column => $rules) {
				
				if(!isset($data[$column])) {
					continue;
				}

				foreach ($rules as $rule) {
				
					switch ($rule) {
						case 'required':
							if(empty($data[$column])) {
								$this->errors[$column] = ucfirst($column) . " é obrigatório";
							}
							break;
						case 'email':
							if(!filter_var(trim($data[$column]),FILTER_VALIDATE_EMAIL)) {
								$this->errors[$column] = "Email inválido";
							}
							break;
						case 'password_must_match':
							if($data[$column] != $data[$column.'2']) {
								$this->errors[$column] = "Senhas devem coincidir";
							}
							break;
						case 'more_than_6_less_than_20_chars':
							if(strlen(trim($data[$column])) < 6 || strlen(trim($data[$column])) > 20) {
								$this->errors[$column] = ucfirst($column) . " deve ter entre 6 e 20 caracteres.";
							}
							break;
						case 'more_than_3_less_than_50_chars':
							if(strlen(trim($data[$column])) < 3 || strlen(trim($data[$column])) > 50) {
								$this->errors[$column] = ucfirst($column) . " deve ter entre 3 e 50 caracteres.";
							}
							break;
						case 'unique':
							$key = $this->getPrimaryKey();
							if(!empty($data[$key])) {
								//edit mode
								if($this->first([$column=>$data[$column]],[$key=>$data[$key]])){
									$this->errors[$column] = ucfirst($column) . " deve ser único";
								}
							} else {
								//insert mode
								if($this->first([$column=>$data[$column]])){
									$this->errors[$column] = ucfirst($column) . " deve ser único";
								}
							}
							break;
						default:
							$this->errors['rules'] = "A regra ". $rule . " não foi encontrada!";
							break;
					}
				}
			}
		}

		if(empty($this->errors)) {
			return true;
		}

		return false;
	}
	
}