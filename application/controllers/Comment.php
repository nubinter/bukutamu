<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
class Comment extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_user');
    $this->load->model('m_grup');
    $this->load->model('m_event');
    $this->load->model('m_initial');
    $this->load->model('m_coment');
    sedangLogout();
    setcoolor();
  }

  public function index()
  {
    if (!$this->session->userdata('sesiEventNewImam')) {
      redirect('seting');
    }
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $ini = 'H';
    $bg = $this->m_initial->colorInitial($ini);
    setcoolor();
    $data['bginit'] = $bg;
    $data['event'] = $event;
    $data['user'] = $user;
    $data['descr'] = base_url() . '- Buku Tamu';
    $data['icon'] = 'logo.png';
		$data['icon1'] = 'logo1.png';
    $data['title'] = base_url();
    $this->load->view('template/header', $data);
    $this->load->view('comment/index', $data);
  }



  public function loadListKomen()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $undangan = $this->db->get_where('undangan',['id' => $event['undangan_id']])->row_array();
    $url = $undangan['url'];
    $idpost = $event['id_post'];
    $list = $this->m_coment->getAllComment($url);
    $kodeRagu = 'Masih Ragu';
    $kodeHadir = 'Hadir';
    $kodeTidak = 'Tidak hadir';

    $filter = $_POST['filter'];
    $data = '';
    $jumlahPost = '';
    $ls = '';
    if ($list[0]['post'] == $idpost) {
      foreach ($list as $key) {


        $init = substr($key['author_name'], 0, 1);
        if ($key['meta']['konfirmasi'] == $kodeRagu) {
          $konfir = '<span class="badge badge-pill badge-secondary">' . $key['meta']['konfirmasi'] . '</span>';
        } elseif ($key['meta']['konfirmasi'] == $kodeTidak) {

          $konfir = '<span class="badge badge-pill badge-danger">' . $key['meta']['konfirmasi'] . '</span>';
        } elseif ($key['meta']['konfirmasi'] == $kodeHadir) {

          $konfir = '<span class="badge badge-pill badge-success">' . $key['meta']['konfirmasi'] . '</span>';
        } else {
          $konfir = '<span class="badge badge-pill badge-dark">Tidak diketahui</span>';
        }
        $data .= $key['meta']['konfirmasi'] . ',';
        $jumlahPost .= $key['post'] . ',';


        $tgl = strtotime($key['date']);
        $tgl = $this->m_time->DateTime(date('Y-m-d H:i:s', $tgl));


        if ($filter !== "All") {
          # code...
          if ($key['meta']['konfirmasi'] == $filter) {
            $ls .= '<li>';
            $ls .= '<span class="icon" style="background-color: ' . $this->m_initial->colorInitial($init) . '">' . $init . '</span>';
            $ls .= '<span class="tgl">' . $tgl . '<a href="" class="btnDelete" data-id="' . $key['id'] . '"><i class="far fa-trash-alt"></i></a></span>';
            $ls .= '<span class="title">' . $key['author_name'] . ' ' . $konfir . '</span>';
            $ls .= '<span class="sub-title">' . $key['content']['rendered'] . '</span>';
            $ls .= '</li>';
          }
        } else {
          $ls .= '<li>';
          $ls .= '<span class="icon" style="background-color: ' . $this->m_initial->colorInitial($init) . '">' . $init . '</span>';
          $ls .= '<span class="tgl">' . $tgl . '<a href="" class="btnDelete" data-id="' . $key['id'] . '"><i class="far fa-trash-alt"></i></a></span>';
          $ls .= '<span class="title">' . $key['author_name'] . ' ' . $konfir . '</span>';
          $ls .= '<span class="sub-title">' . $key['content']['rendered'] . '</span>';
          $ls .= '</li>';
        }
      }
      $jmulahnya = explode(',', $jumlahPost);
      $jmlCom = array_count_values($jmulahnya);
      $arr = explode(',', $data);
      $arr2 = array_count_values($arr);

      $tidak = array_search($kodeTidak, $arr);
      if ($tidak == false) {
        if ($arr[0] == $kodeTidak) {
          $tidak = $arr2[$kodeTidak];
        } else {
          $tidak = 0;
        }
      } else {
        $tidak = $arr2[$kodeTidak];
      }

      $hadir = array_search($kodeHadir, $arr);
      if ($hadir == false) {
        if ($arr[0] == $kodeHadir) {
          $hadir = $arr2[$kodeHadir];
        } else {
          $hadir = 0;
        }
      } else {
        $hadir = $arr2[$kodeHadir];
      }

      $ragu = array_search($kodeRagu, $arr);
      if ($ragu == false) {
        if ($arr[0] == $kodeRagu) {
          $ragu = $arr2[$kodeRagu];
        } else {
          $ragu = 0;
        }
      } else {
        $ragu = $arr2[$kodeRagu];
      }

      if ($ls == "" || $ls == null) {
        $ls = '<li><h6>Tidak ada Ucapan!</h6></li> ';
      }


      $json = [
        'kode' => 1,
        // 'total' => ($ragu + $tidak + $hadir),
        'total' => ($jmlCom[$idpost] + 0),
        'ragu' => $ragu,
        'hadir' => $hadir,
        'tidak' => $tidak,
        'list' => $ls,
        'undangan' => $url
      ];

      echo json_encode($json);
      return false;
    } else {
      $json = [
        'kode' => 2,
        'pesan' => 'Gagal membaca Komentar, Periksa ID Undangan atau kamu tidak termasuk dalam paket fitur ini.'
      ];

      echo json_encode($json);
      return false;
    }
  }




  public function deleteKomen($id)
  {
    $query = $this->m_coment->delComenApiById($id);
    if ($query == true) {
      echo 1;
    } else {
      echo 2;
    }
  }



  public function export()
  {
    ob_start();
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $undangan = $this->db->get_where('undangan',['id' => $event['undangan_id']])->row_array();
    $url = $undangan['url'];
    $list = $this->m_coment->getAllComment($url);

    $kodeRagu = 'Masih Ragu';
    $kodeHadir = 'Hadir';
    $kodeTidak = 'Tidak hadir';

    $lsss = '';
    $jumlahPost = '';
    foreach ($list as $key) {
      $lsss .= $key['meta']['konfirmasi'] . ',';
      $jumlahPost .= $key['post'] . ',';
    }

    $jmulahnya = explode(',', $jumlahPost);
    $jmlCom = array_count_values($jmulahnya);
    $arr = explode(',', $lsss);
    $arr2 = array_count_values($arr);

    $tidak = array_search($kodeTidak, $arr);
    if ($tidak == false) {
      if ($arr[0] == $kodeTidak) {
        $tidak = $arr2[$kodeTidak];
      } else {
        $tidak = 0;
      }
    } else {
      $tidak = $arr2[$kodeTidak];
    }

    $hadir = array_search($kodeHadir, $arr);
    if ($hadir == false) {
      if ($arr[0] == $kodeHadir) {
        $hadir = $arr2[$kodeHadir];
      } else {
        $hadir = 0;
      }
    } else {
      $hadir = $arr2[$kodeHadir];
    }

    $ragu = array_search($kodeRagu, $arr);
    if ($ragu == false) {
      if ($arr[0] == $kodeRagu) {
        $ragu = $arr2[$kodeRagu];
      } else {
        $ragu = 0;
      }
    } else {
      $ragu = $arr2[$kodeRagu];
    }

    $data['total'] = ($jmlCom[$idpost] + 0);
    $data['ragu'] = $ragu;
    $data['hadir'] = $hadir;
    $data['tidak'] = $tidak;

    $data['kodeHadir'] = $kodeHadir;
    $data['kodeTidak'] = $kodeTidak;
    $data['kodeRagu'] = $kodeRagu;
    $data['komen'] = $this->m_coment->getAllComment($url);
    $data['title'] = 'Ucapan - RSVP';
    $data['event'] = $event;
    $data['wedding'] = $event['wedding'];
    $this->load->view('comment/pdf', $data);
    $html = ob_get_contents();
    ob_end_clean();

    $pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', array(10, 10, 10, 10));
    $pdf->WriteHTML($html);
    $pdf->Output('RSVP & Ucapan_' . $event['nama'] . '.pdf');
  }


  public function cekKoment()
  {
    $list = $this->m_coment->getAllComment();
    var_dump($list);
  }


  // SET
  public function setingUrl()
  {
    redirect('seting');
    setcoolor();
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $data['listUndangan'] = $this->db->get_where('undangan')->row_array();
    $data['event'] = $event;
    $data['user'] = $user;
    $data['descr'] = base_url() . '- Buku Tamu';
    $data['icon'] = 'logo.png';
		$data['icon1'] = 'logo1.png';
    $data['title'] = base_url();
    $this->load->view('template/header', $data);
    $this->load->view('comment/seting', $data);
  }


  public function addToken()
  {
    $id = $this->input->post('id');
    $token = trim($this->input->post('token'));

    $query =  $this->db->set('token', $token)->where('id', $id)->update('undangan');
    if ($query) {
      echo 1;
    } else {
      echo 2;
    }
  }






  public function load()
  {
    setcoolor();
  }
}