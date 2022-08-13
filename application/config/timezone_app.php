<?php
defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();
$CI->load->library('session');
$CI->load->database();

$default = 'Asia/Jakarta';
try {
    if ($CI->session->has_userdata('has_login_user') && $CI->session->userdata('username') && $CI->session->userdata('user_id')) { //Jika sudah login
        $query = $CI->db->query("
            SELECT timezone
                FROM v_users
                WHERE user_id = '" . $CI->session->userdata('user_id') . "'
				");
        $num = $query->num_rows();

        if ($num > 0) {
            $user_data = $query->result_array();
            if ($user_data[0]['timezone'] != NULL || $user_data[0]['timezone'] == '') {
                $default = $user_data[0]['timezone'];
            } else {
                $default = 'Asia/Jakarta';
            }
        } else {
            $default = 'Asia/Jakarta';
        }
    }
} catch (Exception $e) {
    $default = 'Asia/Jakarta';
}

date_default_timezone_set($default);
setlocale(LC_ALL, 'IND');

/*
|--------------------------------------------------------------------------
| Master Time Reference
|--------------------------------------------------------------------------
|
| Options are 'local' or any PHP supported timezone. This preference tells
| the system whether to use your server's local time as the master 'now'
| reference, or convert it to the configured one timezone. See the 'date
| helper' page of the user guide for information regarding date handling.
|
*/
$config['time_reference'] = 'local';
