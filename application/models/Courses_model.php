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
		$this->db->where("course_id", $id);
		return $this->db->get();
	}

	public function insert($data)
	{
		$this->db->insert("courses", $data);
	}

	public function update($id, $data)
	{
		$this->db->where("course_id", $id);
		$this->db->update("courses", $data);
	}

	public function delete($id)
	{
		$this->db->where("course_id", $id);
		$this->db->delete("courses", $id);
	}

	public function is_duplicated($field, $value, $id = null)
	{
		if (!empty($id)) {
			$this->db->where("course_id <>", $id);
		}
		$this->db->from("courses");
		$this->db->where($field, $value);

		return $this->db->get()->num_rows() > 0;
	}

	/**
	 * CAMPOS VIA POST
	 * $_POST['search']['value'] = Campo para busca
	 * 		$_POST['order'] =  [[0, 'asc']]
	 * 		$_POST['search']['0']['column'] = index da coluna
	 * 		$_POST['search']['0']['dir'] =  tipo de ordenação (asc, desc)
	 * 	$_POST['length'] = Quantos campos mostrar
	 * 	$_POST['start'] = Qual posição começar
	 */

	 var $column_search = array("course_name", "course_description");
	 var $column_order = array("course_name", "","course_duration");

	 private function _get_datatable()
	 {
		$search = null;
		if($this->input->post("search")) {
			$search = $this->input->post("search")["value"];
		}

		$order_column =  null;
		$order_dir =  null;

		$order = $this->input->post("order");
		if(isset($order)) {
			$order_column = $order["0"]["column"];
			$order_dir = $order["0"]["dir"];
		}

		$this->db->from("courses");
		
		if(isset($search)) {
			$first = true;			
			foreach ($this->column_search as $field) {
				if($first) {
					$this->db->group_start();
					$this->db->like($field, $search);
					$fisrt = false;
				} else {
					$this->db->or_like($field, $search);
				}
				if (!$first) {
					$this->db->group_end();
				}
			}
		}

		if(isset($order)) {
			$this->db->order_by($this->column_order[$order_column], $order_dir);
		}
	 }

	 public function get_datatable()
	 {
		 $length = $this->input->post("length");
		 $start = $this->input->post("start");
		 $this->get_datatable();

		 // Se estiver setado e for diferente de -1
		 // -1 indica que é todos os campos
		 if(isset($length) && $length != -1) {
			$this->db->limit($length, $start);
		 }

		 return $this->db->get()->result();
	 }

	 public function records_filtered()
	 {
		$this->get_datatable();
		return $this->db->get()->num_rows(); // Retorna o número de linhas
	 }

	 public function records_total()
	 {
		$this->db->from("courses");
		return $this->db->count_all_results(); // Retorna o número de linhas
	 }

}

