<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

class Souvenir extends CI_Controller
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
		$event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
		
		$data['event'] = $event;
		$data['user'] = $user;
		$data['descr'] = 'Souvenir - Bukutamu Digital';
		$data['icon'] = 'logo.png';
		$data['icon1'] = 'logo1.png';
		$data['group'] = $this->m_grup->byEvent($event['id']);
		$data['title'] = base_url();
		$this->load->view('template/header', $data);
		$this->load->view('home/souvenir', $data);
	}




	public function loadListKomen()
	{
		$event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
		$list = $this->getTable($event['id']);
		$ls = '';
		$i = 11;
		if ($list) {
			# code...
			$ls .='<div class="list-comment"><ul>';
			foreach ($list as $key) {
				$ls .= '<li>';
				$ls .= '<span><img src="' . base_url('assets/img/page/logo1.png') . '" alt=""></span>';
				$ls .= '<span class="tgl"><i class="far fa-check-circle text-success"></i> Souvenir Diterima</span>';
				$ls .= '<span class="title">' . $key['nama'] . '</span>';
				$ls .= '<span class="sub-title">' . $key['alamat'] . '</span>';
				$ls .= '</li>';
			}
			$ls .='</ul></div>';
		} else {
			$ls .= '<center><img src="../assets/img/design/Souvenirdata.png" style="width:300px;"/></center>';
		}




		$json = [
			'totalRecord' => $this->count_filter($event['id']),
			'total' => $this->count_all($event['id']),
			'list' => $ls,
		];

		echo json_encode($json);
	}


	public function getTable($event)
	{
		$this->db->from('tamu');

		$this->db->order_by('souvenir', 'desc');

		$page = $this->input->post('page');
		$page = ($page - 1);
		$perpage = 10;
		$resultFilter = ($perpage * $page);

		$this->db->limit($perpage, $resultFilter);
		$this->db->where('event_id', $event);
		$this->db->where('souvenir', '1');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function count_all($event)
	{
		$this->db->from('tamu');

		$this->db->where('event_id', $event);
		$this->db->where('souvenir', '1');

		return $this->db->count_all_results();
	}



	public function count_filter($event)
	{
		$this->db->from('tamu');

		$page = $this->input->post('page');
		$page = ($page - 1);
		$perpage = 10;
		$resultFilter = ($perpage * $page);

		$this->db->limit($perpage, $resultFilter);
		$this->db->where('event_id', $event);
		$this->db->where('souvenir', '1');
		$query = $this->db->get()->num_rows();
		return $query;
	}



	

	
  public function scanQrcode()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
    $data['event'] = $event;
    $data['user'] = $user;
    $data['descr'] = base_url() . '- Buku Tamu';
		$data['icon'] = 'logo.png';
		$data['icon1'] = 'logo1.png';
    $data['title'] = base_url();
    //$this->load->view('template/header', $data);
    $this->load->view('home/scan_souvenir', $data);
  }



	public function checkin()
	{
		$barcode = trim($this->input->post('barcode'));

    $idEvent = $this->session->userdata('sesiEventNewImam');
		$tamu = $this->db->get_where('tamu',['event_id' => $idEvent, 'nama' => $barcode])->row_array();
		if ($tamu) {
			if ($tamu['jam_hadir'] <= 0) {
				$json = [
					'kode' => 2,
					'pesan' =>  $tamu['nama'] . ', Kamu belum melakukan Check In !' ,
					'pesan1' => 'Kamu belum melakukan Check In !',
				];
				echo json_encode($json);
				return false;
			} else {
				if ($tamu['souvenir'] == 1) {
					$json = [
						'kode' => 2,
						'pesan' => $tamu['nama'] . ', souvenir sudah diambil sebelumnya!',
						'pesan1' => 'souvenir sudah diambil sebelumnya!',
					];
					echo json_encode($json);
					return false;
				} else {
					$query = $this->db->set('souvenir', 1)->where('id',$tamu['id'])->update('tamu');
					if ($query) {
						$json = [
							'kode' => 1,
							'pesan' => $tamu['nama'] . ', Silakan Ambil Souvenir!' ,
							'pesan1' => 'Silahkan Ambil Souvenir',
						];
						echo json_encode($json);
						return false;
					} else {
						$json = [
							'kode' => 2,
							'pesan' => 'Silahkan diUlang!'
						];
						echo json_encode($json);
						return false;
					}
				}
			}
		} else {
			$json = [
				'kode' => 3,
				'pesan' => 'QRCode / Tamu tidak terdaftar!'
			];
			echo json_encode($json);
			return false;
		}
	}







	public function pdf()
	{
		ob_start();
		$event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
		$tamu = $this->db->order_by('nama', 'asc')->where(['event_id' => $event['id'], 'souvenir' => 1])->get('tamu')->result_array();
		$total = $this->db->get_where('tamu', ['event_id' => $event['id'], 'souvenir' => 1])->num_rows();

		$data['title'] = 'Data Souvenir';
		$data['icon'] = 'logo.png';
		$data['tamu'] = $tamu;
		$data['total'] = $total;
		$data['event'] = $event;
		$this->load->view('home/pdf', $data);

		$html = ob_get_contents();
		ob_end_clean();

		$pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', array(10, 10, 10, 10));
		$pdf->WriteHTML($html);
		$pdf->Output($data['title'] . '.pdf');
	}

}