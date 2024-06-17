<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_user');
		$this->load->model('m_event');
	}

	public function index()
	{
		sedangLogin();
		cekTableDb();

		$data['descr'] = 'Bukutamu Digital QR Code Masa Kini!';
		$data['icon'] = 'logo.png';
		$data['icon1'] = 'logo3.png';
		$data['title'] = 'Fitur Bukutamu Digital - Digital Guestbook';
		$this->load->view('auth/login', $data);
	}


// 	public function log()
// 	{
// 		$username = trim($this->input->post('username'));
// 		$password = $this->input->post('password');

// 		$cekUser = $this->m_user->byUser($username);
// 		if ($cekUser) {
//     if (password_verify($password, $cekUser['password'])) {
//         if ($cekUser['active'] == '1') {
//             if ($cekUser['role'] == '1') {
//                 $event = $this->db->get('event')->row_array();
//                 if ($event) {
//                     // ADMIN
//                     $this->session->set_userdata('sesiEventNewImam', $event['id']);
//                     $this->session->set_userdata('loginAksesNewImam', $username);
//                     // Mengarahkan ke halaman home setelah login berhasil
//                     redirect(base_url('home'));
//                 } else {
//                     $this->m_event->creatXampleEvent();
//                     $this->session->set_userdata('sesiEventNewImam', 1);
//                     $this->session->set_userdata('loginAksesNewImam', $username);
//                     // Mengarahkan ke halaman home setelah login berhasil
//                     redirect(base_url('home'));
//                 }
//             } else {
//                 // USER
//                 $this->session->set_userdata('sesiEventNewImam', $cekUser['event_id']);
//                 $this->session->set_userdata('loginAksesNewImam', $username);
//                 // Mengarahkan ke halaman home setelah login berhasil
//                 redirect(base_url('home'));
//             }
//         } else {
//             $json = [
//                 'status' => 2,
//                 'pesan' => 'Akun kamu, belum active Silahkan hubungi Admin!'
//             ];
//             echo json_encode($json);
//             return false;
//         }
//     } else {
//         $json = [
//             'status' => 2,
//             'pesan' => 'Username/Password tidak dikenal'
//         ];
//         echo json_encode($json);
//         return false;
//     }
// } else {
//     $json = [
//         'status' => 2,
//         'pesan' => 'Username/Password tidak dikenal'
//     ];
//     echo json_encode($json);
//     return false;
// }

// 	}
	
	
	
	public function log()
	{
		$username = trim($this->input->post('username'));
		$password = $this->input->post('password');

		$cekUser = $this->m_user->byUser($username);
		if ($cekUser) {
			if (password_verify($password, $cekUser['password'])) {
				if ($cekUser['active'] == '1') {
					if ($cekUser['role'] == '1') {
						$event = $this->db->get('event')->row_array();
						if ($event) {
							// ADMIN
							$this->session->set_userdata('sesiEventNewImam', $event['id']);
							$this->session->set_userdata('loginAksesNewImam', $username);
							$json = [
								'status' => 1,
								'page' => base_url('home'),
								'pesan' => 'login success'
							];
							echo json_encode($json);
							return false;
						} else {
							$this->m_event->creatXampleEvent();
							$this->session->set_userdata('sesiEventNewImam', 1);
							$this->session->set_userdata('loginAksesNewImam', $username);
							$json = [
								'status' => 1,
								'page' => base_url('home'),
								'pesan' => 'login success'
							];
							echo json_encode($json);
							return false;
						}
					} else {
						// USER
						$this->session->set_userdata('sesiEventNewImam', $cekUser['event_id']);
						$this->session->set_userdata('loginAksesNewImam', $username);
						$json = [
							'status' => 1,
							'page' => base_url('home'),
							'pesan' => 'login success'
						];
						echo json_encode($json);
						return false;
					}
				} else {
					$json = [
						'status' => 2,
						'pesan' => 'Akun kamu, belum active Silahkan hubungi Admin!'
					];
					echo json_encode($json);
					return false;
				}
			} else {
				$json = [
					'status' => 2,
					'pesan' => 'Username/Password tidak dikenal'
				];
				echo json_encode($json);
				return false;
			}
		} else {
			$json = [
				'status' => 2,
				'pesan' => 'Username/Password tidak dikenal'
			];
			echo json_encode($json);
			return false;
		}
	}




	public function logout()
	{
		$this->session->unset_userdata('loginAksesNewImam');
		$this->session->unset_userdata('sesiEventNewImam');
		redirect();
	}
}