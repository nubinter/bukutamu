<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Generate extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_user');
		$this->load->model('m_event');
		noAdmin();
	}

	public function index()
	{
		redirect('seting');
		setcoolor();
		$data['descr'] = base_url() . '- Buku Tamu';
		$data['icon'] = 'logo.png';
		$data['icon1'] = 'logo1.png';
		$data['title'] = base_url();
		$this->load->view('home/generator', $data);
	}


	public function encode()
	{
		$text = trim($this->input->post('text'));
		$gene = base64_encode($text);
		if ($gene) {
			# code...
			$json = [
				'kode' => 1,
				'hasil' => $gene
			];
			echo json_encode($json);
			return false;
		} else {
			# code...
			$json = [
				'kode' => 2,
				'hasil' => 'Diulang'
			];
			echo json_encode($json);
			return false;
		}
	}
}