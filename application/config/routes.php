<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home';
$route['404_override'] = 'My404';
$route['javascript-not-available'] = 'JS_detect';
$route['translate_uri_dashes'] = FALSE;

/*
|
| START WEBSITE URL FOR USER ONLY
|
*/
$route['dashboard'] = 'website/user/Dashboard';
$route['history'] = 'website/user/Dashboard/history_ujian';
$route['detail-history'] = 'website/user/Dashboard/detail_history_ujian';
$route['pre-ujian'] = 'website/user/Ujian/mulai_ujian';
$route['ujian'] = 'website/user/Ujian';
/* $route['ujian2'] = 'website/user/Ujian/ujian_page_next_design'; */
/*
|
| END WEBSITE URL FOR USER ONLY
|
*/

/*
|
| START WEBSITE URL FOR LEMBAGA ONLY
|
*/
$route['admin/dashboard'] = 'website/lembaga/Dashboard';
$route['admin/materi'] = 'website/lembaga/Tes_online/materi';
$route['admin/add-materi'] = 'website/lembaga/Tes_online/add_materi';
$route['admin/edit-materi/(:num)'] = 'website/lembaga/Tes_online/edit_materi/$1';
$route['admin/delete-materi/(:num)'] = 'website/lembaga/Tes_online/delete_materi/$1';
$route['admin/active-materi/(:num)'] = 'website/lembaga/Tes_online/active_materi/$1';
$route['admin/paket-soal'] = 'website/lembaga/Tes_online/paket_soal';
$route['admin/add-paket-soal'] = 'website/lembaga/Tes_online/add_paket_soal';
$route['admin/detail-paket-soal/(:any)'] = 'website/lembaga/Tes_online/get_detail_paket_data/$1';
$route['admin/edit-paket-soal/(:any)'] = 'website/lembaga/Tes_online/edit_paket_data/$1';
$route['admin/disable-paket-soal/(:any)'] = 'website/lembaga/Tes_online/disable_paket_data/$1';
$route['admin/active-paket-soal/(:any)'] = 'website/lembaga/Tes_online/active_paket_data/$1';
$route['admin/list-soal/(:any)'] = 'website/lembaga/Tes_online/list_soal/$1';
$route['admin/add-soal/(:any)'] = 'website/lembaga/Tes_online/add_soal/$1';
$route['admin/import-soal/(:any)'] = 'website/lembaga/Tes_online/import_soal/$1';
$route['admin/edit-soal/(:any)/(:any)/(:num)'] = 'website/lembaga/Tes_online/edit_soal/$1/$2/$3';
$route['admin/disable-soal/(:any)/(:any)/(:num)'] = 'website/lembaga/Tes_online/disable_soal/$1/$2/$3';
$route['admin/drop-all/(:any)'] = 'website/lembaga/Tes_online/disable_all_soal/$1';
$route['admin/sesi-pelaksana'] = 'website/lembaga/Tes_online/sesi_pelaksana';
$route['admin/user-lembaga'] = 'website/lembaga/User/user_lembaga';
$route['admin/add-user-lembaga'] = 'website/lembaga/User/add_user_lembaga';
$route['admin/edit-user-lembaga/(:any)/(:any)'] = 'website/lembaga/User/edit_user_lembaga/$1/$2';
$route['admin/disable-user-lembaga/(:any)/(:any)'] = 'website/lembaga/user/disable_user_lembaga/$1/$2';
$route['admin/group-participants'] = 'website/lembaga/User/group_participants';
$route['admin/add-group-participants'] = 'website/lembaga/user/add_group_participants';
$route['admin/edit-group-participants/(:any)'] = 'website/lembaga/user/edit_group_participants/$1';
$route['admin/disable-group-participants/(:any)'] = 'website/lembaga/user/disable_group_participants/$1';
$route['admin/participants'] = 'website/lembaga/User/participants';
$route['admin/add-participants'] = 'website/lembaga/User/add_participants';
$route['admin/add-import-participants'] = 'website/lembaga/User/add_import_excel_participants';
$route['admin/edit-participants/(:any)/(:any)'] = 'website/lembaga/user/edit_participants/$1/$2';
$route['admin/disable-participants/(:any)/(:any)'] = 'website/lembaga/user/disable_participants/$1/$2';
$route['admin/login'] = 'website/lembaga/Login';
$route['admin/submit-login'] = 'website/lembaga/Login/submit_login';
$route['admin/logout'] = 'website/lembaga/Dashboard/logout';
$route['admin/data-lembaga'] = 'website/lembaga/Management/data_lembaga';
$route['admin/bacaan-soal/(:any)'] = 'website/lembaga/Tes_online/bacaan_soal/$1';
$route['admin/add-bacaan-soal/(:any)'] = 'website/lembaga/Tes_online/add_bacaan_soal/$1';
$route['admin/detail-bacaan-soal/(:any)'] = 'website/lembaga/Tes_online/detail_bacaan_soal/$1';
$route['admin/edit-bacaan-soal/(:any)/(:any)'] = 'website/lembaga/Tes_online/edit_bacaan_soal/$1/$2';
$route['admin/disable-bacaan-soal/(:any)/(:any)'] = 'website/lembaga/Tes_online/disable_bacaan_soal/$1/$2';
$route['admin/group-soal/(:any)'] = 'website/lembaga/Tes_online/group_soal/$1';
$route['admin/add-group-soal/(:any)'] = 'website/lembaga/Tes_online/add_group_soal/$1';
$route['admin/detail-group-soal/(:any)/(:any)'] = 'website/lembaga/Tes_online/detail_group_soal/$1/$2';
$route['admin/edit-group-soal/(:any)/(:any)'] = 'website/lembaga/Tes_online/edit_group_soal/$1/$2';
$route['admin/disable-group-soal/(:any)/(:any)'] = 'website/lembaga/Tes_online/disable_group_soal/$1/$2';
$route['admin/konversi-skor'] = 'website/lembaga/Management/konversi';
$route['admin/add-konversi-skor'] = 'website/lembaga/Management/add_konversi';
$route['admin/edit-konversi-skor/(:any)'] = 'website/lembaga/Management/edit_konversi/$1';
$route['admin/delete-konversi-skor/(:any)'] = 'website/lembaga/Management/disable_konversi/$1';
$route['admin/detail-konversi-skor/(:any)'] = 'website/lembaga/Management/detail_konversi/$1';
$route['admin/add-detail-konversi-skor/(:any)'] = 'website/lembaga/Management/add_detail_konversi/$1';
$route['admin/edit-detail-konversi-skor/(:any)/(:any)'] = 'website/lembaga/Management/edit_detail_konversi/$1/$2';
$route['admin/delete-detail-konversi-skor/(:any)/(:any)'] = 'website/lembaga/Management/disable_detail_konversi/$1/$2';
$route['admin/import-detail-konversi-skor/(:any)'] = 'website/lembaga/Management/import_detail_konversi/$1';
$route['admin/buku-setting'] = 'website/lembaga/Buku_setting/setting_buku';
$route['admin/detail-buku/(:any)'] = 'website/lembaga/Buku_setting/setting_buku_detail/$1';
/*
|
| START WEBSITE URL FOR LEMBAGA ONLY
|
*/