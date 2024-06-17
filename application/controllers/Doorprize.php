<?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Doorprize extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('m_user');
            $this->load->model('m_event');
            $this->load->model('m_tamu');
            $this->load->model('m_doorprize');
			$this->load->model('m_grup');
            setcoolor();
            sedangLogout();
        }
        
		public function index()
		{
			$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
			$event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
			$doorprize = $this->m_doorprize->byEvent($this->session->userdata('sesiEventNewImam'));
			if(!$doorprize) {
				$data['doorprize']['frame'] = 'default.png';
				$data['doorprize']['warna_text'] = '#FFFFFF';
				$data['doorprize']['text_judul'] = 'DOORPRIZE';
				$data['doorprize']['warna_dasar'] = '#FF0000';
				$data['doorprize']['event_id'] = $this->session->userdata('sesiEventNewImam');
				$data['doorprize']['user_id'] = $user['id'];
				$this->db->insert('doorprize_setting', $data['doorprize']);
				$data['doorprize']['id'] = $this->db->insert_id();
			} else {
				$data['doorprize']['id'] = $doorprize['id'];
				$data['doorprize']['frame'] = $doorprize['frame'];
				$data['doorprize']['warna_text'] = $doorprize['warna_text'];
				$data['doorprize']['text_judul'] = $doorprize['text_judul'];
				$data['doorprize']['warna_dasar'] = $doorprize['warna_dasar'];
			}
			$data['event'] = $event;
			$data['user'] = $user;
			$data['descr'] = 'Doorprize - Buku Tamu';
			$data['icon'] = 'logo.png';
			$data['icon1'] = 'logo1.png';
			$data['title'] = 'Doorprize - Buku Tamu';
			$this->load->view('template/header', $data);
			$this->load->view('doorprize/index', $data);
		}

		public function acak()
		{
			$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
			$event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
			$tamu = $this->m_tamu->byTamuCheckIn($this->session->userdata('sesiEventNewImam'));
			$data['event'] = $event;
			$data['user'] = $user;
			$data['tamus'] = $tamu;
			$data['descr'] = 'Bukutamu Digital Masa Kini!';
			$data['icon'] = 'logo.png';
			$data['icon1'] = 'logo1.png';
			$data['title'] = 'Fitur Bukutamu Digital';
			//$this->load->view('template/header', $data);
			$this->load->view('doorprize/acak', $data);
		}
		
		public function update_doorprize()
		{
			
		}
		
		public function load_hadiah()
		{
			$id = $_POST['id'];
			$list = $this->m_doorprize->load_hadiah($id);
			$ls = '';
			$ls .='<div class="list-comment"><ul>';
			foreach ($list as $key) {
					$ls .= '<li>';
					$ls .= '<span><img src="' . base_url('assets/img/doorprize/hadiah/hadiah.png') . '" alt=""></span>';
					$ls .= '<span class="title">' . $key['doorprize_name'] . '</span>';
					$ls .= '<span class="sub-title">Pemenang</span>';
					$ls .= '</li>';
			}
			$ls .='</ul></div>';
			$output = [
				'totalRecord' => count($list),
				'hadiah' => $ls
			];
			echo json_encode($output);
		}
    }
?>