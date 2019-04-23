<?php

class Courses_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct(); // Indica que estamos fazendo contrutor da classe Users_model e não da CI_Model
		$this->load->database(); // Conexão com a base de dados
	}

	public function get_data($id, $select = null)
	{
		if(!empty($select)) {
			$this->db->select($select);
		}

		$this->db->from("courses");
		$this->db->where("id", $id);
		return $this->db->get();
	}

	public function insert($data)
	{
		$this->db->insert("courses", $data);
	}

	public function update($id, $data)
	{
		$this->db->where("id", $id);
		$this->db->update("courses", $data);
	}

	public function delete($id)
	{
		$this->db->where("id", $id);
		$this->db->delete("courses", $id);
	}

	public function is_duplicated($field, $value, $id = null)
	{
		if (!empty($id)) {
			$this->db->where("id <>", $id);
		}
		$this->db->from("courses");
		$this->db->where($field, $value);

		return $this->db->get()->num_rows() > 0;
	}
}
