<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_grup extends CI_Model
{
  public function byId($id)
  {
    $this->db->where('id', $id);
    $query = $this->db->get('group_tamu')->row_array();
    return $query;
  }


  public function byNama($nama, $event)
  {
    $this->db->where('event_id', $event);
    $this->db->where('nama', $nama);
    $query = $this->db->get('group_tamu')->row_array();
    return $query;
  }

  public function byKode($kode, $event)
  {
    $this->db->where('event_id', $event);
    $this->db->where('kode', $kode);
    $query = $this->db->get('group_tamu')->row_array();
    return $query;
  }

  public function duplikatNama($nama, $event)
  {
    $this->db->where('event_id', $event);
    $this->db->where('nama', $nama);
    $query = $this->db->get('group_tamu')->num_rows();
    return $query;
  }

  public function byEvent($id)
  {
    $this->db->where('event_id', $id);
    $this->db->order_by('kode', 'asc');
    $query = $this->db->get('group_tamu')->result_array();
    return $query;
  }
  
  public function count_data($event)
  {
    $this->db->from('group_tamu');

    $this->db->where('event_id', $event);

    return $this->db->count_all_results();
  }

}