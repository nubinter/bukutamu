<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_user');
		$this->load->model('m_event');
		$this->load->model('m_grup');
		sedangLogout();
		setcoolor();
	}

	public function index()
	{
		$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
		if ($user['role'] != 1) {
			redirect('home');
		}
		$data['user'] = $user;
		$data['descr'] = 'User - Bukutamu Digital';
		$data['icon'] = 'logo.png';
		$data['icon1'] = 'logo1.png';
		$data['title'] = base_url();
		$this->load->view('template/header', $data);
		$this->load->view('setting/user', $data);
	}




	public function loadDomain()
  {
    $domain = $this->db->get('undangan')->result_array();
    $dt = '<option value="">Domain Integrasi Comment</option>';
    foreach ($domain as $key) {
      $dt .= '<option value="' . $key['id'] . '">' . $key['url'] . '</option>';
    }
    echo $dt;
  }

	
	public function loadDataUser()
	{
		$cari = $_POST['cari'];
    $list = $this->db->order_by('id', 'desc');
    $list = $this->db->where(['role' => 3]);
    if ($cari != '' || $cari != null) {
			$list = $this->db->like('nama', $cari);
    }
		$list = $this->db->get('user')->result_array();
    $data = '';
    $i = 1;
    foreach ($list as $key) {
        $event = $this->m_event->byId($key['event_id']);
		$undangan = $this->db->get_where('undangan',['id' => $event['undangan_id']])->row_array();
		//$undangan = $this->db->get_where('undangan',['id' => $key['undangan_id']])->row_array();
      
      $data .= '<li>';
      $data .= '<input id="idAdmin" value="' . $key['id'] . '" style="display:none">';
      $data .= '<span class="nomor">' . $i++ . '.</span>';
      $data .= '<span class="option"><div class="dropdown">';
      $data .= '<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"><i class="far fa-cogs"></i></a>';
      $data .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">';
    //   $data .= '<a class="dropdown-item btnEdit" data-id="' . $key['id'] . '" data-nama="' . $key['nama'] . '" data-email="' . $key['email'] . '" data-username="' . $key['username'] . '" data-undangan="' . $key['undangan_id'] . '" data-jml="' . $key['jml_event'] . '" href="#"><i class="far fa-edit"></i> Edit</a>';
      $data .= '<a class="dropdown-item btnKuotaWa" data-id="' . $key['id'] . '" data-nama="' . $key['nama'] . '" data-kuota="'.$key['kuota_wa'].'" href="#"><i class="fab fa-whatsapp mr-2"></i>Kuota WhatsApp</a>';
      $data .= '<a class="dropdown-item btnDelete" data-id="' . $key['id'] . '" data-nama="' . $key['nama'] . '" href="#"><i class="fa fa-trash mr-2"></i>Delete</a>';
      $data .= '</div></div></span>';
      $data .= '<span class="title" data-id="' . $key['id'] . '">' . $key['nama'] . '</span>';
      $data .= '<span class="sub-title" data-id="' . $key['id'] . '">' . '' . ' Jumlah Kuota WhatsApp: <strong>' . $key['kuota_wa'] . '</strong> <br>Main Domain: <span class="badge badge-custom">' . $undangan['url'] . '</span></span>';
      $data .= '</li>';
    }

		if ($data) {
			# code...
			$output = [
				'listPage' => $data,
			];
		} else {
			$output = [
				'listPage' => '<li><span class="sub-title-user">Not Data</span></li>',
			];
		}
		echo json_encode($output);
	}



	public function add()
	{
		$nama = trim($this->input->post('nama', true));
		$email = trim($this->input->post('email', true));
		$username = trim($this->input->post('username', true));
		$pass = trim($this->input->post('pass', true));
		$password = passHash($pass);
		$jml = trim($this->input->post('jml', true));
		$undangan = trim($this->input->post('undangan', true));

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

		$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
		
    $data = [
      'nama' => $nama,
      'username' => $username,
      'password' => $password,
      'email' => $email,
      'role' => 2,
      'active' => 1,
      'event_id' => 0,
      'tgl' => date('Y-m-d'),
      'leader_id' => $user['id'],
			'jml_event' => $jml,
			'undangan_id' => $undangan
    ];

		$query = $this->db->insert('user', $data);
    if ($query) {

      $json = [
        'status' => 1,
        'pesan' => 'Admin baru berhasil dibuat!'
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

	public function edit()
	{
		$id = trim($this->input->post('id', true));
		$nama = trim($this->input->post('nama', true));
		$email = trim($this->input->post('email', true));
		$username = trim($this->input->post('username', true));
		$jml = trim($this->input->post('jml', true));
		$undangan = trim($this->input->post('undangan', true));

		$pass = trim($this->input->post('pass', true));
		$password = passHash($pass);

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

		$cekClient = $this->db->get_where('user',['role' => 3, 'leader_id' => $id])->result_array();
		if ($cekClient) {
			foreach ($cekClient as $key) {
				$this->db->set('undangan_id', $undangan)->where('id', $key['id'])->update('user');
			}
		}


		$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));

		if ($pass != "" || $pass != null) {
			$this->db->set('password', $password);
		}
		
    $data = [
      'nama' => $nama,
      'username' => $username,
      'email' => $email,
      'role' => 2,
      'active' => 1,
      'event_id' => 0,
      'tgl' => date('Y-m-d'),
      'leader_id' => $user['id'],
			'jml_event' => $jml,
			'undangan_id' => $undangan
    ];

		$query = $this->db->set($data)->where('id', $id)->update('user');
    if ($query) {

      $json = [
        'status' => 1,
        'pesan' => 'Akun admin berhasil diupdate!'
      ];
      echo json_encode($json);
      return false;
    } else {
      $json = [
        'status' => 2,
        'pesan' => 'GAGAL update, Ulangi!'
      ];
      echo json_encode($json);
      return false;
    }
	}


	public function adddomain()
	{
		$url = trim($this->input->post('url', true));
		$token = trim($this->input->post('token', true));
		$cekUrl = $this->db->get_where('undangan',['url' => $url])->row_array();
		if ($cekUrl) {
			$json = [
        'status' => 2,
        'pesan' => 'Domain sudah disimpan sebelumnya, Ulangi!'
      ];
      echo json_encode($json);
      return false;
		}

		$data = [
			'url' => $url,
			'token' => $token
		];
		$query = $this->db->insert('undangan', $data);
    if ($query) {

      $json = [
        'status' => 1,
        'pesan' => 'Domain baru berhasil ditambah!'
      ];
      echo json_encode($json);
      return false;
    } else {
      $json = [
        'status' => 2,
        'pesan' => 'GAGAL, Ulangi!'
      ];
      echo json_encode($json);
      return false;
    }

	}


	public function delete()
	{
		$id = $_POST['id'];
		$user = $this->m_user->byId($id);
		$event = $this->db->get_where('event', ['leader_id' => $user['id']])->result_array();
		if ($event) {
			foreach ($event as $ev) {
				if ($ev['poto'] !== 'baner.jpg') {
					if (file_exists('assets/img/event/' . $ev['poto'])) {
						unlink(FCPATH . 'assets/img/event/' . $ev['poto']);
					}
				}

				$tamu = $this->db->get_where('tamu', ['event_id' => $ev['id']])->result_array();
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

				$screen = $this->db->get_where('welcome', ['event_id' => $ev['id']])->result_array();
				if ($screen) {
					foreach ($screen as $scr) {
						# code...
						if ($scr['bg'] !== 'bg.jpg') {
							if (file_exists('assets/img/event/' . $scr['bg'])) {
								unlink(FCPATH . 'assets/img/event/' . $scr['bg']);
							}
						}
						$this->db->where('id', $scr['id'])->delete('welcome');
					}
				}

			}
		}

		$client = $this->db->get_where('user', ['leader_id' => $user['id']])->result_array();
		if ($client) {
			foreach ($client as $cl) {
				$this->db->where('id', $cl['id'])->delete('user');
			}
		}

		$query = $this->db->where('id', $id)->delete('user');
    if ($query) {
      $json = [
        'status' => 1,
        'pesan' => 'Akun admin berhasil dihapus!'
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




	public function detailAdmin()
	{
		$id = $_POST['id'];
		$user = $this->m_user->byId($id);
		$undangan = $this->db->get_where('undangan',['id' => $user['undangan_id']])->row_array();

		$data = '';
		$data .= '<tr><td>Nama </td><td>: </td><td>'. $user['nama'] .'</td></tr>';
		$data .= '<tr><td>Email </td><td>: </td><td>'. $user['email'] .'</td></tr>';
		$data .= '<tr><td>Username </td><td>: </td><td>'. $user['username'] .'</td></tr>';
		$data .= '<tr><td>Quota </td><td>: </td><td>'. $user['jml_event'] .'</td></tr>';
		$data .= '<tr><td>Quota Whatsapp</td><td>: </td><td>'. $user['kuota_wa'] .'</td></tr>';
		$data .= '<tr><td>Domain Integrasi </td><td>: </td><td class="text-info">'. $undangan['url'] .'</td></tr>';
		$data .= '<tr><td>Token</td><td>: </td><td>'. $undangan['token'] .'</td></tr>';

		echo $data;
	}


	public function loadListDomain()
	{
		$domain = $this->db->get('undangan')->result_array();
		$data = '';
		foreach ($domain as $key) {
			$data .= '<li>';
			$data .= '<div class="text-bolder text-12">'. $key['url'] .'</div>';
			$data .= '<span class="text-12">'. $key['token'] .'</span>';
			$data .= '<a href="#" data-id="'. $key['id'] .'" class="text-danger ml-2 btnDeleteDom"><i class="far fa-trash-alt"></i></a>';
			$data .= '</li>';
			$data .= '<hr style="margin:0 0 3px 0;padding:0">';
		}

		echo $data;
	}

	public function deleteDomain($id)
	{
		$this->db->where('id',$id)->delete('undangan');
	}



	// GROUP TAMU
	
	public function group()
	{
		$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
		if ($user['role'] != 1) {
			redirect('home');
		}
		$data['user'] = $user;
		$data['descr'] = base_url() . '- Buku Tamu';
		$data['icon'] = 'logo.png';
		$data['icon1'] = 'logo1.png';
		$data['title'] = base_url();
		$this->load->view('template/header', $data);
		$this->load->view('setting/group', $data);
	}



	public function addGroup()
	{
		$nama = trim($this->input->post('nama', true));
		$cekGr = $this->db->get_where('group_tamu',['nama' => $nama])->row_array();
		if ($cekGr) {
			$json = [
        'status' => 2,
        'pesan' => 'Nama Group sudah ada sebelumnya, Ulangi!'
      ];
      echo json_encode($json);
      return false;
		}

		$data = [
			'nama' => $nama
		];
		$query = $this->db->insert('group_tamu', $data);
    if ($query) {

      $json = [
        'status' => 1,
        'pesan' => 'Group berhasil ditambah!'
      ];
      echo json_encode($json);
      return false;
    } else {
      $json = [
        'status' => 2,
        'pesan' => 'GAGAL, Ulangi!'
      ];
      echo json_encode($json);
      return false;
    }
	}


	public function loadListGroup()
	{
		$cari = $_POST['cari'];
		$list = $this->db->get('group_tamu')->result_array();
    $data = '';
    $i = 1;
    foreach ($list as $key) {
      
      $data .= '<li>';
      $data .= '<input id="idAdmin" value="' . $key['id'] . '" style="display:none">';
      $data .= '<span class="nomor">' . $i++ . '.</span>';
      $data .= '<span class="option"><div class="dropdown">';
      $data .= '<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"><i class="far fa-cogs"></i></a>';
      $data .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">';
      $data .= '<a class="dropdown-item btnEdit" data-id="' . $key['id'] . '" data-nama="' . $key['nama'] . '" href="#">Edit</a>';
      $data .= '<a class="dropdown-item btnDelete" data-id="' . $key['id'] . '" data-nama="' . $key['nama'] . '" href="#">Delete</a>';
      $data .= '</div></div></span>';
      $data .= '<span class="title" data-id="' . $key['id'] . '">' . $key['nama'] . '</span>';
      $data .= '<span class="sub-title" data-id="' . $key['id'] . '">ID GROUP : <span class="text-bolder">' . $key['id'] . '</span></span>';
      $data .= '</li>';
    }

		if ($data) {
			# code...
			$output = [
				'listPage' => $data,
			];
		} else {
			$output = [
				'listPage' => '<li><span class="sub-title">Not Data</span></li>',
			];
		}
    echo json_encode($output);
	}



	public function editGroup()
	{
		$id = trim($this->input->post('id', true));
		$nama = trim($this->input->post('nama', true));
		$cekGr = $this->db->get_where('group_tamu',['nama' => $nama])->row_array();
		if ($cekGr) {
			if ($cekGr['id'] != $id) {
				# code...
				$json = [
					'status' => 2,
					'pesan' => 'Nama Group sudah ada sebelumnya, Ulangi!'
				];
				echo json_encode($json);
				return false;
			}
		}

		$data = [
			'nama' => $nama
		];
		$query = $this->db->set($data)->where('id', $id)->update('group_tamu');
    if ($query) {

      $json = [
        'status' => 1,
        'pesan' => 'List group berhasil diedit!'
      ];
      echo json_encode($json);
      return false;
    } else {
      $json = [
        'status' => 2,
        'pesan' => 'GAGAL, Ulangi!'
      ];
      echo json_encode($json);
      return false;
    }
	}



	public function deleteGroup()
	{
		$id = trim($this->input->post('id', true));
		$this->db->where('id', $id)->delete('group_tamu');
	}
}