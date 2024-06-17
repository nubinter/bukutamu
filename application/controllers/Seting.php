<?php
defined('BASEPATH') or exit('No direct script access allowed');error_reporting(0);

class Seting extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_user');
    $this->load->model('m_tamu');
    $this->load->model('m_time');
    $this->load->model('m_event');
	$this->load->model('m_campaign');
	$this->load->model('m_grup');
	$this->load->library('parser');
    sedangLogout();
    setcoolor();
  }

  public function index()
  {
    $kode = generate_random_string(8);
    $cekKode = $this->db->get_where('event', ['kode' => $kode])->row_array();
    if ($cekKode) {
      $this->cek();
    }
    setcoolor();
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $myuser = $this->m_user->byLeaderId($user['id']);
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $group = $this->m_grup->byEvent($event['id']);
    if($user['role'] == 1) {
        $campaigns = $this->m_campaign->byLeaderId($user['id']);
    }
	if($user['role'] == 3) {
	    $campaigns = $this->m_campaign->byUserId($user['id']);
	}
	$data = array(
		'user' => $user,
		'blasts' => $campaigns,
		'event' => $event,
		'myuser' => $myuser,
		'group' => $group
	);
    if ($user['role'] == '3') {
      $leader = $this->m_user->byId($user['leader_id']);
      $url = $this->db->get_where('undangan',['id' => $leader['undangan_id']])->row_array();
      $data['undangan'] = $leader['undangan_id'];
      $data['undangan_url'] = $url['url'];
    } else {
      $data['undangan'] = $user['undangan_id'];
      $url = $this->db->get_where('undangan',['id' => $user['undangan_id']])->row_array();
      $data['undangan_url'] = $url['url'];
    }
    $data['user'] = $user;
    $data['kodea'] = $kode;
    $data['descr'] = 'Setting - Bukutamu Digital';
    $data['icon'] = 'logo.png';
	$data['icon1'] = 'logo1.png';
    $data['title'] = 'Setting - Bukutamu Digital';
    $this->load->view('template/header', $data);
	$this->parser->parse('setting/index', $data);
  }

  public function index2()
  {
    $kode = generate_random_string(8);
    $cekKode = $this->db->get_where('event', ['kode' => $kode])->row_array();
    if ($cekKode) {
      $this->cek();
    }
    setcoolor();
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $myuser = $this->m_user->byLeaderId($user['id']);
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $group = $this->m_grup->byEvent($event['id']);
	$campaigns = $this->m_campaign->byUserId($user['id']);
	foreach ($campaigns as &$campaign) {
		if ($campaign['status'] == 'waiting') {
			$campaign['status_class'] = 'badge badge-warning';
			$campaign['control'] = '<button class="btn btn-sm btn-outline-primary play" data-id="'.$campaign['id'].'" data-status="starting" data-class="primary"><i class="fas fa-play"></i></button>';
			$campaign['control'] .= '<button class="btn btn-sm btn-outline-primary delete" data-id="'.$campaign['id'].'" ><i class="fas fa-trash"></i></button>';
		} elseif ($campaign['status'] == 'starting') {
			$campaign['status_class'] = 'badge badge-primary';
			$campaign['control'] = '<button class="btn btn-sm btn-outline-primary play" disabled><i class="fas fa-play"></i></button>';
			$campaign['control'] .= '<button class="btn btn-sm btn-outline-primary delete" disabled><i class="fas fa-trash"></i></button>';
		} elseif ($campaign['status'] == 'running') {
			$campaign['status_class'] = 'badge badge-secondary';
			$campaign['control'] = '<button class="btn btn-sm btn-outline-primary play" disabled><i class="fas fa-play"></i></button>';
			$campaign['control'] .= '<button class="btn btn-sm btn-outline-primary delete" disabled><i class="fas fa-trash"></i></button>';
		} elseif ($campaign['status'] == 'finished') {
			$campaign['status_class'] = 'badge badge-success';
			$campaign['control'] = '<button class="btn btn-sm btn-outline-primary play" data-id="'.$campaign['id'].'" data-status="starting" data-class="primary"><i class="fas fa-play"></i></button>';
			$campaign['control'] .= '<button class="btn btn-sm btn-outline-primary delete" data-id="'.$campaign['id'].'" ><i class="fas fa-trash"></i></button>';
		} else {
			$campaign['status_class'] = 'badge badge-danger';
		}
	}
	$data = array(
		'user' => $user,
		'campaigns' => $campaigns,
		'event' => $event,
		'myuser' => $myuser,
		'group' => $group
	);
    //$data['event'] = $event;
    if ($user['role'] == '3') {
      $leader = $this->m_user->byId($user['leader_id']);
      $url = $this->db->get_where('undangan',['id' => $leader['undangan_id']])->row_array();
      $data['undangan'] = $leader['undangan_id'];
      $data['undangan_url'] = $url['url'];
    } else {
      $data['undangan'] = $user['undangan_id'];
      $url = $this->db->get_where('undangan',['id' => $user['undangan_id']])->row_array();
      $data['undangan_url'] = $url['url'];
    }
    $data['user'] = $user;
    $data['kodea'] = $kode;
    $data['descr'] = 'Setting - Bukutamu Digital';
    $data['icon'] = 'logo.png';
		$data['icon1'] = 'logo1.png';
    $data['title'] = 'Setting - Bukutamu Digital';
    $this->load->view('template/header', $data);
	$this->parser->parse('setting/index2', $data);
  }
  
  public function cek()
  {
    redirect('seting');
  }


  // EVENT

  public function load_data()
  {
    $cari = $_POST['cari'];
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $event = $this->db->order_by('id', 'desc');
    if ($cari != '' || $cari != null) {
      $event = $this->db->like('nama', $cari);
    }
    if ($user['role'] == '1') {
      $event = $this->db->get('event')->result_array();
      $jmlev = $this->db->get('event')->num_rows();
    } else {
      $event = $this->db->get_where('event', ['id' => $this->session->userdata('sesiEventNewImam')])->result_array();
      $jmlev = $this->db->get_where('event', ['id' => $this->session->userdata('sesiEventNewImam')])->num_rows();
    }
    $data = '';
    foreach ($event as $key) {
      $jmlTamu = $this->db->get_where('tamu', ['event_id' => $key['id']])->num_rows();
      $cs = $this->db->get_where('user', ['event_id' => $key['id']])->row_array();

      if ($this->session->userdata('sesiEventNewImam') == $key['id']) {
        $status = '<span class="badge badge-custom ml-1"><i class="fas fa-check"></i></span>';
      } else {
        $status = '';
      }

      $data .= '<div id="list-event">';
      $data .= '<div class="figura">';
      $data .= '<img src="' . base_url('assets/img/event/') . $key['poto'] . '" alt="ev">';
      $data .= '<span data-id="' . $key['id'] . '" data-img="' . base_url('assets/img/event/') . $key['poto'] . '"><i class="fas fa-edit"></i></span></div>';
      $data .= '<div class="detail">';
      $data .= '<span class="title" style="font-size: ' . (18 - (str_word_count($key['nama']) - 1) * 1) . 'px !important; font-weight: 700;">' . $key['nama'] . $status . '</span>';
      $data .= '<span id="user">User: <span class="text-bold">' . $cs['nama'] . '</span></span>';
      $data .= '<span id="user">Tanggal:  ' . date('d/m/Y', strtotime($key['tgl'])) . '</span>';
      $data .= '<span id="user">Undangan: <b>' . $jmlTamu . '</b></span>';
      $data .= '<span id="user" class="link"><a href="' . $key['undangan'] . '" target="_blank" rel="noopener noreferrer">' . $key['undangan'] . '</a></span></div>';


      $data .= '<div class="boxBtn">';
      $data .= '<div class="dropdown">';
      $data .= '<a class="dropdown-toggle btnAction" type="button" id="dropdownMenuButton" data-toggle="dropdown"
            aria-expanded="false"><i class="far fa-cog" style="background-color: white;"></i></a>';
      $data .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">';
      if ($this->session->userdata('sesiEventNewImam') != $key['id']) {
        # code...
        // $data .= '<a class="dropdown-item btnDel" style="color: #FF0000;" href="' . base_url('seting/delete/' . $key['id']) . '"><i class="fa fa-trash mr-2" style="font-size: 12.5px; color: #FF0000;"></i> Hapus</a>';
      }
      $data .= '<a class="dropdown-item btnEdit" data-qr="' . $key['is_qr'] . '" data-wed="' . $key['wedding'] . '" data-nama="' . $key['nama'] . '" data-tgl="' . $key['tgl'] . '" data-link="' . $key['undangan'] . '" data-id="' . $key['id'] . '" data-undangan_id="' . $key['undangan_id'] . '" data-post="' . $key['id_post'] . '" data-meja="' . $key['fitur_meja'] . '" data-ampao="' . $key['fitur_ampao'] . '" data-qr="' . $key['is_qr'] . '" data-sesi="' . $key['fitur_sesi'] . '" href="#"><i class="fa fa-edit mr-2" style="font-size: 16px;"></i>Edit Event</a>';
      $data .= '<a class="dropdown-item" href="' . base_url('tamu/group/'.$key['id']) . '"><i class="fa fa-address-book mr-1" style="font-size: 16px;"></i> Grup Tamu</a>';
      $data .= '<a class="dropdown-item btnWa" data-id="' . $key['id'] . '" href="' . base_url('seting/cekWa') . '"><i class="fab fa-whatsapp mr-1" style="font-size: 18px;"></i> WhatsApp Template</a>';


      if ($this->session->userdata('sesiEventNewImam') == $key['id']) {
        # code...
        $data .= '<a class="dropdown-item btnSapa" data-id="' . $key['id'] . '" href="' . base_url('seting/welcome') . '"><i class="fas fa-tv mr-2" style="font-size: 12px;"></i>Pengaturan Layar Sapa</a>';

      }

      if ($this->session->userdata('sesiEventNewImam') != $key['id']) {
        $data .= '<a class="dropdown-item btnUser" data-id="' . $cs['id'] . '" data-nama="' . $cs['nama'] . '" data-email="' . $cs['email'] . '" data-uname="' . $cs['username'] . '" href="#"><i class="fas fa-user-edit mr-2"></i>Edit User</a>';
        
         $data .= '<a class="dropdown-item btnDel" style="color: #FF0000;" href="' . base_url('seting/delete/' . $key['id']) . '"><i class="fa fa-trash mr-2" style="font-size: 12.5px; color: #FF0000;"></i> Hapus</a>';
        # code...
        $data .= '<a class="dropdown-item" data-id="' . $key['id'] . '" href="' . base_url('seting/setActive/' . $key['id']) . '"><i class="far fa-eye mr-2"></i> Preview Event</a>';
      }
      
      $data .= '</div></div></div></div>';
    }

    $json = [
      'list' => $data,
      'jmlev' => $jmlev,
	  'user' => $user,
    ];
    echo json_encode($json);
  }




  public function loadEvent()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->db->get('event')->result_array();
    $dt = '<option value="">Pilih Event</option>';
    foreach ($event as $key) {
      $dt .= '<option value="' . $key['id'] . '">' . $key['nama'] . '</option>';
    }
    echo $dt;
  }


  public function loadDomain()
  {
    $domain = $this->db->get('undangan')->result_array();
    $dt = '<option value="">Pilih Domain Integrasi</option>';
    foreach ($domain as $key) {
      $dt .= '<option value="' . $key['id'] . '">' . $key['url'] . '</option>';
    }
    echo $dt;
  }


  public function add()
  {
    setcoolor();
    $wedding = trim($this->input->post('wedding', true));
    $nama = trim($this->input->post('nama', true));
    $tgl = trim($this->input->post('tgl', true));
    $link = trim($this->input->post('link'));
    $kode = trim($this->input->post('kode'));
    $undangan = trim($this->input->post('undangan'));
    $pos = trim($this->input->post('post'));

    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $quota = ($user['jml_event']);
    $jmlev = $this->db->get_where('event', ['leader_id' => $user['id']])->num_rows();

    if ($jmlev >= $quota) {
      $json = [
        'status' => 2,
        'pesan' => 'Kuota event kamu hanya ( ' . $quota . ' Event ), silahkan hubungi admin!',
      ];
      echo json_encode($json);
      return false;
    }

    if ($user['role'] == '2') {
      $leader = $user['id'];
    } else {
      $leader = 0;
    }
    $qr = '';
	if(null !== $this->input->post('is_qr')) {
	  $qr = 1;
	} else {
	  $qr = 0;
	}
	$fitur_meja = '';
	if(null !== $this->input->post('fitur_meja')) {
	  $fitur_meja = 1;
	} else {
	  $fitur_meja = 0;
	}
	$fitur_ampao = '';
	if(null !== $this->input->post('fitur_ampao')) {
	  $fitur_ampao = 1;
	} else {
	  $fitur_ampao = 0;
	}

    $data = [
      'nama' => $nama,
      'wedding' => $wedding,
      'tgl' => $tgl,
      'kode' => $kode,
      'undangan' => $link,
      'undangan_id' => $undangan,
      'poto' => 'baner.jpg',
      'leader_id' => $leader,
      'wa' => 'Kepada Yth. [NAMA-TAMU]

Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara pernikahan putra-putri kami :

* & *

Berikut link undangan kami untuk info lengkap dari acara bisa kunjungi : 

[LINK]

Merupakan Suatu Kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu di acara pernikahan putra-putri kami. 

Atas perhatiannya kami ucapkan terimakasih.
Spesial Invited by Ruang Invitation',
      'id_post' => $pos,
	  'is_qr' => $qr,
	  'fitur_meja' => $fitur_meja,
	  'fitur_ampao' => $fitur_ampao,
    ];

    $query = $this->db->insert('event', $data);
    if ($query) {

      if (!$this->session->userdata('sesiEventNewImam')) {
        $setEv = $this->db->get_where('event',['leader_id' => $user['id']])->row_array();
        $this->session->set_userdata('sesiEventNewImam', $setEv['id']);
      }

      $json = [
        'status' => 1,
        'pesan' => 'Event berhasil dibuat!'
      ];
      echo json_encode($json);
      return false;
    } else {
      $json = [
        'status' => 2,
        'pesan' => 'GAGAL membuat, Ulangi!'
      ];
      echo json_encode($json);
      return false;
    }
  }



  public function adduser()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $nama = trim($this->input->post('nama', true));
    $email = trim($this->input->post('email', true));
    $username = trim($this->input->post('username'));
    $password = trim($this->input->post('pass'));
    $password = passHash($password);
    $event = trim($this->input->post('event'));
    setcoolor();
    $cekUser = $this->m_user->byUser($username);
    $cekMail = $this->m_user->byEmail($email);
    if ($cekUser) {
      $json = [
        'status' => 2,
        'pesan' => 'Gunakan Username Lain!'
      ];
      echo json_encode($json);
      return false;
    }
    if ($cekMail) {
      $json = [
        'status' => 2,
        'pesan' => 'Gunakan Email Lain!'
      ];
      echo json_encode($json);
      return false;
    }

    $cekEvent = $this->db->get_where('user', ['event_id' => $event])->row_array();
    if ($cekEvent) {
      $json = [
        'status' => 2,
        'pesan' => 'Event yang dipilih, sudah digunakan ke user Lain!'
      ];
      echo json_encode($json);
      return false;
    }


    $data = [
      'nama' => $nama,
      'username' => $username,
      'password' => $password,
      'email' => $email,
      'role' => 3,
      'active' => 1,
      'event_id' => $event,
      'tgl' => date('Y-m-d'),
      'leader_id' => $user['id'],
      'jml_event' => 1,
      'undangan_id' => $user['undangan_id']
    ];

    $query = $this->db->insert('user', $data);
    if ($query) {

      $json = [
        'status' => 1,
        'pesan' => 'Akun user berhasil dibuat!'
      ];
      echo json_encode($json);
      return false;
    } else {
      $json = [
        'status' => 2,
        'pesan' => 'GAGAL, Ulangi'
      ];
      echo json_encode($json);
      return false;
    }
  }



  public function edituser()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
  
    $id = trim($this->input->post('id', true));
    $nama = trim($this->input->post('nama', true));
    $email = trim($this->input->post('email', true));
    $username = trim($this->input->post('username'));
    $password = trim($this->input->post('pass'));
    if ($password != "" || $password != null) {
      # code...
      $password = passHash($password);
      $this->db->set('password', $password);
    }

    $cekUser = $this->m_user->byUser($username);
    $cekMail = $this->m_user->byEmail($email);
    if ($cekUser) {
      if ($cekUser['id'] != $id) {
        # code...
        $json = [
          'status' => 2,
          'pesan' => 'Gunakan Username Lain!'
        ];
        echo json_encode($json);
        return false;
      }
    }
    if ($cekMail) {
      if ($cekMail['id'] != $id) {
        $json = [
          'status' => 2,
          'pesan' => 'Gunakan Email Lain!'
        ];
        echo json_encode($json);
        return false;
      }
    }


    $data = [
      'nama' => $nama,
      'username' => $username,
      'email' => $email,
    ];

    $query = $this->db->set($data)->where('id', $id)->update('user');
    if ($query) {
      if ($user['id'] == $id) {
        $this->session->set_userdata('loginAksesNewImam', $username);
      }
      $json = [
        'status' => 1,
        'pesan' => 'Data user berhasil diupdate!'
      ];
      echo json_encode($json);
      return false;
    } else {
      $json = [
        'status' => 2,
        'pesan' => 'GAGAL mengupdate, Ulangi!'
      ];
      echo json_encode($json);
      return false;
    }
  }


  public function editAkun()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $id = $user['id'];
    
    $nama = trim($this->input->post('nama', true));
    $email = trim($this->input->post('email', true));
    $username = trim($this->input->post('username'));	
    $nomorwa = trim($this->input->post('nomor_wa'));
    $password = trim($this->input->post('pass'));
    if ($password != "" || $password != null) {
      # code...
      $password = passHash($password);
      $this->db->set('password', $password);
    }

    $cekUser = $this->m_user->byUser($username);
    $cekMail = $this->m_user->byEmail($email);
    if ($cekUser) {
      if ($cekUser['id'] != $id) {
        # code...
        $json = [
          'status' => 2,
          'pesan' => 'Gunakan Username Lain!'
        ];
        echo json_encode($json);
        return false;
      }
    }
    if ($cekMail) {
      if ($cekMail['id'] != $id) {
        $json = [
          'status' => 2,
          'pesan' => 'Gunakan Email Lain!'
        ];
        echo json_encode($json);
        return false;
      }
    }


    $data = [
      'nama' => $nama,
      'username' => $username,
      'email' => $email,	  	  'nomor_wa' => $nomorwa,
    ];

    $query = $this->db->set($data)->where('id', $id)->update('user');
    if ($query) {
      if ($user['id'] == $id) {
        $this->session->set_userdata('loginAksesNewImam', $username);
      }
      $json = [
        'status' => 1,
        'pesan' => 'Akunmu berhasil diupdate!'
      ];
      echo json_encode($json);
      return false;
    } else {
      $json = [
        'status' => 2,
        'pesan' => 'GAGAL Mengupdate, Ulangi!'
      ];
      echo json_encode($json);
      return false;
    }
  }





  public function delete($id)
  {
    $event = $this->db->get_where('event', ['id' => $id])->row_array();
    if ($event['poto'] !== 'baner.jpg') {
      if (file_exists('assets/img/event/' . $event['poto'])) {
        unlink(FCPATH . 'assets/img/event/' . $event['poto']);
      }
    }
    $user = $this->db->get_where('user', ['event_id' => $id, 'role' => '3'])->row_array();
    if ($user) {
      $this->db->where('id', $user['id'])->delete('user');
    }
    $tamu = $this->db->get_where('tamu', ['event_id' => $id])->result_array();
    if ($tamu) {
      foreach ($tamu as $key) {
        if (file_exists('assets/img/qr/' . $key['id'] . '.png')) {
          unlink(FCPATH . 'assets/img/qr/' . $key['id'] . '.png');
        }
        if (file_exists('assets/img/qr/' . $key['nama'] . '.png')) {
          unlink(FCPATH . 'assets/img/qr/' . $key['nama'] . '.png');
        }
        $this->db->where('id', $key['id'])->delete('tamu');
      }
    }
    $screen = $this->db->get_where('welcome', ['event_id' => $id])->row_array();
    if ($screen) {
      if ($screen['bg'] !== 'bg.jpg') {
        if (file_exists('assets/img/event/' . $screen['bg'])) {
          unlink(FCPATH . 'assets/img/event/' . $screen['bg']);
        }
      }
      $this->db->where('id', $screen['id'])->delete('welcome');
    }

    $query = $this->db->where('id', $id)->delete('event');
    if ($query) {
      $json = [
        'status' => 1,
        'pesan' => 'Event berhasil dihapus!'
      ];
      echo json_encode($json);
      return false;
    } else {
      $json = [
        'status' => 2,
        'pesan' => 'Silahkan Diulang'
      ];
      echo json_encode($json);
      return false;
    }
  }


  public function edit()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $wedding = trim($this->input->post('wedding', true));
    $nama = trim($this->input->post('nama', true));
    $tgl = trim($this->input->post('tgl', true));
    $link = trim($this->input->post('link'));
    $pos = trim($this->input->post('post'));
    $undangan = trim($this->input->post('undangan'));
    $idEv = trim($this->input->post('id'));
    if ($user['role'] == '3') {
      # code...
      $id = $user['event_id'];
      $data = [
        'wedding' => $wedding,
        'nama' => $nama,
        'tgl' => $tgl
      ];
    } else {
      $cekEvent = $this->m_event->byId($idEv);
      $qr = '';
      if(null !== $this->input->post('is_qr')) {
        $qr = 1;
      } else {
        $qr = 0;
      }
      $fitur_meja = '';
      if(null !== $this->input->post('fitur_meja')) {
        $fitur_meja = 1;
      } else {
        $fitur_meja = 0;
      }
      $fitur_ampao = '';
      if(null !== $this->input->post('fitur_ampao')) {
        $fitur_ampao = 1;
      } else {
        $fitur_ampao = 0;
      }
      $id = $idEv;
      $data = [
        'wedding' => $wedding,
        'nama' => $nama,
        'tgl' => $tgl,
        'undangan' => $link,
        'undangan_id' => $undangan,
        'id_post' => $pos,
        'is_qr' => $qr,
        'fitur_meja' => $fitur_meja,
        'fitur_ampao' => $fitur_ampao,
      ];
    }

    $query = $this->db->set($data)->where('id', $id)->update('event');
    if ($query) {
      $json = [
        'status' => 1,
        'pesan' => 'Data event berhasil diupdate!'
      ];
      echo json_encode($json);
      return false;
    } else {
      $json = [
        'status' => 2,
        'pesan' => 'GAGAL, Silahkan Ulangi'
      ];
      echo json_encode($json);
      return false;
    }
  }

  public function editWa()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $pesan = trim($this->input->post('pesan', true));
   
    $id = trim($this->input->post('id'));

    $data = [
      'wa' => $pesan
    ];

    $query = $this->db->set($data)->where('id', $id)->update('event');
    if ($query) {

      $json = [
        'status' => 1,
        'pesan' => 'Kata Pengantar Berhasil Diupdate!'
      ];
      echo json_encode($json);
      return false;
    } else {
      $json = [
        'status' => 2,
        'pesan' => 'GAGAL, Silahkan Ulangi'
      ];
      echo json_encode($json);
      return false;
    }
  }

  public function cekWa()
  {
    $id = $this->input->post('id');
    $event = $this->m_event->byId($id);
    $json = [
      'kode' => 1,
      'pesan' => $event['wa'],
    ];
    echo json_encode($json);
    return false;
  }

  public function setActive($id)
  {
    $this->session->unset_userdata('sesiEventNewImam');
    $this->session->set_userdata('sesiEventNewImam', $id);
    redirect();
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






  // WELCOME
  public function welcome()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));

    $kode = $event['id'] . time();
    $cekKode = $this->db->get_where('welcome', ['kode' => $kode])->row_array();
    if ($cekKode) {
      $this->cek();
    }
    $wel = $this->db->get_where('welcome', ['event_id' => $event['id']])->row_array();
    if (!$wel) {
      $isi = [
        'event_id' => $event['id'],
        'kode' => $kode,
        'bg' => 'bg.jpg',
        'color' => '#ffff',
      ];
      $this->db->insert('welcome', $isi);
    }
    $wel = $this->db->get_where('welcome', ['event_id' => $event['id']])->row_array();
    $data['wel'] = $wel;
    $data['event'] = $event;
    $data['user'] = $user;
    $data['descr'] = base_url() . '- Buku Tamu';
    $data['icon'] = 'logo.png';
		$data['icon1'] = 'logo1.png';
    $data['title'] = base_url();
    $this->load->view('template/header', $data);
    $this->load->view('setting/welcome', $data);
  }



  public function updateWelcome()
  {
    $isi = trim($this->input->post('isi', true));
    $key = trim($this->input->post('key', true));
    $id = trim($this->input->post('id', true));
    $this->db->set($key, $isi)->where('id', $id)->update('welcome');
  }



  public function editBg()
  {
    $id = $_POST['id'];

    $poto = $_FILES['poto'];
    $cek = $this->db->get_where('welcome', ['id' => $id])->row_array();

    if ($poto) {
      $config['allowed_types'] = 'jpg|png|jpeg';
      $config['max_size']     = '9000';
      $config['upload_path'] = './assets/img/event/';
      $config['encrypt_name'] = true;
      $this->load->library('upload', $config);

      if ($this->upload->do_upload('poto')) {

        if (file_exists('assets/img/event/' . $cek['bg'])) {
          if ($cek['bg'] !== 'bg.jpg') {
            unlink(FCPATH . 'assets/img/event/' . $cek['bg']);
          }
        }

        $image = $this->upload->data('file_name');

        $data = [
          'bg' => $image,
        ];
        $query =  $this->db->set($data)->where('id', $id)->update('welcome');

        if ($query) {
          $json = [
            'kode' => 1,
            'pesan' => 'Foto display berhasil diupdate!'
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