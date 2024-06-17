<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_report extends CI_Model
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

  public function jmlTamuHadir($id)
  {
    $this->db->select('SUM(jml_tamu) as total');
    $this->db->where('event_id', $id);
    $this->db->where('jam_hadir >', 0);
    $this->db->from('tamu');
    $query = $this->db->get()->row()->total;
    return $query;
  }

  public function jmlUndanganHadir($id)
  {
    $this->db->where('event_id', $id);
    $this->db->where('jam_hadir >', 0);
    $query = $this->db->get('tamu')->num_rows();
    if ($query == null || $query <= 0 || !$query) {
      $query = 0;
    }
    return $query;
  }

  public function jmlTamuTidakHadir($id)
  {
    $this->db->where('event_id', $id);
    $this->db->where('jam_hadir <=', 0);
    $query = $this->db->get('tamu')->num_rows();
    if ($query == null || $query <= 0 || !$query) {
      $query = 0;
    }
    return $query;
  }

  public function jmlUndangan($id)
  {
    $this->db->where('event_id', $id);
    $query = $this->db->get('tamu')->num_rows();
    if ($query == null || $query <= 0 || !$query) {
      $query = 0;
    }
    return $query;
  }





  // GRID
  public function getTable($event)
  {
    $this->db->from('tamu');

    $this->db->order_by('jam_hadir', 'asc');

    if ($this->input->post('cari')) {
      $this->db->like('nama', $this->input->post('cari'));
    }

    $page = $this->input->post('page');
    $page = ($page - 1);
    $perpage = 18;
    $resultFilter = ($perpage * $page);

    $this->db->limit($perpage, $resultFilter);

    $hadir = $this->input->post('hadir');
    if ($hadir == '1') {
      $this->db->where('jam_hadir >', 0);
    } else {
      $this->db->where('jam_hadir <=', 0);
    }

    $group = $this->input->post('group');
    if ($group != "" || $group != null) {
      $this->db->where('group_id', $group);
    }

    $this->db->where('event_id', $event);
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

    $hadir = $this->input->post('hadir');
    if ($hadir == '1') {
      $this->db->where('jam_hadir >', 0);
    } else {
      $this->db->where('jam_hadir <=', 0);
    }

    $group = $this->input->post('group');
    if ($group != "" || $group != null) {
      $this->db->where('group_id', $group);
    }

    $this->db->where('event_id', $event);
    $query = $this->db->get()->num_rows();
    return $query;
  }
}