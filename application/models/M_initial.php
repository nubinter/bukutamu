<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_initial extends CI_Model
{

  public function colorInitial($t)
  {
    $t = preg_replace("/[^a-zA-Z]/", "N", $t);
    $t = strtoupper($t);
    if ($t == "" || $t == null) {
      $t = 'N';
    }
    $col = [
      'A' => "#1abc9c",
      'B' => "#16a085",
      'C' =>  "#f1c40f",
      'D' =>  "#f39c12",
      'E' =>  "#2ecc71",
      'F' =>  "#27ae60",
      'G' =>  "#e67e22",
      'H' =>  "#d35400",
      'I' => "#3498db",
      'J' =>  "#2980b9",
      'K' =>  "#e74c3c",
      'L' =>  "#c0392b",
      'M' =>  "#9b59b6",
      'N' =>  "#9b6804",
      'O' =>  "#bdc3c7",
      'P' =>  "#34495e",
      'Q' =>  "#2c3e50",
      'R' => "#95a5a6",
      'S' =>  "#7f8c8d",
      'T' => "#ec87bf",
      'U' =>  "#d870ad",
      'V' => "#f69785",
      'W' =>  "#9ba37e",
      'X' =>  "#b49255",
      'Y' => "#b49255",
      'Z' =>  "#a94136",
    ];


    return $col[$t];
  }
}