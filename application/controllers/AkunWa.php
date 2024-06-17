<?php
defined('BASEPATH') or exit('No direct script access allowed');error_reporting(0);

class AkunWa extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_user');
    $this->load->model('m_event');
	$this->load->model('m_akun_wa');
	$this->load->library('parser');
    sedangLogout();
    // setcoolor();
  }
  
  public function index()
  {
    $user = $this->m_user->byUser($this->session->userdata('loginAksesNewImam'));
    $akun = $this->m_akun_wa->byUserId($user->id);
    $data['akun'] = $akun;
    $data['user'] = $user;
    $data['descr'] = base_url() . '- Buku Tamu';
    $data['icon'] = 'logo.png';
	$data['icon1'] = 'logo1.png';
    $data['title'] = base_url();
    $this->load->view('template/header', $data);
    //$this->load->view('akun_wa/index', $data);
	$this->parser->parse('akun_wa/index', $data);
  }
}

?>