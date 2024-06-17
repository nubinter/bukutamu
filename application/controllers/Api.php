<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
  public function index()
  {
    redirect('home');
  }





  public function passKey()
  {
    $kode = trim($this->input->post('pass'));
    $event = $this->db->get_where('event', ['kode' => $kode])->row_array();
    if ($event) {
      $respon['kode'] = "1";
      $respon['event'] = $event['nama'];
      $respon['poto'] = $event['poto'];
      echo json_encode($respon);
    } else {
      $respon['kode'] = "2";
      echo json_encode($respon);
    }
  }





  public function checkinTamu()
  {
    $konek = $this->input->post('pass');
    $barcode = $this->input->post('barcode');

    $time = time();
    $timer = $time + (10);

    $event = $this->db->get_where('event', ['kode' => $konek])->row_array();
    $idEvent = $event['id'];

    $this->db->set('sapa', 0)->where(['event_id' => $idEvent])->update('tamu');

    $cekTamu = $this->db->get_where('tamu', ['nama' => $barcode, 'event_id' => $idEvent])->row_array();
    if ($cekTamu == true) {
      if ($cekTamu['jam_hadir'] == 0) {
        $this->db->set(['jam_hadir' => $time, 'sapa' => 1, 'timer' => $timer])->where('id', $cekTamu['id'])->update('tamu');
        $respon['kode'] = '1';
        $respon['nama'] = $cekTamu['nama'];
        $respon['alamat'] = $cekTamu['alamat'];
        $respon['waktu'] = date('d/m/Y H:i:s', time());
        echo json_encode($respon);
        return false;
      } else {
        $this->db->set(['sapa' => 1, 'timer' => $timer])->where('id', $cekTamu['id'])->update('tamu');
        $respon['kode'] = '2';
        $respon['nama'] = $cekTamu['nama'];
        $respon['alamat'] = $cekTamu['alamat'];
        $respon['waktu'] = date('d/m/Y H:i:s', $cekTamu['jam_hadir']);
        echo json_encode($respon);
        return false;
      }
    } else {
      $respon['kode'] = '3';
      echo json_encode($respon);
      return false;
    }
  }
}