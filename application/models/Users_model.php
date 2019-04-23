<?php

class Users_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct(); // Indica que estamos fazendo contrutor da classe Users_model e não da CI_Model
		$this->load->database(); // Conexão com a base de dados
	}

	public function get_user_data($login)
	{
		$this->db
			->select("id, password, name, email")
			->from("users")
			->where("login", $login);

		$result = $this->db->get();

		if($result->num_rows() > 0) {
			return $result->row();
		}else {
			return null;
		}
	}

}
