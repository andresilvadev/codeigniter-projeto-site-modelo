<?php

class Users_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct(); // Indica que estamos fazendo contrutor da classe Users_model e não da CI_Model
		$this->load->database(); // Conexão com a base de dados
	}

	public function get_user_data($user_login)
	{
		$this->db
			->select("user_id, password_hash, user_full_name, user_email")
			->from("users")
			->where("user_login", $user_login);

		$result = $this->db->get();

		if($result->num_rows() > 0) {
			return $result->row();
		}else {
			return null;
		}
	}

	public function get_data($id, $select = null)
	{
		if(!empty($select)) {
			$this->db->select($select);
		}

		$this->db->from("users");
		$this->db->where("user_id", $id);
		return $this->db->get();
	}

	public function insert($data)
	{
		$this->db->insert("users", $data);
	}

	public function update($id, $data)
	{
		$this->db->where("user_id", $id);
		$this->db->update("users", $data);
	}

	public function delete($id)
	{
		$this->db->where("id", $id);
		$this->db->delete("users", $id);
	}

	public function is_duplicated($field, $value, $id = null)
	{
		if (!empty($id)) {
			$this->db->where("user_id <>", $id);
		}
		$this->db->from("users");
		$this->db->where($field, $value);

		return $this->db->get()->num_rows() > 0;
	}
}
