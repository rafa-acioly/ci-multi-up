<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Arquivo_model extends CI_Model
{
	public $date;
	
	public function __construct()
	{
		$this->load->database();
		$this->date = date('d/m/Y');
	}

	public function getRows($id = '')
	{
		$this->db->select('id, file_name, created');
		$this->db->from('files');
		if($id){
			$this->db->where('id', $id);
			$query = $this->db->get();
			$result = $query->row_array();
		}else{
			$this->db->order_by('created','desc');
			$query = $this->db->get();
			$result = $query->result_array();
		}
		return !empty($result)?$result:false;
	}
	
	public function insert(Array $data)
	{
		array_push($data, ['created' => $this->date]);
		$insert = $this->db->insert_batch('files', $data);
		return $insert->result();
	}
	
	public function update(Array $data, $id)
	{
		array_push($data, ['updated_at' => $this->date]);
		$this->db->set($data);
		$this->db->where('id', $id);
		$update = $this->db->update('files');
	}
}