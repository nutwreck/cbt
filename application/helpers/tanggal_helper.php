<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('format_indo')) {
  function format_indo($date)
  {
    $CI = &get_instance();
    $timezone = ($CI->session->userdata('timezone') == NULL || $CI->session->userdata('timezone') == '') && !$CI->session->has_userdata('timezone') ? 'Asia/Jakarta' : $CI->session->userdata('timezone');
    date_default_timezone_set($timezone);
    setlocale(LC_ALL, 'IND');

    // array hari dan bulan
    $Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
    $Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

    // pemisahan tahun, bulan, hari, dan waktu
    $tahun = substr($date, 0, 4);
    $bulan = substr($date, 5, 2);
    $tgl = substr($date, 8, 2);
    $waktu = substr($date, 11, 5);
    $hari = date("w", strtotime($date));
    $result = $Hari[$hari] . ", " . $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu;

    return $result;
  }
}
