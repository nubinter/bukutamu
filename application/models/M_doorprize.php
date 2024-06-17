<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_doorprize extends CI_Model
{
	public function byEvent($id)
	{
		$this->db->where('event_id', $id);
		$query = $this->db->get('doorprize_setting')->row_array();
		return $query;
	}
	
	public function load_hadiah($id)
	{
		$this->db->where('doorprize_id', $id);
		$query = $this->db->get('doorprize')->result_array();
		return $query;
	}
}
?>