<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_event extends CI_Model
{
  public function byId($id)
  {
    $this->db->where('id', $id);
    $query = $this->db->get('event')->row_array();
    return $query;
  }



  public function byIdUser($id)
  {
    $this->db->where('leader_id', $id);
    $query = $this->db->get('event')->result_array();
    return $query;
  }


  public function eventUser($id)
  {
    $this->db->where('leader_id', $id);
    $query = $this->db->get('event')->row_array();
    return $query;
  }


  public function creatXampleEvent()
  {
    $kode = generate_random_string(8);
    $data = [
      'id' => 1,
      'nama' => 'Romeo & Juliet',
      'tgl' => date('Y-m-d'),
      'kode' => $kode,
      'undangan' => 'https://weddingkamiberdua.com/',
      'poto' => 'baner.jpg',
      'leader_id' => 1,
      'wa' => 'Kepada [NAMA-TAMU] Untuk Undangan [LINK]'
    ];

    $query = $this->db->insert('event', $data);
    return $query;
  }
}