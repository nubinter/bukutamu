<?php
ignore_user_abort(true);
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use Dompdf\Dompdf;
use Dompdf\Options;

class Whatsapp extends CI_Controller

{

	public function __construct()

	{

		parent::__construct();

		$this->load->model('m_user');
		$this->load->model('m_tamu');
		$this->load->model('m_grup');
		$this->load->model('m_event');
		$this->load->model('m_campaign');
		$this->load->model('m_whatsapp');
		$this->load->library('parser');
		// setcoolor();
	}

	public function index()
	{
		sedangLogout();
		$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
		if ($user['role'] == 1) {
			$campaigns = $this->m_campaign->getAll();
		}
		if ($user['role'] == 2) {
			$campaigns = $this->m_campaign->byLeaderId($user['id']);
		}
		if ($user['role'] == 3) {
			$campaigns = $this->m_campaign->byUserId($user['id']);
		}
		$devices = $this->m_whatsapp->byUserId($user['id']);
		$data = array(
			'user' => $user,
			'devices' => $devices,
			'campaigns' => $campaigns,
			'title' => 'WhatsApp Blast',
			'descr' => 'Halaman manajemen whatsapp'
		);
		$this->load->view('template/header', $data);
		$this->parser->parse('whatsapp/index', $data);
	}

	public function history($blast)
	{
		sedangLogout();
		$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
		$data['campaign'] = $this->m_campaign->byId($blast);
		$data['descr'] = base_url() . '- Buku Tamu';
		$data['icon'] = 'brand.png';
		$data['title'] = 'History - Bukutamu Digital';
		$data['senders'] = $this->m_whatsapp->byUserId($user['id']);
		$data['blast_id'] = $blast;
		$data['user'] = $user;
		$this->load->view('template/header', $data);
		$this->load->view('whatsapp/history', $data);
	}

	public function load_history($blast_id)
	{
		$list = $this->m_whatsapp->getTable($blast_id);
		$page = $_POST['page'];
		if ($page <= 1) {
			$number = $page;
		} else {
			$number = 18 * ($page - 1) + 1;
		}

		$data = '';
		$i = $number;
		foreach ($list as $key) {
			if ($key['status'] == 1) {
				$status = '| <span class="badge badge-success">Terkirim</span>';
			} else {
				$status = '| <span class="badge badge-danger">Gagal Kirim</span>';
			}
			$data .= '<li>';
			$data .= '<input id="idreceiver" value="' . $key['tamu_id'] . '" style="display:none">';
			$data .= '<span class="nomor">' . $i++ . '.</span>';
			$data .= '<span class="option"><div class="dropdown">';
			$data .= '<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"><i class="far fa-cogs"></i></a>';
			$data .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">';
			$data .= '<a class="dropdown-item btnWa" data-id="' . $key['tamu_id'] . '" href="#">Share Undangan (Manual)</a>';
			$data .= '<a class="dropdown-item btnWaAuto" data-id="' . $key['tamu_id'] . '" id="btnWaAuto" href="#">Share Undangan (Auto)</a>';
			$data .= '</div></div></span>';
			$data .= '<span class="title">' . $key['nama_tamu'] . '</span>';
			$data .= '<span class="sub-title">' . $key['nomor_wa'] . $status  . '  | ' . $key['response'] . '</span>';
			$data .= '</li>';
		}

		$output = [
			'totalRecord' => $this->m_whatsapp->count_filter($blast_id),
			'listPage' => $data,
			'totalData' => $this->m_whatsapp->count_all($blast_id)
		];

		echo json_encode($output);
	}

	public function load_device()
	{
		$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
		$list = $this->m_whatsapp->byUserId($user['id']);
		$i = 1;
		if (empty($list)) {
			$data = '<center><img src="../assets/img/design/devicewhatsappfix.png" style="width:300px;"/></center>';
		} else {

			$data = '';
			foreach ($list as $key) {
				$status = get_status($key['nomor_wa']);
				if ($status['success'] == false or $status['data']['status'] == 'connected') {
					$status_device = '<span class="badge badge-danger">Belum Terhubung</span>';
					$status_update = 'disconnected';
				} else {
					$status_device = '<span class="badge badge-success">Terhubung</span>';
					$status_update = $status['data']['status'];
				}
				$data_update = [
					'status' => $status_update,
				];
				$query = $this->db->set($data_update)->where('id', $key['id'])->update('wa_devices');
				$data .= '<li>';
				$data .= '<input id="iddevice" value="' . $key['id'] . '" style="display:none">';
				$data .= '<span class="nomor">' . $i++ . '.</span>';
				$data .= '<span class="option"><div class="dropdown">';
				$data .= '<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"><i class="far fa-cogs"></i></a>';
				$data .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">';
				$data .= '<a class="dropdown-item btnQr" data-nomor_wa="' . $key['nomor_wa'] . '" href="#"><i class="fas fa-qrcode mr-2" style="font-size: 16px;"></i>Connect with QR</a>';
				$data .= '<a class="dropdown-item btnDelete" data-id="' . $key['id'] . '" href="#"><i class="fa fa-trash mr-2" style="font-size: 16px;"></i>Disconnect and Delete</a>';
				$data .= '</div></div></span>';
				$data .= '<span class="title">' . $key['nomor_wa'] . '</span>';
				$data .= '<span class="sub-title">' . $status_device . '</span>';
				$data .= '</li>';
			}
		}
		$output = [
			'listPage' => $data,
		];
		echo json_encode($output);
	}

	public function load_user()
	{
		$users = $this->m_user->getTable();
		$page = $_POST['page'];
		if ($page <= 1) {
			$number = $page;
		} else {
			$number = 45 * ($page - 1) + 1;
		}
		$data = '';
		$i = $number;
		if (empty($users)) {
			$data = '<center><img src="../assets/img/design/devicewhatsappfix.png" style="width:300px;"/></center>';
		} else {
			$data = '';
			foreach ($users as $key) {
				$data .= '<li>';
				$data .= '<input id="iduser" value="' . $key['id'] . '" style="display:none">';
				$data .= '<span class="nomor">' . $i++ . '.</span>';
				$data .= '<span class="option"><div class="dropdown">';
				$data .= '<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"><i class="far fa-cogs"></i></a>';
				$data .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">';
				$data .= '<a class="dropdown-item btnKuota" data-kuota="' . $key['kuota_wa'] . '" data-id="' . $key['id'] . '" href="#"><i class="fa fa-wrench"></i> Update / Tambah Kuota</a>';
				$data .= '</div></div></span>';
				$data .= '<span class="title">' . $key['nama'] . '</span>';
				$data .= '<span class="sub-title">Kuota Whatsapp ' . $key['kuota_wa'] . '</span>';
				$data .= '</li>';
			}
		}
		$output = [
			'totalRecord' => count($users),
			'listPage' => $data,
			'totalData' => 100
		];

		echo json_encode($output);
	}

	public function get_qr($device)
	{
		$data = get_qr($device);
		$json = [
			'qr' => $data,
		];
		echo json_encode($json);
	}

	public function add_device()
	{
		$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
		$nomor_wa = trim($this->input->post('nomor_wa'));
		$data = [
			'user_id' => $user['id'],
			'nomor_wa' => $nomor_wa,
		];
		$cekNumber = $this->m_whatsapp->byNumber($nomor_wa);
		if ($cekNumber) {
			$json = [
				'status' => 2,
				'pesan' => 'Nomor whatsapp ini sudah terdaftar!'
			];
			echo json_encode($json);
			return false;
		}
		$query = $this->db->insert('wa_devices', $data);
		if ($query) {
			$data = get_qr($nomor_wa);
			$json = [
				'status' => 1,
				'pesan' => 'Nomor whatsapp berhasil disimpan!',
				'qr' => $data,
			];
			echo json_encode($json);
			return false;
		} else {
			$json = [
				'status' => 3,
				'pesan' => 'GAGAL menyimpan, Ulangi!'
			];
			echo json_encode($json);
			return false;
		}
	}

	public function remove_device()
	{
		$id = $this->input->post('id');
		$wa = $this->m_whatsapp->byId($id);
		if ($wa) {
			$logout = logout_device($wa['nomor_wa']);
			if ($logout['success']) {
				$this->db->where('id', $wa['id'])->delete('wa_devices');
				$json = [
					'status' => 1,
					'pesan' => 'Nomor whatsapp ini telah dihapus dari sistem Bukutamu Digital!'
				];
			} else {
				if ($logout['message'] == "Session not found.") {
					$this->db->where('id', $wa['id'])->delete('wa_devices');
					$json = [
						'status' => 1,
						'pesan' => 'Nomor whatsapp ini telah dihapus dari sistem Bukutamu Digital!'
					];
				} else {
					$json = [
						'status' => 2,
						'pesan' => 'Terjadi kesalahan server',
					];
				}
			}
		} else {
			$json = [
				'status' => 2,
				'pesan' => 'Nomor whatsapp ini tidak ditemukan!'
			];
		}
		echo json_encode($json);
	}

	public function get_profile($device)
	{
		$result = get_profile($device);
		var_dump($result);
	}


	public function campaign()
	{
		sedangLogout();
		$data['user'] = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
		if ($data['user']['role'] == 2) {
			$data['events'] = $this->m_event->byIdUser($data['user']['id']);
		} else {
			$data['event'] = $this->m_event->byId($data['user']['event_id']);
		}
		$data['senders'] = $this->m_whatsapp->byUserId($data['user']['id']);
		$data['group'] = $this->m_grup->byEvent($data['event']['id']);
		$tamu = $this->m_tamu->byEvent($data['user']['event_id']);
		$this->load->view('template/header', $data);
		$this->load->view('whatsapp/campaign', $data);
	}

	public function saveCampaign()
	{
		sedangLogout();
		header('Content-Type: application/json');
		$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
		if ($this->input->post('schedule') == null) {
			$status = 'starting';
		} else {
			$status = 'waiting';
		}

		$delay = $this->input->post('delay');

		if ($this->input->post('type') == 'selected') {
			if ($this->input->post('event_id')) {
				$event = $this->m_event->byId($this->input->post('event_id'));
			} else {
				$event = $this->m_event->byId($this->session->userdata('sesiEventNewImam'));
			}
			$sender = $this->input->post('sender');
			$jmlReceiver = count($this->input->post('id'));

			if ($user['kuota_wa'] < $jmlReceiver) {
				$json = [
					'kode' => 2,
					'pesan' => 'Kuota whatsapp kamu tidak cukup/sudah habis! Hubungi admin/vendor kamu untuk menambah kuota. atau kamu tetap dapat kirim Whatsapp secara manual, kuota anda sisa = ' . $user['kuota_wa']
				];
				echo json_encode($json);
				return '';
			}


			$data = [
				'event_id' => $event['id'],
				'user_id' => $user['id'],
				'leader_id' => $event['leader_id'],
				'name' => $event['nama'],
				'template' => $event['wa'],
				'delay' => $delay,
				'status' => 'starting',
				'sender' => $sender,
				'receivers' => json_encode($this->input->post('id')),
				'schedule' => '',
				'campaign_type' => 'selected'
			];
		} else {
			$group_id = $this->input->post('receivers');
			$event_id = $this->input->post('event_id');
			$tamu = $this->m_tamu->jmlTamuByGroupEvent($group_id, $event_id);
			if ($user['kuota_wa'] <= $tamu) {
				$json = [
					'kode' => 2,
					'pesan' => 'Kuota whatsapp kamu tidak cukup/sudah habis! Hubungi admin/vendor kamu untuk menambah kuota. atau kamu tetap dapat kirim Whatsapp secara manual'
				];
				echo json_encode($json);
				return '';
			}
			$data = [
				'event_id' => $this->input->post('event_id'),
				'user_id' => $this->input->post('user_id'),
				'leader_id' => $this->input->post('leader_id'),
				'name' => $this->input->post('name'),
				'template' => $this->input->post('template'),
				'delay' => $delay,
				'status' => $status,
				'sender' => $this->input->post('sender'),
				'receivers' => $this->input->post('receivers'),
				'schedule' => $this->input->post('schedule'),
				'campaign_type' => 'group'
			];
		}

		$query = $this->db->insert('campaigns', $data);

		if ($query) {
			$json = [
				'kode' => 1,
				'pesan' => 'Pesan WhatsApp anda akan segera dikirimkan!'
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

	public function tambahKuota()
	{
		sedangLogout();
		$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
		if ($user['role'] == 1) {
			$this->db->set('kuota_wa', $this->input->post('kuota_wa'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('user');
			$json = [
				'status' => 1,
				'pesan' => 'Kuota whatsapp berhasil ditambahkan!'
			];
			echo json_encode($json);
			return false;
		} else {
			$json = [
				'status' => 2,
				'pesan' => 'Anda tidak memiliki akses untuk fitur ini!'
			];
			echo json_encode($json);
			return false;
		}
	}

	public function transferKuota()
	{
		sedangLogout();
		$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
		if ($user['role'] == 2) {
			$myuser = $this->m_user->byId($this->input->post('user'));
			$this->db->set('kuota_wa', $myuser['kuota_wa'] + $this->input->post('transfer_kuota'));
			$this->db->where('id', $this->input->post('user'));
			$this->db->update('user');
			$this->db->set('kuota_wa', $user['kuota_wa'] - $this->input->post('transfer_kuota'));
			$this->db->where('id', $user['id']);
			$this->db->update('user');
			$json = [
				'status' => 1,
				'pesan' => 'Kuota whatsapp berhasil diupdate!',
				'kuota_awal' => $myuser
			];
			echo json_encode($json);
			return false;
		} else {
			$json = [
				'status' => 2,
				'pesan' => 'Anda tidak memiliki akses untuk fitur ini!'
			];
			echo json_encode($json);
			return false;
		}
	}

	public function updateStatusCampaign()
	{
		sedangLogout();
		$id = $this->input->post('id');
		$data = array('status' => $this->input->post('status'));
		$this->m_campaign->update_status($id, $data);
		$json = [
			'status_class' => 'badge-secondary',
			'status' => $this->input->post('status')
		];
		echo json_encode($json);
	}

	public function deleteCampaign($id)
	{
		sedangLogout();
		$this->db->delete('campaigns', array('id' => $id));
		$this->db->delete('blast_history', array('campaign_id' => $id));
		$json = [
			'success' => true
		];
		echo json_encode($json);
	}

	public function cekJumlahTamu()
	{
		$group_id = $this->input->post('group_id');
		$event_id = $this->input->post('event_id');
		$tamu = $this->m_tamu->jmlTamuByGroupEvent($group_id, $event_id);
		$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
		if ($user['kuota_wa'] <= $tamu) {
			echo 'Perhatian : Kredit anda tidak mencukupi untuk mengirimkan pesan pada seluruh tamu pada grup ini. Sisa kredit anda adalah ' . $user['kuota_wa'];
		} else {
			echo 'Kredit terpakai : ' . $tamu . ' (sisa kuota setelah pesan terkirim) ' . ($user['kuota_wa'] - $tamu) . ' kredit';
		}
	}

	public function listGroup()
	{
		$event_id = $this->input->post('event_id');
		$groups = $this->m_grup->byEvent($event_id);
		echo '<option value="all">All Group Tamu</option>';
		foreach ($groups as $group) {
			echo '<option value="' . $group['id'] . '">' . $group['nama'] . '</option>';
		}
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

	public function design_undangan()
	{
		$data['event'] = $this->m_event->byId($_GET['id_event']);
		$data['tamu'] = $this->m_tamu->byId($_GET['id_tamu']);
		$this->creatBarcode($data['tamu']['nama'], $data['tamu']['nama']);
		$data['qr'] = base_url('assets/img/qr/' . $data['tamu']['nama'] . '.png');
		$this->load->view('template/undangan_wa', $data);
	}

	public function undangan($id_event, $id_tamu)
	{
		$event = $this->m_event->byId($id_event);
		$tamu = $this->db->get_where('tamu', ['id' => $id_tamu])->row_array();
		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$options->set('defaultPaperSize', [0.0, 0.0, 1190.55, 1600.55]);
		$options->set('dpi', 30);
		$dompdf = new Dompdf($options);
		$url = base_url('whatsapp/design_undangan') . '?id_tamu=' . $id_tamu . '&id_event=' . $id_event;
		$dompdf->loadHtmlFile($url);
		$dompdf->render();
		$rand = time();
		$output = FCPATH . 'assets/whatsapp/' . $rand . '.pdf';
		file_put_contents($output, $dompdf->output());
		$image = new Imagick();
		$image->readImage($output);
		$image->setImageFormat("jpg");
		$img_name = FCPATH . 'assets/whatsapp/undangan/' . $rand . '.jpg';
		$image->writeImage($img_name);
		unlink($output);
		$media = base_url('assets/whatsapp/undangan/' . $rand . '.jpg');
		$nama = $tamu['nama'];
		$nama = str_replace('&', 'dan', $nama);
		$fileName = $nama . '.jpg';
		// Download gambar
		$this->downloadFile($img_name, $fileName);
		unlink($img_name);
		//$this->deleteFile($img_name);
	}

	public function send_wa()
	{
		$id_tamu = $this->input->post('id');
		$sender = $this->input->post('sender');
		$id_event = $this->session->userdata('sesiEventNewImam');
		$event = $this->m_event->byId($id_event);
		$tamu = $this->db->get_where('tamu', ['id' => $id_tamu])->row_array();
		$user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
		$img_undangan = base_url('whatsapp/undangan/' . $event['id'] . '/' . $tamu['id']);
		if ($user['kuota_wa'] > 0 or $user['role'] == 1) {
			if ($event['is_qr'] != 0) {
				$options = new Options();
				$options->set('isRemoteEnabled', true);
				$options->set('defaultPaperSize', [0.0, 0.0, 1190.55, 1600.55]);
				$options->set('dpi', 30);
				$dompdf = new Dompdf($options);
				$url = base_url('whatsapp/design_undangan') . '?id_tamu=' . $id_tamu . '&id_event=' . $id_event;
				$dompdf->loadHtmlFile($url);
				$dompdf->render();
				$rand = time();
				$output = FCPATH . 'assets/whatsapp/' . $rand . '.pdf';
				file_put_contents($output, $dompdf->output());
				$image = new Imagick();
				$image->readImage($output);
				$image->setImageFormat("jpg");
				$img_name = FCPATH . 'assets/whatsapp/undangan/' . $rand . '.jpg';
				$image->writeImage($img_name);
				unlink($output);
				$nama = $tamu['nama'];
				//$nama = str_replace(' ', '%20', $nama);
				$nama = str_replace('&', 'dan', $nama);
				$namakode = urlencode($nama);
				$link_undangan = $event['undangan'] . '?to=' . $namakode;
				$wa = $event['wa'];
				$text = str_replace('[NAMA-TAMU]', $nama, $wa);
				$text = str_replace('[LINK]', $link_undangan, $text);
				$text = str_replace('[E-INVITATION]', $img_undangan, $text);
				$caption = $text;
				$media = base_url('assets/whatsapp/undangan/' . $rand . '.jpg');
				$result = send_image($sender, $caption, $media, $tamu['nomor_wa']);
				unlink(FCPATH . 'assets/whatsapp/undangan/' . $rand . '.jpg');
			} else {
				$nama = $tamu['nama'];
				//$nama = str_replace(' ', '%20', $nama);
				$nama = str_replace('&', 'dan', $nama);
				$namakode = urlencode($nama);
				$link_undangan = $event['undangan'] . '?to=' . $namakode;
				$wa = $event['wa'];
				$text = str_replace('[NAMA-TAMU]', $nama, $wa);
				$text = str_replace('[LINK]', $link_undangan, $text);
				$text = str_replace('[E-INVITATION]', $img_undangan, $text);
				$caption = $text;
				$media = base_url('assets/img/event/' . $event['poto']);
				$result = send_image($sender, $caption, $media, $tamu['nomor_wa']);
			}
			if ($result['success'] == true) {
				$this->db->set('kuota_wa', $user['kuota_wa'] - 1);
				$this->db->where('id', $user['id']);
				$this->db->update('user');
				$result = ['status' => true, 'msg' => 'Undangan terkirim'];
			} else {
				$result = ['status' => false, 'msg' => $result['message']];
			}
		} else {
			$result = ['status' => false, 'msg' => 'Kuota whatsapp kamu tidak cukup/sudah habis! Hubungi admin/vendor kamu untuk menambah kuota. atau kamu tetap dapat kirim Whatsapp secara manual'];
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}


	public function runSched()
	{
		$currentDateTime = date('Y-m-d H:i:s');
		$this->m_campaign->bySchedule($currentDateTime);
	}

	public function runCampaign()
	{
		$campaigns = $this->m_campaign->getAll();
		foreach ($campaigns as $campaign) {
			if ($campaign['status'] == 'starting') {
				if ($campaign['campaign_type'] == 'group') {
					$user = $this->m_user->byId($campaign['user_id']);
					$receivers = $this->m_tamu->tamuByGroupEvent($campaign['receivers'], $campaign['event_id']);
					$event = $this->m_event->byId($campaign['event_id']);
					echo 'Run this campaign id (' . $campaign['id'] . ')' . PHP_EOL;
					$data = array('status' => 'running');
					$this->m_campaign->update_status($campaign['id'], $data);
					$kuota = $user['kuota_wa'];
					foreach ($receivers as $receiver) {
						$currentCampaign = $this->m_campaign->byId($campaign['id']);
						echo 'status current campaign ' . $currentCampaign['status'] . PHP_EOL;
						if ($currentCampaign['status'] == 'pause' or $currentCampaign['status'] == 'finished') {
							return '';
						} else {
							$is_sent = $this->m_campaign->getHistoryByTamuId($receiver['id'], $campaign['id']);
							if ($is_sent) {
								echo 'Already sent. skip' . PHP_EOL;
								continue;
							}
							if ($receiver['nomor_wa'] == null) {
								echo 'Nomor whatsapp tamu atas nama ' . $receiver['nama'] . ' belum didaftarkan' . PHP_EOL;
							} else {
								if ($kuota > 0) {
									echo 'Send whatsapp to ' . $receiver['nama'] . PHP_EOL;
									$event = $this->m_event->byId($campaign['event_id']);
									$nama = $receiver['nama'];
									$nama = str_replace('&', 'dan', $nama);
									$nama = str_replace("'", '', $nama);
									$nama = str_replace('"', '', $nama);
									$img_undangan = base_url('whatsapp/undangan/' . $event['id'] . '/' . $receiver['id']);
									if ($event['is_qr']) {
										$options = new Options();
										$options->set('isRemoteEnabled', true);
										$options->set('defaultPaperSize', [0.0, 0.0, 1190.55, 1600.55]);
										$options->set('dpi', 30);
										$dompdf = new Dompdf($options);
										$url = base_url('whatsapp/design_undangan') . '?id_tamu=' . $receiver['id'] . '&id_event=' . $campaign['event_id'];
										$dompdf->loadHtmlFile($url);
										$dompdf->render();
										$rand = time();
										$output = FCPATH . 'assets/whatsapp/' . $rand . '.pdf';
										file_put_contents($output, $dompdf->output());
										$image = new Imagick();
										$image->readImage($output);
										$image->setImageFormat("jpg");
										$img_name = FCPATH . 'assets/whatsapp/undangan/' . $rand . '.jpg';
										$image->writeImage($img_name);
										unlink($output);
										$sender = $campaign['sender'];
										$namakode = urlencode($nama);
										$link_undangan = $event['undangan'] . '?to=' . $namakode;
										$template = $campaign['template'];
										$text = str_replace('[NAMA-TAMU]', $nama, $template);
										$text = str_replace('[LINK]', $link_undangan, $text);
										$text = str_replace('[E-INVITATION]', $img_undangan, $text);
										$caption = $text;
										$media = base_url('assets/whatsapp/undangan/' . $rand . '.jpg');
										$result = send_image($sender, $caption, $media, $receiver['nomor_wa']);
										unlink($img_name);
									} else {
										$sender = $campaign['sender'];
										$namakode = urlencode($nama);
										$link_undangan = $event['undangan'] . '?to=' . $namakode;
										$template = $campaign['template'];
										$text = str_replace('[NAMA-TAMU]', $nama, $template);
										$text = str_replace('[LINK]', $link_undangan, $text);
										$text = str_replace('[E-INVITATION]', $img_undangan, $text);

										$caption = $text;
										$media = base_url('assets/img/event/' . $event['poto']);
										$result = send_image($sender, $caption, $media, $receiver['nomor_wa']);
									}

									if ($result['success'] == true) {
										$kuota--;
										$this->db->set('kuota_wa', $kuota);
										$this->db->where('id', $user['id']);
										$this->db->update('user');
									} else {
										echo $result['message'];
									}
									$data = array(
										'tamu_id' => $receiver['id'],
										'nama_tamu' => $receiver['nama'],
										'event_id' => $campaign['event_id'],
										'user_id' => $campaign['user_id'],
										'campaign_id' => $campaign['id'],
										'device' => $campaign['sender'],
										'nomor_wa' => $receiver['nomor_wa'],
										'status' => $result['success'],
										'response' => $result['message'],
									);
									$this->db->insert('blast_history', $data);
									sleep($campaign['delay']);
								} else {
									echo 'Kuota anda telah habis<br />';
								}
							}
						}
					}
					$data = array('status' => 'finished');
					$this->m_campaign->update_status($campaign['id'], $data);
				}
				if ($campaign['campaign_type'] == 'selected') {
					$user = $this->m_user->byId($campaign['user_id']);
					$receivers = json_decode($campaign['receivers'], true);
					$event = $this->m_event->byId($campaign['event_id']);
					echo 'Run this campaign id (' . $campaign['id'] . ') with selected user' . PHP_EOL;
					$data = array('status' => 'running');
					$this->m_campaign->update_status($campaign['id'], $data);
					$kuota = $user['kuota_wa'];
					foreach ($receivers as $tamu) {
						$receiver = $this->m_tamu->byId($tamu);
						$currentCampaign = $this->m_campaign->byId($campaign['id']);
						if ($currentCampaign['status'] == 'pause' or $currentCampaign['status'] == 'finished') {
							return 'campaign is in finished state';
						} else {
							$is_sent = $this->m_campaign->getHistoryByTamuId($receiver['id'], $campaign['id']);
							if ($is_sent) {
								echo 'Already sent. skip' . PHP_EOL;
								continue;
							}
							if ($receiver['nomor_wa'] == null) {
								echo 'Nomor whatsapp tamu atas nama ' . $receiver['nama'] . ' belum didaftarkan<br />';
							} else {
								if ($kuota > 0) {
									echo 'Send whatsapp to ' . $receiver['nama'] . '<br />';
									$event = $this->m_event->byId($campaign['event_id']);
									$nama = $receiver['nama'];
									$nama = str_replace('&', 'dan', $nama);
									$nama = str_replace("'", '', $nama);
									$nama = str_replace('"', '', $nama);
									$img_undangan = base_url('whatsapp/undangan/' . $event['id'] . '/' . $tamu);
									if ($event['is_qr']) {
										$options = new Options();
										$options->set('isRemoteEnabled', true);
										$options->set('defaultPaperSize', [0.0, 0.0, 1190.55, 1600.55]);
										$options->set('dpi', 30);
										$url = base_url('whatsapp/design_undangan') . '?id_tamu=' . $tamu . '&id_event=' . $campaign['event_id'];
										$dompdf = new Dompdf($options);
										$dompdf->loadHtmlFile($url);
										$dompdf->render();
										$rand = time();
										$output = FCPATH . 'assets/whatsapp/' . $rand . '.pdf';
										file_put_contents($output, $dompdf->output());
										$image = new Imagick();
										$image->readImage($output);
										$image->setImageFormat("jpg");
										$img_name = FCPATH . 'assets/whatsapp/undangan/' . $rand . '.jpg';
										$image->writeImage($img_name);
										unlink($output);
										$sender = $campaign['sender'];
										$namakode = urlencode($nama);
										$link_undangan = $event['undangan'] . '?to=' . $namakode;
										$template = $campaign['template'];
										$text = str_replace('[NAMA-TAMU]', $nama, $template);
										$text = str_replace('[LINK]', $link_undangan, $text);
										$text = str_replace('[E-INVITATION]', $img_undangan, $text);
										$caption = $text;
										$media = base_url('assets/whatsapp/undangan/' . $rand . '.jpg');
										$result = send_image($sender, $caption, $media, $receiver['nomor_wa']);
										unlink($img_name);
									} else {
										$sender = $campaign['sender'];
										$namakode = urlencode($nama);
										$link_undangan = $event['undangan'] . '?to=' . $namakode;
										$template = $campaign['template'];
										$text = str_replace('[NAMA-TAMU]', $nama, $template);
										$text = str_replace('[LINK]', $link_undangan, $text);
										$text = str_replace('[E-INVITATION]', $img_undangan, $text);
										$caption = $text;
										$media = base_url('assets/img/event/' . $event['poto']);
										$result = send_image($sender, $caption, $media, $receiver['nomor_wa']);
									}

									if ($result['success'] == true) {
										echo 'Pesan terkirim. mengurangi kuota' . PHP_EOL;
										$kuota--;
										$this->db->set('kuota_wa', $kuota);
										$this->db->where('id', $user['id']);
										$this->db->update('user');
									} else {
										echo $result['message'];
									}
									$data = array(
										'tamu_id' => $receiver['id'],
										'nama_tamu' => $receiver['nama'],
										'event_id' => $campaign['event_id'],
										'user_id' => $campaign['user_id'],
										'campaign_id' => $campaign['id'],
										'device' => $campaign['sender'],
										'nomor_wa' => $receiver['nomor_wa'],
										'status' => $result['success'],
										'response' => $result['message'],
									);
									$this->db->insert('blast_history', $data);
									sleep($campaign['delay']);
								} else {
									echo 'Kuota anda telah habis<br />';
								}
							}
						}
					}
					$data = array('status' => 'finished');
					$this->m_campaign->update_status($campaign['id'], $data);
				}
			}
		}
	}

	private function downloadFile($url, $fileName)
	{
		$data = file_get_contents($url);
		force_download($fileName, $data);
	}

	private function deleteFile($fileName)
	{
		$filePath = $fileName; // Lokasi file
		// Hapus file jika ada
		if (file_exists($filePath)) {
			unlink($filePath);
		}
	}
}
