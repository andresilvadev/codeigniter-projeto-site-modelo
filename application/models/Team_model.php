<?php

class Team_model extends CI_Model
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

		$this->db->from("team");
		$this->db->where("member_id", $id);
		return $this->db->get();
	}

	public function insert($data)
	{
		$this->db->insert("team", $data);
	}

	public function update($id, $data)
	{
		$this->db->where("member_id", $id);
		$this->db->update("team", $data);
	}

	public function delete($id)
	{
		$this->db->where("member_id", $id);
		$this->db->delete("team", $id);
	}

}
