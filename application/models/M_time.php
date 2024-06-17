<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_time extends CI_Model
{
  public function hari($hari)
  {
    $nama_hari = $hari;
    switch ($nama_hari) {
      case 'Sun':
        $n_hari = 'Minggu';
        break;
      case 'Mon':
        $n_hari = 'Senin';
        break;
      case 'Tue':
        $n_hari = 'Selasa';
        break;
      case 'Wed':
        $n_hari = 'Rabu';
        break;
      case 'Thu':
        $n_hari = 'Kamis';
        break;
      case 'Fri':
        $n_hari = 'Jumat';
        break;
      case 'Sat':
        $n_hari = 'Sabtu';
        break;
      default:
        $n_hari = 'Tidak diketahui';
        break;
    }

    return $n_hari;
  }

  public function bulan($bulan)
  {
    $nama_bulan = $bulan;
    switch ($nama_bulan) {
      case 'Jan':
        $n_bulan = 'Januari';
        break;
      case 'Feb':
        $n_bulan = 'Pebruari';
        break;
      case 'Mar':
        $n_bulan = 'Maret';
        break;
      case 'Apr':
        $n_bulan = 'April';
        break;
      case 'May':
        $n_bulan = 'Mei';
        break;
      case 'Jun':
        $n_bulan = 'Juni';
        break;
      case 'Jul':
        $n_bulan = 'Juli';
        break;
      case 'Aug':
        $n_bulan = 'Agustus';
        break;
      case 'Sep':
        $n_bulan = 'September';
        break;
      case 'Oct':
        $n_bulan = 'Oktober';
        break;
      case 'Nov':
        $n_bulan = 'November';
        break;
      case 'Dec':
        $n_bulan = 'Desember';
        break;
      default:
        $n_bulan = 'Tidak diketahui';
        break;
    }
    return $n_bulan;
  }


  public function longDate($date)
  {
    $time = strtotime($date);
    $hari = date('D', $time);
    $hari = $this->hari($hari);
    $bulan = date('M', $time);
    $bulan = $this->bulan($bulan);
    $tgl = date('d', $time);
    $tahun = date('Y', $time);

    $group = $hari . ', ' . $tgl . ' ' . $bulan . ' ' . $tahun;
    return $group;
  }


  public function longDateSemi($date)
  {
    $time = strtotime($date);
    // $hari = date('D', $time);
    // $hari = $this->hari($hari);
    $bulan = date('M', $time);
    $bulan = $this->bulan($bulan);
    $tgl = date('d', $time);
    $tahun = date('Y', $time);

    $group = $tgl . ' ' . $bulan . ' ' . $tahun;
    return $group;
  }

  public function DateTime($date)
  {
    $time = strtotime($date);
    $hari = date('D', $time);
    $hari = $this->hari($hari);
    $bulan = date('M', $time);
    $bulan = $this->bulan($bulan);
    $tgl = date('d', $time);
    $tahun = date('Y', $time);
    $wkt = date('H:i:s', $time);

    $group = $tgl . ' ' . $bulan . ' ' . $tahun . ' ' . $wkt;
    return $group;
  }
}