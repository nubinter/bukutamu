<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_tamu extends CI_Model
{
  public function byId($id)
  {
    $this->db->where('id', $id);
    $query = $this->db->get('tamu')->row_array();
    return $query;
  }


  public function byNama($nama, $event)
  {
    $this->db->where('event_id', $event);
    $this->db->where('nama', $nama);
    $query = $this->db->get('tamu')->row_array();
    return $query;
  }

  public function duplikatNama($nama, $event)
  {
    $this->db->where('event_id', $event);
    $this->db->where('nama', $nama);
    $query = $this->db->get('tamu')->num_rows();
    return $query;
  }

  public function byEvent($id)
  {
    $this->db->where('event_id', $id);
    $query = $this->db->get('tamu')->result_array();
    return $query;
  }

  public function jmlTamuByEvent($id)
  {
    $this->db->where('event_id', $id);
    $query = $this->db->get('tamu')->num_rows();
    return $query;
  }
  
  public function jmlTamuByGroupEvent($group_id, $event_id)  
  {    
	$this->db->where('event_id', $event_id);
	if($group_id != 'all') {
		$this->db->where('group_id', $group_id);
	}
	$query = $this->db->get('tamu')->num_rows();    
	return $query;  
  }
  
  public function tamuByGroupEvent($group_id, $event_id)  
  {    
	$this->db->where('event_id', $event_id);
	if($group_id != 'all') {
		$this->db->where('group_id', $group_id);
	}
	$query = $this->db->get('tamu')->result_array();    
	return $query;  
  }
  
  public function importbyEvent($id)
  {
    $this->db->where('event_id', $id);
    $query = $this->db->get('tamu_import')->result_array();
    return $query;
  }

  public function jmlTamuImport($id)
  {
    $this->db->where('event_id', $id);
    $query = $this->db->get('tamu_import')->num_rows();
    return $query;
  }


  public function byTamuCheckIn($event_id) {
        $this->db->where('event_id', $event_id);
        $this->db->where('jam_hadir !=', 0);
        $query = $this->db->get('tamu')->result_array();
        return $query;
  }


  // GRID
 public function getTable($event)
  {
    $this->db->from('tamu');

    $this->db->order_by('nama', 'asc');

    if ($this->input->post('cari')) {
      $this->db->like('nama', $this->input->post('cari'));
    }

    $page = $this->input->post('page');
    $page = ($page - 1);
    $perpage = 18;
    $resultFilter = ($perpage * $page);

    $this->db->limit($perpage, $resultFilter);
    $this->db->where('event_id', $event);
    $group = $this->input->post('group');
    if ($group != "" || $group != null) {
      $this->db->where('group_id', $group);
    }
    $query = $this->db->get()->result_array();
    return $query;
  }



  public function count_filter($event)
  {
    $this->db->from('tamu');

    if ($this->input->post('cari')) {
      $this->db->like('nama', $this->input->post('cari'));
    }

    $page = $this->input->post('page');
    $page = ($page - 1);
    $perpage = 18;
    $resultFilter = ($perpage * $page);

    $this->db->limit($perpage, $resultFilter);
    $this->db->where('event_id', $event);
    $group = $this->input->post('group');
    if ($group != "" || $group != null) {
      $this->db->where('group_id', $group);
    }
    $query = $this->db->get()->num_rows();
    return $query;
  }


  public function count_all($event)
  {
    $this->db->from('tamu');

    $this->db->where('event_id', $event);

    return $this->db->count_all_results();
  }
  
  public function getTamuCheckIn($event_id) {
        $this->db->where('event_id', $event_id);
        $this->db->where('jam_hadir !=', 0);
        return $this->db->count_all_results('tamu');
  }
  
  public function generateNomorAmpao($event_id) {
    $totalTamu = $this->getTamuCheckIn($event_id);
    $nomorAmpao = "A" . sprintf("%04d", $totalTamu + 1); // Format A-nomor urut
    return $nomorAmpao;
  }
}