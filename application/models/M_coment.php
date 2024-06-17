<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_coment extends CI_Model
{

  public function getEventById($id)
  {
    $this->db->where('id', $id);
    $query = $this->db->get('event')->row_array();
    return $query;
  }

  public function getUndanganUrlById($id)
  {
    $this->db->where('id', $id);
    $query = $this->db->get('undangan')->row_array();
    return $query;
  }

  public function getAllComment($url)
  {
    $event = $this->getEventById($this->session->userdata('sesiEventNewImam'));
    
    $idpost = $event['id_post'];

    // persiapkan curl
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . "/wp-json/wp/v2/comments?post=" . $idpost . "&per_page=100");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $output = json_decode(json_encode($output, true));
    $output = json_decode($output, true);
    if ($httpcode == 200) {
      # code...
      return $output;
    } else {
      return $httpcode;
    }
  }


  public function delComenApiById($id)
  {
    $event = $this->getEventById($this->session->userdata('sesiEventNewImam'));
    $undangan = $this->getUndanganUrlById($event['undangan_id']);
    $url = $undangan['url'];
    $token = $undangan['token'];
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url . '/wp-json/wp/v2/comments/' . $id,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'DELETE',
      CURLOPT_POSTFIELDS => 'force=true',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic ' . $token, 'Content-Type: application/x-www-form-urlencoded'
      ),
    ));

    $response = curl_exec($curl);
    $res= json_decode($response, true);
    curl_close($curl);
    if($res['code'] == 'rest_cannot_delete') {
      return false;
    }
    return true;
  }





  public function requestKomentApi()
  {
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    if ($event['post_id'] !== null || $event['post_id'] !== "") {
      $output = $this->getAllComment($event['post_id']);
      if ($output[0]['post'] == $event['post_id']) {
        foreach ($output as $key) {
          $id_com = $key['id'];
          $id_post = $key['post'];
          $nama = $key['author_name'];
          $tgl = strtotime($key['date']);
          $msg = $key['content']['rendered'];
          $link_c = $key['link'];
          $link_c = substr($link_c, 0, strpos($link_c, '#'));
          $avatar = $key['author_avatar_urls']['96'];
          $konfir = $key['meta']['konfirmasi'];

          $cekKomentDb = $this->db->get_where('koment', ['id_com' => $id_com])->row_array();
          if (!$cekKomentDb) {
            $data = [
              'id_com' => $id_com,
              'id_post' => $id_post,
              'nama' => $nama,
              'tgl' => $tgl,
              'msg' => $msg,
              'link_c' => $link_c,
              'avatar' => $avatar,
              'konfir' => $konfir
            ];
            $this->db->insert('koment', $data);
          }
        }
      }
    }
    return true;
  }




  public function getDbComent2($post)
  {
    $this->db->from('koment');

    if ($this->session->userdata('sesiMetaKonfirm')) {
      $this->db->where('konfir', $this->session->userdata('sesiMetaKonfirm'));
    }

    $this->db->where('id_post', $post);
    $query = $this->db->get()->result_array();
    return $query;
  }


  public function getDbComent($post)
  {
    $this->db->from('koment');

    $page = $this->input->post('page');
    $page = ($page - 1);
    $perpage = 10;
    $resultFilter = ($perpage * $page);

    $this->db->limit($perpage, $resultFilter);

    if ($this->session->userdata('sesiMetaKonfirm')) {
      $this->db->where('konfir', $this->session->userdata('sesiMetaKonfirm'));
    }

    $this->db->where('id_post', $post);
    $query = $this->db->get()->result_array();
    return $query;
  }


  public function countComentFilter($post)
  {
    $this->db->from('koment');

    $page = $this->input->post('page');
    $page = ($page - 1);
    $perpage = 10;
    $resultFilter = ($perpage * $page);

    $this->db->limit($perpage, $resultFilter);

    if ($this->session->userdata('sesiMetaKonfirm')) {
      $this->db->where('konfir', $this->session->userdata('sesiMetaKonfirm'));
    }

    $this->db->where('id_post', $post);
    $query = $this->db->get()->num_rows();
    return $query;
  }

  public function countComentHadir($post)
  {
    $this->db->from('koment');

    $this->db->where('konfir', 'Hadir');

    $this->db->where('id_post', $post);
    return $this->db->count_all_results();
  }

  public function countComentNoHadir($post)
  {
    $this->db->from('koment');

    $this->db->where('konfir', 'Tidak Hadir');

    $this->db->where('id_post', $post);
    return $this->db->count_all_results();
  }

  public function countComentRagu($post)
  {
    $this->db->from('koment');

    $this->db->where('konfir', 'Masih Ragu');

    $this->db->where('id_post', $post);
    return $this->db->count_all_results();
  }

  public function countComentAll($post)
  {
    $this->db->from('koment');

    $this->db->where('id_post', $post);
    return $this->db->count_all_results();
  }
}