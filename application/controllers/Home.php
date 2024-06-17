<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_user');
    $this->load->model('m_event');
    $this->load->model('m_tamu');
    $this->load->model('m_grup');
    setcoolor();
    sedangLogout();
  }

  public function index()
  {
    setcoolor();
    if (!$this->session->userdata('sesiEventNewImam')) {
      redirect('seting');
    }
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $data['event'] = $event;
    $data['user'] = $user;
    $data['descr'] = 'Bukutamu Digital Masa Kini!';
    $data['icon'] = 'logo.png';
	$data['icon1'] = 'logo1.png';
    $data['title'] = 'Fitur Bukutamu Digital';
    $data['group'] = $this->m_grup->byEvent($event['id']);
    $this->load->view('template/header', $data);
    $this->load->view('home/index', $data);
  }




  public function chekcode()
  {
    $barcode = trim($this->input->post('barcode'));
    $idEvent = $this->session->userdata('sesiEventNewImam');
    $this->db->set('sapa', 0)->where(['event_id' => $idEvent])->update('tamu');


    if ($barcode == "" || $barcode == null) {
      $json['kode'] = 0;
      echo json_encode($json);
      return false;
    }

    $cekTamu = $this->db->get_where('tamu', ['nama' => $barcode, 'event_id' => $idEvent])->row_array();

    if ($cekTamu == true) {
      if ($cekTamu['jam_hadir'] == 0) {
        $nomorAmpao = $this->m_tamu->generateNomorAmpao($idEvent);
        $json['kode'] = 1;
        $json['pesan'] = 'Terimakasih, SELAMAT DATANG ' . $cekTamu['nama'];
        $json['idt'] = $cekTamu['id'];
        $json['nama'] = $cekTamu['nama'];
        $json['alamat'] = $cekTamu['alamat'];
        $json['nomor_meja'] = $cekTamu['nomor_meja'];
        $json['nomor_ampao'] = $nomorAmpao;
        $json['vip'] = $cekTamu['vip'];
        echo json_encode($json);
        return false;
      } else {
        $time = time();
        $timer = $time + (15);
        $this->db->set(['sapa' => 1, 'timer' => $timer])->where('id', $cekTamu['id'])->update('tamu');
        $json['kode'] = 2;
        $json['pesan'] = 'Maaf, Tamu Sudah Check-In Sebelumnya.!';
        echo json_encode($json);
        return false;
      }
    } else {
      $json['kode'] = 3;
      $json['pesan'] = 'Barcode tidak dikenal, SILAHKAN DIULANG.!';
      echo json_encode($json);
      return false;
    }
  }




  public function jumlahTamu()
  {
    $jml = trim($this->input->post('jumlah_tamu'));
    $id = trim($this->input->post('id_tamu'));
    $time = time();
    $timer = $time + (15);
    $idEvent = $this->session->userdata('sesiEventNewImam');
    $this->db->set('sapa', 0)->where(['event_id' => $idEvent])->update('tamu');
    $nomorAmpao = $this->m_tamu->generateNomorAmpao($idEvent);
    $this->db->set(['jam_hadir' => $time, 'sapa' => 1, 'timer' => $timer, 'nomor_ampao' => $nomorAmpao])->where('id', $id)->update('tamu');
    $query = $this->db->set('jml_tamu', $jml)->where('id', $id)->update('tamu');
    if ($query) {
      $json['kode'] = 1;
      $json['pesan'] = 'Data Saved';
      echo json_encode($json);
      return false;
    } else {
      $json['kode'] = 2;
      $json['pesan'] = 'SILAHKAN DIULANG.!';
      echo json_encode($json);
      return false;
    }
  }




  public function manual()
  {
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $nama = $this->input->post('nama');
    $nama = str_replace('&', 'dan', $nama);
    $nama = str_replace("'", '', $nama);
    $nama = str_replace('"', '', $nama);
    $alamat = $this->input->post('alamat');
    $vip = $this->input->post('vip');
    $group = $this->input->post('group');
    $nomor_meja = trim($this->input->post('nomor_meja'));
    //$jml = $this->input->post('jml');

    $cek = $this->m_tamu->byNama($nama, $event['id']);

    if ($cek) {
      $json = [
        'kode' => 2,
        'pesan' => 'Nama Tamu sudah ada! Tambahkan karakter lain, agar tidak terduplikat!'
      ];
      echo json_encode($json);
      return false;
    }

    $this->db->set('sapa', 0)->where(['event_id' => $event['id']])->update('tamu');

    $data = [
      'event_id' => $event['id'],
      'nama' => $nama,
      'alamat' => $alamat,
      'nomor_meja' => $nomor_meja,
      'vip' => $vip,
      'jam_hadir' => 0,
      'jml_tamu' => 0,
      'sapa' => 1,
      'qr' => 0,
      'group_id' => $group
    ];
    $query = $this->db->insert('tamu', $data);
    if ($query) {
      $json = [
        'kode' => 1,
        'pesan' => 'Data Tersimpan',
        'vip' => $vip,
        'idT' => $this->db->insert_id()
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


  public function loadDataTamu()
  {
    $this->load->model('m_report2');
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $page = $_POST['page'];
    $list = $this->m_report2->getTable($event['id']);
    if ($page <= 1) {
      # code...
      $number = $page;
    } else {
      $number = 10 * ($page - 1) + 1;
    }

    $data = '';
    $i = $number;
    foreach ($list as $key) {
      if ($key['vip'] == 1) {
        $vip = ' | <span class="badge badge-custom">VIP</span>';
      } else {
        $vip = '';
      }

      $waktu = date('d/m/Y H:i:s', $key['jam_hadir']);
      $jml = ' | <span class="text-bold">' . $key['jml_tamu'] . '</span> Orang';

      $data .= '<li>';
      $data .= '<input id="idtamu" value="' . $key['id'] . '" style="display:none">';
      $data .= '<span class="nomor">' . $i++ . '.</span>';
      $data .= '<span class="tgl">' . $waktu . '</span>';
      $data .= '<span class="title">' . $key['nama'] . '</span>';
      if($event['fitur_ampao'] == 1) {
        $data .= '<span class="sub-title">' . $key['alamat'] . $vip . $jml . ' |  <span class="text-bold">'.$key['nomor_ampao'].'</span></span>';
      } else {
        $data .= '<span class="sub-title">' . $key['alamat'] . $vip . $jml . '</span>';
      }
      $data .= '</li>';
    }

    $totalTamu = $this->m_report2->jmlUndangan($event['id']);

    if ($totalTamu <= 0) {
      $totalTamu = 0;
    }

    $jmlFilter = $this->m_report2->jmlTamuHadir($event['id']);


    if ($jmlFilter <= 0) {
      $jmlFilter = 0;
    }

    $udgHadir = $this->m_report2->jmlUndanganHadir($event['id']);
    if ($udgHadir <= 0) {
      $udgHadir = 0;
    }

    $output = [
      'totalRecord' => $this->m_report2->count_filter($event['id']),
      'listPage' => $data,
      'totalData' => $jmlFilter,
      'totalHadir' => $udgHadir,
      'totalUndangan' => $totalTamu,
    ];

    echo json_encode($output);
  }



  public function downloadApk()
  {
    $data = 'assets/img/page/bukutamu.apk';
    force_download($data, null);
  }


  
  public function scanQrcode($detail = 'hide', $id = null)
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $data['nomorAmpao'] = $this->m_tamu->generateNomorAmpao($event['id']);
    if($id != null) {
        $data['tamu'] = $this->m_tamu->byId($id);
    } else {
        $data['tamu']['id'] = '';
        $data['tamu']['nama'] = 'Nama Tamu';
        $data['tamu']['alamat'] = 'Alamat Tamu';
        $data['tamu']['nomor_meja'] = 'Nomor Meja';
        $data['tamu']['vip'] = '1';
    }
    $data['event'] = $event;
    $data['user'] = $user;
    $data['descr'] = base_url() . '- Buku Tamu';
    $data['icon'] = 'logo.png';
	$data['icon1'] = 'logo1.png';
    $data['title'] = base_url();
    $data['detail'] = $detail;
    //$this->load->view('template/header', $data);
    $this->load->view('home/checkin', $data);
  }
  
  public function scanQr()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $data['event'] = $event;
    $data['user'] = $user;
    $data['descr'] = base_url() . '- Buku Tamu';
    $data['icon'] = 'logo.png';
		$data['icon1'] = 'logo1.png';
    $data['title'] = base_url();
    $this->load->view('template/header', $data);
    $this->load->view('home/qrcode_html', $data);
  }


  public function cariNamaTamu()
  {

    
    $cari = trim($this->input->post('cari', true));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $cekTamu = $this->db->where('event_id', $event['id']);
    $cekTamu = $this->db->where('jam_hadir', 0);
    $cekTamu = $this->db->like('nama', $cari);
    $cekTamu = $this->db->get('tamu')->result_array();
    if ($cekTamu) {
      $data = '';
      foreach ($cekTamu as $key) {
        $data .= '<div data-id="'. $key['id'] .'" data-nama="'. $key['nama'] .'" class="list-menu-pencarian">';
        $data .= '<span class="nama-tamu"><strong>'. $key['nama'] .'</strong> | </span>'; 
        $data .= '<span class="alamat-tamu">'. $key['alamat'] .'</span>';
        $data .= '</div>';
      }

      $json = [
        'kode' => 1,
        'dataTamu' => $data
      ];
      echo json_encode($json);
      return false;
    } else {
      $json = [
        'kode' => 2,
        'dataTamu' => '<div class="ml-2 text-danger text-12">Nama Tamu tidak ditemukan / tamu tidak terdaftar!</div>'
      ];
      echo json_encode($json);
      return false;
    }
  }

  public function setHadirTamuCari()
  {
    $jml = trim($this->input->post('jml', true));
    $id = trim($this->input->post('id', true));

    $time = time();
    $timer = $time + (15);

    $idEvent = $this->session->userdata('sesiEventNewImam');
    $this->db->set('sapa', 0)->where(['event_id' => $idEvent])->update('tamu');

    $cekTamu = $this->db->get_where('tamu', ['id' => $id])->row_array();
    if ($cekTamu) {
      $this->db->set(['jam_hadir' => $time, 'sapa' => 1, 'jml_tamu' => $jml, 'timer' => $timer])->where('id', $id)->update('tamu');
      $json['kode'] = 1;
      $json['pesan'] = 'Halo, SELAMAT DATANG ' . $cekTamu['nama'];
      echo json_encode($json);
      return false;
    } else {
      $json['kode'] = 2;
      $json['pesan'] = 'SILAHKAN ULANG!';
      echo json_encode($json);
      return false;
    }

  }
  
  
  
  public function editPoto()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $id = $_POST['id'];

    $poto = $_FILES['poto'];
    $cek = $this->m_event->byId($id);

    if ($poto) {
      $config['allowed_types'] = 'jpg|png|jpeg';
      $config['max_size']     = '10000';
      $config['upload_path'] = './assets/img/event/';
      $config['encrypt_name'] = true;
      $this->load->library('upload', $config);
	  $this->load->library('image_lib');

      if ($this->upload->do_upload('poto')) {

        $image = $this->upload->data('file_name');
		list($width, $height) = getimagesize(FCPATH . 'assets/img/event/' . $image);
		$aspect_ratio = $width / $height;
		// Tentukan aspek rasio yang diizinkan dengan toleransi yang lebih besar
		$allowed_aspect_ratios = [3/2, 1.5, 16/9];

		$tolerance = 0.1; // Toleransi yang lebih besar (sesuaikan sesuai kebutuhan)

		$valid_aspect_ratio = false;
		foreach ($allowed_aspect_ratios as $allowed_ratio) {
			if (abs($aspect_ratio - $allowed_ratio) <= $tolerance) {
				$valid_aspect_ratio = true;
				break;
			}
		}
		if(!$valid_aspect_ratio) {
			$json = [
				'kode' => 2,
				'pesan' => 'Aspek ratio foto tidak valid. Silahkan upload foto dengan aspek ratio 3:2 atau 16:9! Aspek rasio foto yang anda upload '.$aspect_ratio
			];
			echo json_encode($json);
			return '';
		}
        if (file_exists('assets/img/event/' . $cek['poto'])) {
          if ($cek['poto'] !== 'baner.jpg') {
            unlink(FCPATH . 'assets/img/event/' . $cek['poto']);
          }
        }

        $data = [
          'poto' => $image,
        ];
        $query =  $this->db->set($data)->where('id', $id)->update('event');

        if ($query) {
          $json = [
            'kode' => 1,
            'pesan' => 'Foto display berhasil diupdate! rasio '.$aspect_ratio,
          ];
          echo json_encode($json);
          return false;
        }
      } else {
        $msg = $this->upload->display_errors();
        $json = [
          'kode' => 2,
          'pesan' => $msg
        ];
        echo json_encode($json);
        return false;
      }
    } else {
      $json = [
        'kode' => 2,
        'pesan' => 'Belum ada foto, Upload Ulang!'
      ];
      echo json_encode($json);
    }
  }
}