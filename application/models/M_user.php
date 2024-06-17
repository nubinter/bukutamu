<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_user extends CI_Model
{
  
  public function allUser()
  {
	$this->db->from('user');
    $this->db->where('role', 3);
    $query = $this->db->get()->result_array();
    return $query;
  }
  
  public function byUser($username)
  {
    $this->db->where('username', $username);
    $query = $this->db->get('user')->row_array();
    return $query;
  }

  public function byId($id)
  {
    $this->db->where('id', $id);
    $query = $this->db->get('user')->row_array();
    return $query;
  }

  public function byLeaderId($id)
  {
    $this->db->where('leader_id', $id);
    $query = $this->db->get('user')->result_array();
    return $query;
  }

  public function byEmail($email)
  {
    $this->db->where('email', $email);
    $query = $this->db->get('user')->row_array();
    return $query;
  }

  public function byEvent($id)
  {
    $this->db->where('event_id', $id);
    $query = $this->db->get('user')->row_array();
    return $query;
  }

  public function byKode($kode)
  {
    $this->db->where('kode', $kode);
    $query = $this->db->get('user')->row_array();
    return $query;
  }

  public function cekKode($kode)
  {
    $this->db->where('kode', $kode);
    $query = $this->db->get('kode')->row_array();
    return $query;
  }
  
    public function getTable()
  {
    $this->db->from('user');
    $this->db->where('role', 3);

    $this->db->order_by('id', 'desc');

    if ($this->input->post('cari')) {
      $this->db->group_start();
      $this->db->like('nama', $this->input->post('cari'));
      $this->db->group_end();
    }

    $page = $this->input->post('page');
    $page = ($page - 1);
    $perpage = 10;
    $resultFilter = ($perpage * $page);
    $this->db->limit($perpage, $resultFilter);
    $query = $this->db->get()->result_array();
    return $query;
  }



  public function count_filter()
  {
    $this->db->from('tamu');
    $this->db->where('event_id', $event);
	$group = $this->input->post('group');
    if ($group != "" || $group != null) {
      $this->db->where('group_id', $group);
    }
    if ($this->input->post('cari')) {
      $this->db->group_start();
      $this->db->like('nama', $this->input->post('cari'));
      $this->db->or_like('alamat', $this->input->post('cari'));
      $this->db->or_like('telp', $this->input->post('cari'));
      if (strtolower($this->input->post('cari')) == 'vip') {
        $this->db->or_like('vip', 1);
      }
      $this->db->group_end();
    }

    $page = $this->input->post('page');
    $page = ($page - 1);
    $perpage = 45;
    $resultFilter = ($perpage * $page);

    $this->db->limit($perpage, $resultFilter);
    $query = $this->db->get()->num_rows();
    return $query;
  }
}