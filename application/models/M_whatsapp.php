<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_whatsapp extends CI_Model
{
	public function byId($id)
	{
	    $this->db->where('id', $id);
        $query = $this->db->get('wa_devices')->row_array();
        return $query;
	}
	
	public function byUserId($user_id)
	{
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('wa_devices')->result_array();
		return $query;
	}
	
	public function byNumber($nomor_wa)
	{
        $this->db->where('nomor_wa', $nomor_wa);
        $query = $this->db->get('wa_devices')->row_array();
        return $query;
	}
	
	public function add()
	{
	    
	}
	
	public function getTable($blast)
	{
		$this->db->from('blast_history');

		$this->db->order_by('created_at', 'desc');

		if ($this->input->post('cari')) {
		  $this->db->like('nama', $this->input->post('cari'));
		}

		$page = $this->input->post('page');
		$page = ($page - 1);
		$perpage = 18;
		$resultFilter = ($perpage * $page);

		$this->db->limit($perpage, $resultFilter);
		$this->db->where('campaign_id', $blast);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function count_filter($blast)
	{
		$this->db->from('blast_history');

		if ($this->input->post('cari')) {
		  $this->db->like('nama', $this->input->post('cari'));
		}

		$page = $this->input->post('page');
		$page = ($page - 1);
		$perpage = 18;
		$resultFilter = ($perpage * $page);

		$this->db->limit($perpage, $resultFilter);
		$this->db->where('campaign_id', $blast);
		$query = $this->db->get()->num_rows();
		return $query;
	}


	public function count_all($blast)
	{
		$this->db->from('blast_history');
		$this->db->where('campaign_id', $blast);
		return $this->db->count_all_results();
	}
	
	public function getTableBlast($event)
	{
		$this->db->from('blast');

		$this->db->order_by('id', 'desc');

		if ($this->input->post('cari')) {
		  $this->db->like('judul', $this->input->post('cari'));
		}

		$page = $this->input->post('page');
		$page = ($page - 1);
		$perpage = 18;
		$resultFilter = ($perpage * $page);

		$this->db->limit($perpage, $resultFilter);
		$this->db->where('event_id', $event);
		$query = $this->db->get()->result_array();
		return $query;
	}
}
?>