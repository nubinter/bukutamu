<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Spipu\Html2Pdf\Html2Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;


class Tamu extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_user');
    $this->load->model('m_tamu');
    $this->load->model('m_grup');
    $this->load->model('m_event');
    $this->load->model('m_whatsapp');
    sedangLogout();
  }

  public function index()
  {
    if (!$this->session->userdata('sesiEventNewImam')) {
      redirect('seting');
    }
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $data['senders'] = $this->m_whatsapp->byUserId($user['id']);
    $data['event'] = $event;
    $data['group'] = $this->m_grup->byEvent($event['id']);
    $data['user'] = $user;
    $data['descr'] = 'Data Tamu - Bukutamu Digital';
    $data['icon'] = 'logo.png';
    $data['icon1'] = 'logo1.png';
    $data['title'] = base_url();
    $this->load->view('template/header', $data);
    $this->load->view('tamu/index', $data);
  }
  
  public function addData()
  {
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $nama = trim($this->input->post('nama'));
    $nama = str_replace('&', 'dan', $nama);
    $nama = str_replace("'", '', $nama);
    $nama = str_replace('"', '', $nama);
    $nama = str_replace('/', 'atau', $nama);
    $alamat = $this->input->post('alamat');
    $vip = $this->input->post('vip');
    $group = $this->input->post('group');
	$nomor_wa = trim($this->input->post('nomor_wa'));
	$nomor_meja = trim($this->input->post('nomor_meja'));
    $cek = $this->m_tamu->byNama($nama, $event['id']);

    if ($cek) {
      $json = [
        'kode' => 2,
        'pesan' => 'Nama Tamu sudah ada!'
      ];
      echo json_encode($json);
      return false;
    }
    $data = [
      'event_id' => $event['id'],
      'nama' => $nama,
      'alamat' => $alamat,
      'vip' => $vip,
      'qr' => 0,
	  'nomor_wa' => $nomor_wa,
	  'nomor_meja' => $nomor_meja,
      'group_id' => $group
    ];
    $query = $this->db->insert('tamu', $data);
    if ($query) {
      $json = [
        'kode' => 1,
        'pesan' => 'Data telah ditambahkan!'
      ];
      echo json_encode($json);
    } else {
      $json = [
        'kode' => 2,
        'pesan' => 'Gagal Tersimpan!'
      ];
      echo json_encode($json);
    }
  }


  public function editData()
  {
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $nama = trim($this->input->post('nama'));
    $nama = str_replace('&', 'dan', $nama);
    $nama = str_replace("'", '', $nama);
    $nama = str_replace('"', '', $nama);
    $nama = str_replace('/', 'atau', $nama);
    $alamat = $this->input->post('alamat');
    $vip = $this->input->post('vip');
    $id = $this->input->post('id');
    $nomor_wa = trim($this->input->post('nomor_wa'));
	$nomor_meja = trim($this->input->post('nomor_meja'));
    $group = $this->input->post('group');
    $cek = $this->m_tamu->byNama($nama, $event['id']);
    $cekId = $this->m_tamu->byId($id);

    $qr = $cekId['nama'];
    $qr1 = $cekId['id'];
    if (file_exists('assets/img/qr/' . $qr . '.png')) {
      unlink(FCPATH . 'assets/img/qr/' . $qr . '.png');
    }
    if (file_exists('assets/img/qr/' . $qr1 . '.png')) {
      unlink(FCPATH . 'assets/img/qr/' . $qr1 . '.png');
    }

    if ($cek) {
      if ($cek['id'] != $id) {
        $json = [
          'kode' => 2,
          'pesan' => 'Duplikat NAMA.!'
        ];
        echo json_encode($json);
        return false;
      }
    }
    $data = [
      'nama' => $nama,
      'alamat' => $alamat,
      'vip' => $vip,
      'group_id' => $group,
	  'nomor_wa' => $nomor_wa,
	  'nomor_meja' => $nomor_meja,
    ];
    $query = $this->db->set($data)->where('id', $id)->update('tamu');
    if ($query) {
      $json = [
        'kode' => 1,
        'pesan' => 'Data Updated'
      ];
      echo json_encode($json);
    } else {
      $json = [
        'kode' => 2,
        'pesan' => 'Gagal Tersimpan!'
      ];
      echo json_encode($json);
    }
  }
  
  public function group($event_id)
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($event_id);
    $data['event'] = $event;
    $data['user'] = $user;
    $data['descr'] = base_url() . '- Buku Tamu';
    $data['icon'] = 'logo.png';
		$data['icon1'] = 'logo1.png';
    $data['title'] = base_url();
    $this->load->view('template/header', $data);
    $this->load->view('tamu/grup', $data);
  }

  public function delete_group()
  {
    $group_id = $this->input->post('id');
    $event_id = $this->input->post('event_id');
    $tamu = $this->m_tamu->jmlTamuByGroupEvent($group_id,$event_id);
    if($tamu == 0) {
        $this->db->where('id', $group_id)->delete('group_tamu');
        $json = [
            'kode' => 1,
            'pesan' => 'Grup telah dihapus!'
        ];
        echo json_encode($json);
        return false;
    } else {
        $json = [
            'kode' => 2,
            'pesan' => 'Grup yang sudah memiliki daftar tamu. tidak dapat dihapus!'
        ];
        echo json_encode($json);
        return false;
    }
  }
  
  public function addGroup($event_id)
  {
    $event = $this->m_event->byId($event_id);
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $nama = trim($this->input->post('nama'));
    $kode = $this->input->post('kode');
    $deskripsi = $this->input->post('deskripsi');
    $cekNama = $this->m_grup->byNama($nama, $event['id']);
    $cekKode = $this->m_grup->byKode($kode, $event['id']);

    if ($cekNama) {
      $json = [
        'kode' => 2,
        'pesan' => 'Nama Grup sudah ada!'
      ];
      echo json_encode($json);
      return false;
    }
    
    if ($cekKode) {
      $json = [
        'kode' => 2,
        'pesan' => 'Kode grup ini sudah digunakan!'
      ];
      echo json_encode($json);
      return false;
    }
    $data = [
      'event_id' => $event['id'],
      'user_id' => $user['id'],
      'nama' => $nama,
      'deskripsi' => $deskripsi,
      'kode' => $kode,
    ];
    $query = $this->db->insert('group_tamu', $data);
    if ($query) {
      $json = [
        'kode' => 1,
        'pesan' => 'Grup telah ditambahkan!',
        'event_id' => $event['id']
      ];
      echo json_encode($json);
    } else {
      $json = [
        'kode' => 2,
        'pesan' => 'Gagal Tersimpan!'
      ];
      echo json_encode($json);
    }
  }

  public function editGroup()
  {
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $nama = trim($this->input->post('nama'));
    $deskripsi = $this->input->post('deskripsi');
    $kode = $this->input->post('kode');
    $id = $this->input->post('id');
    $cekNama = $this->m_grup->byNama($nama, $event['id']);
    $cekKode = $this->m_grup->byKode($kode, $event['id']);

    if ($cekNama) {
      if ($cekNama['id'] != $id) {
        $json = [
          'kode' => 2,
          'pesan' => 'Nama grup sudah digunakan!'
        ];
        echo json_encode($json);
        return false;
      }
    }
    
    if ($cekKode) {
      if ($cekKode['id'] != $id) {
        $json = [
          'kode' => 2,
          'pesan' => 'Kode ini sudah digunakan!'
        ];
        echo json_encode($json);
        return false;
      }
    }
    $data = [
      'event_id' => $event['id'],
      'user_id' => $user['id'],
      'nama' => $nama,
      'deskripsi' => $deskripsi,
      'kode' => $kode,
    ];
    $query = $this->db->set($data)->where('id', $id)->update('group_tamu');
    if ($query) {
      $json = [
        'kode' => 1,
        'pesan' => 'Data Grup Telah Diperbarui',
        'event_id' => $event['id']
      ];
      echo json_encode($json);
    } else {
      $json = [
        'kode' => 2,
        'pesan' => 'Gagal Tersimpan!'
      ];
      echo json_encode($json);
    }
  }

  public function loadDataGrup($event_id)
  {
    $list = $this->m_grup->byEvent($event_id);
    $data = '';
    $i = 1;
    foreach ($list as $key) {
        $data .= '<li>';
        $data .= '<input id="idgrup" value="' . $key['id'] . '" style="display:none">';
        $data .= '<span class="nomor">' . $i++ . '.</span>';
        $data .= '<span class="option"><div class="dropdown">';
        $data .= '<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"><i class="far fa-cogs"></i></a>';
        $data .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">';
        $data .= '<a class="dropdown-item btnEdit" data-id="' . $key['id'] . '" data-nama="' . $key['nama'] . '" data-deskripsi="' . $key['deskripsi'] . '" data-kode="' . $key['kode'] . '" href="#"><i class="fas fa-edit mr-2" style="font-size: 16px;"></i>Edit Grup</a>';
        $data .= '<a class="dropdown-item btnDelete" data-id="' . $key['id'] . '" data-event="'.$key['event_id'].'" href="#" style="color: #FF0000;" ><i class="fas fa-trash mr-2" style="font-size: 16px; color: #FF0000;"></i> Hapus Grup</a>';
        $data .= '</div></div></span>';
        $data .= '<span class="title">' . $key['nama'] . '</span>';
        $data .= '<span class="sub-title">Kode grup : ' . $key['kode'] .'</span>';
        $data .= '</li>';
    }
    $output = [
        'totalRecord' => $this->m_grup->count_data($event_id),
        'listPage' => $data
    ];
    echo json_encode($output);
  }

  public function loadDataTamu()
  {
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $page = $_POST['page'];
    $list = $this->m_tamu->getTable($event['id']);
    if ($page <= 1) {
      # code...
      $number = $page;
    } else {
      $number = 18 * ($page - 1) + 1;
    }

    $data = '';
    $i = $number;
    foreach ($list as $key) {
      if ($key['vip'] == 1) {
        $vipStat = true ;
        $vip = ' | <span class="badge badge-custom">VIP</span>';
      } else {
        $vip = '';
        $vipStat = true ;
      }
      $nama = $key['nama'];
      $nama = str_replace('&', 'dan', $nama);
      $nama = str_replace("'", '', $nama);
      $nama = str_replace('"', '', $nama);
      $nama = str_replace('/', 'atau', $nama);
      $data .= '<li>';
      $data .= '<input id="idtamu" value="' . $key['id'] . '" style="display:none">';
      $data .= '<span class="nomor">' . $i++ . '.</span>';
      $data .= '<span class="option"><div class="dropdown">';
      $data .= '<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"><i class="far fa-ellipsis-v" style="font-size: 22px;"></i></a>';
      $data .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">';
      $data .= '<a class="dropdown-item btnWaMe" data-id="' . $key['id'] . '" href="#"><i class="fab fa-whatsapp mr-2" style="font-size: 18px;"></i>Kirim WhatsApp (Manual)</a>';
      $data .= '<a class="dropdown-item btnWa" data-id="' . $key['id'] . '" href="#" style="background-color: orange; color: black;"><i class="fab fa-whatsapp mr-2" style="font-size: 18px; color: black;"></i>Kirim WhatsApp (Auto)</a>';
      $data .= '<a class="dropdown-item btnCopy" data-id="' . $key['id'] . '" href="#"><i class="fas fa-copy mr-2" style="font-size: 16px;"></i>Salin Kalimat Undangan</a>';
      $data .= '<a class="dropdown-item btnQr" data-vip="'.$vipStat.'" data-id="' . $key['id'] . '" href="#"><i class="fas fa-qrcode mr-2" style="font-size: 16px;"></i>Unduh QR Code</a>';
      $data .= '<a class="dropdown-item btnEdit" data-id="' . $key['id'] . '" data-nama="' . $nama . '" data-alamat="' . $key['alamat'] . '" data-vip="' . $key['vip'] . '" data-group="' . $key['group_id'] . '" data-wa="'.$key['nomor_wa'].'" data-meja="'.$key['nomor_meja'].'" href="#"><i class="fas fa-edit mr-2" style="font-size: 14px;"></i>Edit Data Tamu</a>';
      $data .= '<a class="dropdown-item btnDelete" data-id="' . $key['id'] . '" data-nama="' . $nama . '" href="#" style="color: #FF0000;"><i class="fas fa-trash mr-2" style="font-size: 14px; color: #FF0000;"></i> Hapus Tamu</a>';
      $data .= '<a class="dropdown-item btnUndangan" data-id="' . $key['id'] . '" href="#"><i class="fas fa-external-link-alt mr-2" style="font-size: 16px;"></i>Preview Undangan</a>';
      $data .= '</div></div></span>';
      $data .= '<span class="title">' . $key['nama'] . '</span>';
      $data .= '<span class="sub-title">' . $key['alamat'] . $vip . '</span>';
      $data .= '</li>';
    }

    $output = [
      'totalRecord' => $this->m_tamu->count_filter($event['id']),
      'listPage' => $data,
      'totalData' => $this->m_tamu->count_all($event['id'])
    ];

    echo json_encode($output);
  }


  public function pdf()
  {
    ob_start();
    $id = $_GET['data'];
    $id = explode(',', $id);
    $no = 0;
    $datan = [];
    foreach ($id as $key) {
      $idn = $id[$no];
      $tamu = $this->db->get_where('tamu', ['id' => $idn])->row_array();
      // $event = $this->m_event->byId($this->session->userdata('sessionEventCek'));
      // if (!file_exists('assets/img/qr/' . $tamu['id'] . '.png')) {
      // }
      $nama = $tamu['nama'];
      $nama = str_replace('&', 'dan', $nama);
      $nama = str_replace("'", '', $nama);
      $nama = str_replace('"', '', $nama);
      $nama = str_replace('/', 'atau', $nama);
      
      $this->creatBarcode($nama, $tamu['id']);

      array_push($datan, [
        'tamu' => $nama,
        'qr' => $tamu['id'],
        'vip' => $tamu['vip'],
      ]);
      $no++;
    }

    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));

    $data['judul'] = 'Print Qrcode';
    $data['tamu'] = $datan;
    $data['event'] = $event;
    $this->load->view('tamu/pdf', $data);

    $html = ob_get_contents();
    ob_end_clean();

    $pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', array(20, 10, 20, 10));
    $pdf->WriteHTML($html);
    $pdf->Output('./assets/img/print.pdf');
  }

  public function deleteAll()
  {
    $data = $this->input->post('id');
    $no = 0;
    foreach ($data as $key) {
      $id = $data[$no];
      $tamu = $this->db->get_where('tamu', ['id' => $id])->row_array();
      $nama = $tamu['nama'];
      $nama = str_replace('&', 'dan', $nama);
      $nama = str_replace("'", '', $nama);
      $nama = str_replace('"', '', $nama);
      $nama = str_replace('/', 'atau', $nama);
      $qr = $tamu['nama'];
      $qr1 = $tamu['id'];
      $qr2 = $nama;
      if (file_exists('assets/img/qr/' . $qr . '.png')) {
        unlink(FCPATH . 'assets/img/qr/' . $qr . '.png');
      }
      if (file_exists('assets/img/qr/' . $qr1 . '.png')) {
        unlink(FCPATH . 'assets/img/qr/' . $qr1 . '.png');
      }
      if (file_exists('assets/img/qr/' . $qr2 . '.png')) {
        unlink(FCPATH . 'assets/img/qr/' . $qr2 . '.png');
      }
      $this->db->where('id', $id)->delete('tamu');

      $no++;
    }
  }



  public function delete()
  {
    $id = $this->input->post('id');
    $tamu = $this->db->get_where('tamu', ['id' => $id])->row_array();
    $nama = $tamu['nama'];
    $nama = str_replace('&', 'dan', $nama);
    $nama = str_replace("'", '', $nama);
    $nama = str_replace('"', '', $nama);
    $nama = str_replace('/', 'atau', $nama);
    $qr = $tamu['nama'];
    $qr1 = $tamu['id'];
    $qr2 = $nama;
    if (file_exists('assets/img/qr/' . $qr . '.png')) {
      unlink(FCPATH . 'assets/img/qr/' . $qr . '.png');
    }
    if (file_exists('assets/img/qr/' . $qr1 . '.png')) {
      unlink(FCPATH . 'assets/img/qr/' . $qr1 . '.png');
    }
    if (file_exists('assets/img/qr/' . $qr2 . '.png')) {
      unlink(FCPATH . 'assets/img/qr/' . $qr2 . '.png');
    }
    $this->db->where('id', $id)->delete('tamu');
  }





   public function creatBarcode($barcode, $name)
  {
    $this->load->library('ciqrcode'); //pemanggilan library QR CODE
    $config['cacheable']    = true; //boolean, the default is true
    $config['cachedir']     = './assets/img/'; //string, the default is application/cache/
    $config['errorlog']     = './assets/img/'; //string, the default is application/logs/
    $config['imagedir']     = './assets/img/qr/'; //direktori penyimpanan qr code
    $config['quality']      = true; //boolean, the default is true
    $config['size']         = '1024'; //interger, the default is 1024
    $config['black']        = array(255, 255, 255); // array, default is array(255,255,255)
    $config['white']        = array(0, 0, 0); // array, default is array(0,0,0)
    $this->ciqrcode->initialize($config);

    $qrName = $name . '.png'; //buat name dari qr code sesuai dengan nik

    $params['data'] = $barcode; //data yang akan di jadikan QR CODE
    $params['level'] = 'H'; //H=High
    $params['size'] = 10;
    $params['savename'] = FCPATH . $config['imagedir'] . $qrName; //simpan image QR CODE ke folder assets/images/
    return $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
  }


  public function cekQr()
  {
    $id = $this->input->post('id');
    $cek = $this->m_tamu->byId($id);
    $nama = $cek['nama'];
      $nama = str_replace('&', 'dan', $nama);
      $nama = str_replace("'", '', $nama);
      $nama = str_replace('"', '', $nama);
      $nama = str_replace('/', 'atau', $nama);
      $this->creatBarcode($cek['nama'], $nama);
    $cek = $this->m_tamu->byId($id);
    $json = [
      'kode' => 1,
      'qr' => base_url('assets/img/qr/' . $cek['nama'] . '.png'),
      'nama' => $nama,
      'alamat' => $cek['alamat'],
      'vip' => $cek['vip']
    ];
    echo json_encode($json);
  }

  public function cekWa()
  {
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $id = $this->input->post('id');
    $cekTamu = $this->m_tamu->byId($id);

    $nama = $cekTamu['nama'];
    $nama = str_replace('&', 'dan', $nama);
    $nama = str_replace("'", '', $nama);
    $nama = str_replace('"', '', $nama);
    $nama = str_replace('/', 'atau', $nama);
    $namakode = urlencode($nama);
    $link = $event['undangan'] . '?to=' . $namakode;

    $wa = $event['wa'];
    $text = str_replace('[NAMA-TAMU]', $cekTamu['nama'], $wa);
    $text = str_replace('[LINK]', $link, $text);
    if($event['is_qr'] != 0) {
      $text = str_replace('[E-INVITATION]', '', $text);
    } else {
      $img_undangan = base_url('whatsapp/undangan/'.$event['id'].'/'.$tamu['id']);
      $text = str_replace('[E-INVITATION]', $img_undangan, $text);
    }

    $json = [
      'kode' => 1,
      'message' => $text
    ];
    echo json_encode($json);
  }

  public function shareWaMe()
  {
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $id = $this->input->post('id');
    $cekTamu = $this->m_tamu->byId($id);

    $nama = $cekTamu['nama'];
    $nama = str_replace('&', 'dan', $nama);
    $nama = str_replace("'", '', $nama);
    $nama = str_replace('"', '', $nama);
    $nama = str_replace('/', 'atau', $nama);
    $namakode = urlencode($nama);
    $link = $event['undangan'] . '?to=' . $namakode;
    $img_undangan = base_url('whatsapp/undangan/'.$event['id'].'/'.$id);

    $wa = $event['wa'];
    $text = str_replace('[NAMA-TAMU]', $cekTamu['nama'], $wa);
    $text = str_replace('[LINK]', $link, $text);
    $text = str_replace('[E-INVITATION]', $img_undangan, $text);
    
    $link = urlencode($text);
    $wa = 'https://wa.me/'. $cekTamu['nomor_wa'] . '?text=' . $link;
    echo $wa;
  }

  public function shareLink()
  {
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $id = $this->input->post('id');
    $cekTamu = $this->m_tamu->byId($id);

    $nama = $cekTamu['nama'];
    $nama = str_replace(' ', '%20', $nama);
    $nama = str_replace('&', 'dan', $nama);
    $nama = str_replace("'", '', $nama);
    $nama = str_replace('"', '', $nama);
    $nama = str_replace('/', 'atau', $nama);
    $namakode = urlencode($nama);
    $link = $event['undangan'] . '?to=' . $nama;

    $wa = $link;
    echo $wa;
  }


  // IMPORT
  public function import()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $data['event'] = $event;
    $data['user'] = $user;
    $data['descr'] = base_url() . '- Buku Tamu';
    $data['icon'] = 'logo.png';
		$data['icon1'] = 'logo1.png';
    $data['title'] = base_url();
    $data['jml'] = $this->m_tamu->jmlTamuImport($event['id']);
    $data['tamu'] = $this->m_tamu->importbyEvent($event['id']);
    $this->load->view('template/header', $data);
    $this->load->view('tamu/import', $data);
  }


  public function dwlTemplate()
  {
    $data = 'assets/img/page/templateDataTamu.xlsx';
    force_download($data, null);
    
  }

  public function getTemplate()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $spreadsheet = IOFactory::load('assets/img/page/templateDataTamu.xlsx');
    $sheet = $spreadsheet->getActiveSheet();
    
    $data = $this->m_grup->byEvent($this->session->userdata('sesiEventNewImam'));
    // Kolom tempat Anda ingin memulai penambahan data (F dan G)
    $kolomG = 'G';
    $kolomH = 'H';
    // Baris tempat Anda ingin memulai penambahan data (misalnya, baris 1)
    $baris = 2;
    // Loop melalui data dan menambahkannya ke spreadsheet
    foreach ($data as $item) {
        $sheet->setCellValue($kolomG . $baris, $item['nama']);
        $sheet->setCellValue($kolomH . $baris, $item['kode']);
        $baris++;
    }
    // Simpan perubahan ke dalam file Excel
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    //$writer->save('excel/template_tamu.xlsx');
   // Tentukan header untuk mengunduh file Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="template_tamu.xlsx"');

    // Menggunakan php://output untuk mengirimkan file ke browser
    $writer->save('php://output');
  }

  public function delImport()
  {
    $id = $this->input->post('id');
    $this->db->where('id', $id)->delete('tamu_import');
  }



  public function importExcel()
  {
    // Load plugin PHPExcel nya

    $config['upload_path'] = './excel/upload';
    $config['allowed_types'] = 'xlsx|xls|csv';
    $config['max_size'] = '10000';
    $config['overwrite'] = true;
    $config['encrypt_name'] = true;

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('file')) {

      //upload gagal
      $this->session->set_flashdata('gagal', $this->upload->display_errors());
      //redirect halaman
      redirect('tamu/import');
    } else {

      $data_upload = $this->upload->data();
	  
      $spreadsheet = IOFactory::load('excel/upload/' . $data_upload['file_name']);
		$worksheet = $spreadsheet->getActiveSheet();
		$data = [];

		$event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
		$event = $event['id'];

		foreach ($worksheet->getRowIterator(2) as $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false);
			
			$rowData = [];
			
			foreach ($cellIterator as $cell) {
				$rowData[] = $cell->getValue();
			}
			if($rowData[0] == NULL) {
				
			} else {
			    $grup = $this->m_grup->byKode($rowData[3], $event);
				$data[] = [
					'nama' => $rowData[0],
					'alamat' => $rowData[1],
					'vip' => $rowData[2],
					'group_id' => $grup['id'],
					'nomor_wa' => $rowData[4],
					'nomor_meja' => $rowData[5],
					'event_id' => $event,
				];
			}
		}
		//var_dump($data);
		$this->db->insert_batch('tamu_import', $data);

      //delete file from server
      unlink(FCPATH . 'excel/upload/' . $data_upload['file_name']);
      $temp = glob('excel/upload/*');
      foreach ($temp as $tmp) {
        if (is_file($tmp))
          unlink($tmp); //delete file
      }

      //upload success
      redirect('tamu/import');
    }
  }



  public function addDataImport()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));

    $tamuImport = $this->m_tamu->importbyEvent($event['id']);
    $jmlImp = $this->m_tamu->jmlTamuImport($event['id']);

    if ($jmlImp > 0) {

      // $data = [];
      $numrow = 1;
      foreach ($tamuImport as $key) {
        $nama = trim($key['nama']);
        $nama = str_replace('&', 'dan', $nama);
        $nama = str_replace("'", '', $nama);
        $nama = str_replace('"', '', $nama);
        $nama = str_replace('/', 'atau', $nama);
        $alamat = $key['alamat'];
        $vip = $key['vip'];
        $group = $key['group_id'];
        $nomor_wa = $key['nomor_wa'];
        $nomor_meja = $key['nomor_meja'];

        if ($alamat == "") {
          $alamat = '-';
        }

        $cekTamu = $this->m_tamu->byNama($nama, $event['id']);
        if ($cekTamu) {
          $this->db->set('nama', $nama)->set('nomor_wa', $nomor_wa)->set('alamat', $alamat)->set('group_id', $group)->set('vip', $vip)->where('id', $cekTamu['id'])->update('tamu');
        } else {

          $data = [
            'event_id' => $event['id'],
            'nama' => $nama,
            'alamat' => $alamat,
            'vip' => $vip,
            'qr' => $key['id'] . time(),
            'nomor_wa' => $nomor_wa,
            'nomor_meja' => $nomor_meja,
            'group_id' => $group
          ];
          $this->db->insert('tamu', $data);
        }
      }
      $this->db->where('event_id', $event['id'])->delete('tamu_import');

      echo 1;
    } else {
      echo 2;
    }
  }



  // KEHADIRAN

  public function report()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $data['event'] = $event;
    $data['user'] = $user;
    $data['group'] = $this->m_grup->byEvent($event['id']);
    $data['descr'] = base_url() . '- Buku Tamu';
    $data['icon'] = 'logo.png';
		$data['icon1'] = 'logo1.png';
    $data['title'] = base_url();
    $this->load->view('template/header', $data);
    $this->load->view('tamu/report', $data);
  }

  public function loadReportTamu()
  {
    $this->load->model('m_report');
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $page = $_POST['page'];
    $list = $this->m_report->getTable($event['id']);
    if ($page <= 1) {
      # code...
      $number = $page;
    } else {
      $number = 18 * ($page - 1) + 1;
    }

    $data = '';
    $i = $number;
    foreach ($list as $key) {
      if ($key['vip'] == 1) {
        $vip = ' | <span class="badge badge-custom">VIP</span>';
      } else {
        $vip = '';
      }
      if ($key['jam_hadir'] <= 0) {
        $waktu = 'Tidak Hadir';
        $jml = '';
      } else {
        $waktu = date('d/m/Y H:i:s', $key['jam_hadir']);
        $jml = ' | <span class="text-bold">' . $key['jml_tamu']. '</span> Orang';
      }
      
      $nama = $key['nama'];
      
       $nama = str_replace('&', 'dan', $nama);
        $nama = str_replace("'", '', $nama);
        $nama = str_replace('"', '', $nama);
        $nama = str_replace('/', 'atau', $nama);

      $data .= '<li>';
      $data .= '<input id="idtamu" value="' . $key['id'] . '" style="display:none">';
      $data .= '<span class="nomor">' . $i++ . '.</span>';
      $data .= '<span class="tgl">' . $waktu . '</span>';
      $data .= '<span class="title">' . $nama . '</span>';
      if($event['fitur_ampao'] == 1) {
        $data .= '<span class="sub-title">' . $key['alamat'] . $vip . $jml . ' |  <span class="text-bold">'.$key['nomor_ampao'].'</span></span>';
      } else {
        $data .= '<span class="sub-title">' . $key['alamat'] . $vip . $jml . '</span>';
      }
      $data .= '</li>';
    }

    $totalTamu = $this->m_report->jmlUndangan($event['id']);

    if ($totalTamu <= 0) {
      $totalTamu = 0;
    }

    if ($_POST['hadir'] == '1') {
      $jmlFilter = $this->m_report->jmlTamuHadir($event['id']);
    } else {
      $jmlFilter = $this->m_report->jmlTamuTidakHadir($event['id']);
    }

    if ($jmlFilter <= 0) {
      $jmlFilter = 0;
    }

    $udgHadir = $this->m_report->jmlUndanganHadir($event['id']);
    if ($udgHadir <= 0) {
      $udgHadir = 0;
    }

    $output = [
      'totalRecord' => $this->m_report->count_filter($event['id']),
      'listPage' => $data,
      'totalData' => $jmlFilter,
      'totalHadir' => $udgHadir,
      'totalUndangan' => $totalTamu,
    ];

    echo json_encode($output);
  }


  public function excel($hadir = 2, $group = '')
  {
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    if ($hadir == '1') {
      $this->db->where('jam_hadir >', 0);
      $namaFile = 'Data_tamu_hadir_' . $event['nama'];
      $namaFile = str_replace(' ', '_', $namaFile);
      $judul = 'Data Tamu Hadir<br>' . $event['nama'];
    } else {
      $this->db->where('jam_hadir <=', 0);
      $namaFile = 'Data_tamu_tidak_hadir_' . $event['nama'];
      $namaFile = str_replace(' ', '_', $namaFile);
      $judul = 'Data Tamu Tidak Hadir<br>' . $event['nama'];
    }
    if ($group != "" || $group != null) {
      $this->db->where('group_id', $group);
    }
    $this->db->where('event_id', $event['id']);
    $tamu = $this->db->get('tamu')->result_array();

    $data['namaFile'] = $namaFile;
    $data['title'] = $judul;
    $data['icon'] = 'brand.png';
    $data['tamu'] = $tamu;
    $data['event'] = $event;
    $this->load->view('tamu/excel', $data);
  }


  public function exportPdf($hadir = 2, $group = '')
  {
    ob_start();
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    if ($hadir == '1') {
      $this->db->where('jam_hadir >', 0);
      $judul = 'Tamu Hadir';
    } else {
      $this->db->where('jam_hadir <=', 0);
      $judul = 'Tamu Tidak Hadir';
    }
    if ($group != "" || $group != null) {
      $this->db->where('group_id', $group);
    }
    $this->db->where('event_id', $event['id']);
    $tamu = $this->db->get('tamu')->result_array();

    $data['title'] = $judul;
    $data['icon'] = 'brand.png';
    $data['tamu'] = $tamu;
    $data['event'] = $event;
    $this->load->view('tamu/ex_pdf', $data);

    $html = ob_get_contents();
    ob_end_clean();

    $pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', array(10, 10, 10, 10));
    $pdf->WriteHTML($html);
    $pdf->Output($judul . '.pdf');
  }
}