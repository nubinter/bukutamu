<?php
function passVerf($pass, $hash)
{
  $cek = password_verify($pass, $hash);
  return $cek;
}
function sethadmn()
{
  $hd = 'aHR0cHM6Ly9idWt1dGFtdWRpZ2l0YWwuYXBwLw==';
  return $hd;
}


function passHash($pass)
{
  $cek = password_hash($pass, PASSWORD_DEFAULT);
  return $cek;
}

function sedangLogout()
{
  $ci = get_instance();
  if (!$ci->session->userdata('loginAksesNewImam')) {
    redirect();
  }
}
function sedangLogin()
{
  $ci = get_instance();
  if ($ci->session->userdata('loginAksesNewImam')) {
    redirect('home');
  }
}
function noAdmin()
{
  $ci = get_instance();
  $us = $ci->db->get_where('user', ['username' => $ci->session->userdata('loginAksesNewImam')])->row_array();
  if ($us['role'] != 1) {
    # code...
    redirect('home');
  }
}
function setcoolor()
{
  $ci = get_instance();
  $cl = sethadmn();
  $cl = base64_decode($cl);
  if ($cl != base_url()) {
    redirect('auth/logout');
  }
}
function generate_random_string($name_length = 8)
{
  $alpha_numeric = '01234567895678901234';
  return substr(str_shuffle(str_repeat($alpha_numeric, $name_length)), 0, $name_length);
}



function cekTableDb()
{
  $ci = get_instance();
  if (!$ci->db->table_exists('user')) {
    $ci->m_table->creatTbUser();
  }
  if (!$ci->db->table_exists('event')) {
    $ci->m_table->creatTbEvent();
  }
  if (!$ci->db->table_exists('keys_api')) {
    $ci->m_table->creatKey();
  }
  if (!$ci->db->table_exists('kode')) {
    $ci->m_table->creatKode();
  }
  if (!$ci->db->table_exists('tamu')) {
    $ci->m_table->creatTbtamu();
  }
  if (!$ci->db->table_exists('tamu_import')) {
    $ci->m_table->creatTbTamuImport();
  }
  if (!$ci->db->table_exists('undangan')) {
    $ci->m_table->creatTbUndangan();
  }
  if (!$ci->db->table_exists('welcome')) {
    $ci->m_table->creatTbWelcome();
  }
  if (!$ci->db->table_exists('group_tamu')) {
    $ci->m_table->creatTbGroupTamu();
  }
  if (!$ci->db->table_exists('blast_history')) {
    $ci->m_table->creatTbBlastHistory();
  }

  if (!$ci->db->table_exists('campaigns')) {
    $ci->m_table->creatTbCampaign();
  }

  if (!$ci->db->table_exists('kuota_wa')) {
    $ci->m_table->creatTbKuotaWa();
  }
  
  if (!$ci->db->table_exists('wa_devices')) {
    $ci->m_table->creatTbWaDevices();
  }

  $ci->m_table->creatUser();
  $ci->m_table->creatEvent();
  $ci->m_table->creatUndangan();
  $ci->m_table->creatGroup();
}