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
$route['default_controller'] = 'Landing_page'; //Home
$route['404_override'] = 'My404';
$route['javascript-not-available'] = 'JS_detect';
$route['location-checking'] = 'VPN_check';
$route['translate_uri_dashes'] = FALSE;

/*
|
| START WEBSITE URL FOR USER ONLY
|
*/
$route['login'] = 'website/user/Login/login';
$route['register'] = 'website/user/Login';
$route['account'] = 'website/user/User_account/user_account';
$route['lupa-password'] = 'website/user/Lupa_password/lupa_password';
$route['lupa-password/(:any)'] = 'website/user/Lupa_password/lupa_password/$1';
$route['logout'] = 'website/user/Login/logout';
$route['dashboard'] = 'website/user/Dashboard';
$route['history'] = 'website/user/Dashboard/history_ujian';
$route['detail-history'] = 'website/user/Dashboard/detail_history_ujian';
$route['pre-ujian/(:any)'] = 'website/user/Ujian/mulai_ujian/$1';
$route['ujian/(:any)/(:any)'] = 'website/user/Ujian/portal_tes/$1/$2';
$route['ujian-berakhir'] = 'website/user/Ujian/ujian_berakhir';
$route['pembahasan/(:any)/(:any)/(:any)'] = 'website/user/Ujian/pembahasan/$1/$2/$3';
$route['result/(:num)/(:num)'] = 'website/user/Ujian/hasil_ujian/$1/$2';
$route['buku/sbmptn/(:any)'] = 'website/user/Buku/sbmptn/$1';
$route['buku/toefl/(:any)'] = 'website/user/Buku/toefl/$1';
$route['buku/cpns/(:any)'] = 'website/user/Buku/cpns/$1';
$route['buku/tes/mulai/(:any)'] = 'website/user/Buku/mulai_ujian/$1';
$route['buku/tes/pembahasan/(:any)/(:any)/(:any)'] = 'website/user/Buku/pembahasan/$1/$2/$3';
$route['buku/tes/(:any)/(:any)'] = 'website/user/Buku/portal_tes/$1/$2';
$route['buku/result/(:any)'] = 'website/user/Buku/hasil_ujian/$1';
$route['buku/download/(:num)'] = 'website/user/Buku/download_buku/$1';
$route['pembelian-buku/(:any)'] = 'website/user/Buku/pembelian_buku/$1';
$route['purchase'] = 'website/user/Buku/invoice_status';
$route['manual-confirm/(:any)/(:num)'] = 'website/user/Buku/manual_confirm/$1/$2';
$route['buku/tonton/(:any)'] = 'website/user/Buku/tonton/$1';
$route['event'] = 'website/user/Event/url_prefix';
$route['event/(:any)'] = 'website/user/Event/url_prefix/$1';
$route['event/login'] = 'website/user/Event/login';
$route['event/login/(:any)'] = 'website/user/Event/login/$1';
$route['event/logout/(:any)'] = 'website/user/Event/logout/$1';
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
$route['admin'] = 'website/lembaga/Dashboard';
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
$route['admin/paket-sesi-pelaksana'] = 'website/lembaga/Tes_online/paket_sesi_pelaksana';
$route['admin/add-sesi-pelaksana/(:any)'] = 'website/lembaga/Tes_online/add_sesi_pelaksana/$1';
$route['admin/edit-sesi-pelaksana/(:any)'] = 'website/lembaga/Tes_online/edit_sesi_pelaksana/$1';
$route['admin/peserta-sesi-pelaksana/(:any)'] = 'website/lembaga/Tes_online/add_peserta_sesi_pelaksana/$1';
$route['admin/list-peserta-sesi-pelaksana/(:any)'] = 'website/lembaga/Tes_online/list_peserta_sesi_pelaksana/$1';
$route['admin/export-peserta-sesi-pelaksana/(:any)'] = 'website/lembaga/Tes_online/export_list_peserta_sesi_pelaksana/$1';
$route['admin/disable-all-list-peserta-sesi/(:any)'] = 'website/lembaga/Tes_online/disable_all_peserta_sesi_pelaksana/$1';
$route['admin/reset-peserta-sesi/(:any)/(:any)/(:any)'] = 'website/lembaga/Tes_online/reset_peserta_sesi_pelaksana/$1/$2/$3';
$route['admin/disable-peserta-sesi/(:any)/(:any)/(:any)'] = 'website/lembaga/Tes_online/disable_peserta_sesi_pelaksana/$1/$2/$3';
$route['admin/detail-sesi-pelaksana/(:any)'] = 'website/lembaga/Tes_online/detail_sesi_pelaksana/$1';
$route['admin/delete-sesi-pelaksana/(:any)'] = 'website/lembaga/Tes_online/disable_sesi_pelaksana/$1';
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
$route['admin/export-participants'] = 'website/lembaga/User/export_participants';
$route['admin/edit-participants/(:any)/(:any)'] = 'website/lembaga/user/edit_participants/$1/$2';
$route['admin/disable-participants/(:any)/(:any)'] = 'website/lembaga/user/disable_participants/$1/$2';
$route['admin/disable-all-participants'] = 'website/lembaga/user/user_peserta_delete_all';
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
$route['admin/pembayaran-master'] = 'website/lembaga/Management/pembayaran_master';
$route['admin/detail-pembayaran-master/(:any)'] = 'website/lembaga/Management/detail_pembayaran_master/$1';
$route['admin/add-detail-pembayaran-master/(:any)'] = 'website/lembaga/Management/add_detail_pembayaran_master/$1';
$route['admin/edit-detail-pembayaran-master/(:any)'] = 'website/lembaga/Management/edit_detail_pembayaran_master/$1';
$route['admin/delete-detail-pembayaran-master/(:any)/(:any)'] = 'website/lembaga/Management/disable_detail_pembayaran_master/$1/$2';
$route['admin/buku-setting'] = 'website/lembaga/Management/setting_buku';
$route['admin/edit-buku-setting/(:any)'] = 'website/lembaga/Management/edit_setting_buku/$1';
$route['admin/detail-buku/(:any)/(:any)/(:any)'] = 'website/lembaga/Management/setting_buku_detail/$1/$2/$3';
$route['admin/add-group-buku/(:any)/(:any)'] = 'website/lembaga/Management/add_group_buku_detail/$1/$2';
$route['admin/group-buku/(:any)'] = 'website/lembaga/Management/group_buku_detail/$1';
$route['admin/edit-group-buku/(:any)/(:any)'] = 'website/lembaga/Management/edit_group_buku_setting/$1/$2';
$route['admin/add-detail-buku/(:any)/(:any)/(:any)'] = 'website/lembaga/Management/add_detail_buku_setting/$1/$2/$3';
$route['admin/delete-detail-buku/(:any)/(:any)'] = 'website/lembaga/Management/disable_detail_buku_setting/$1/$2';
$route['admin/invoice'] = 'website/lembaga/Management/invoice_list';
$route['admin/invoice-confirm'] = 'website/lembaga/Management/invoice_confirm';
$route['admin/invoice-success'] = 'website/lembaga/Management/invoice_success';
$route['admin/invoice-expired'] = 'website/lembaga/Management/invoice_expired';
$route['admin/invoice-all'] = 'website/lembaga/Management/invoice_list_all';
$route['admin/invoice-confirm-all'] = 'website/lembaga/Management/invoice_list_confirm_all';
$route['admin/invoice-success-all'] = 'website/lembaga/Management/invoice_list_success_all';
$route['admin/invoice-expired-all'] = 'website/lembaga/Management/invoice_list_expired_all';
$route['admin/export-all-invoice'] = 'website/lembaga/Management/export_invoice_all';
$route['admin/export-all-invoice-confirm'] = 'website/lembaga/Management/export_invoice_all_confirm';
$route['admin/export-all-invoice-success'] = 'website/lembaga/Management/export_invoice_all_success';
$route['admin/export-all-invoice-expired'] = 'website/lembaga/Management/export_invoice_all_expired';
$route['admin/invoice/manual-confirm/(:num)/(:any)'] = 'website/lembaga/Management/manual_confirm_invoice/$1/$2';
$route['admin/invoice/reject-confirm/(:any)'] = 'website/lembaga/Management/reject_confirm_invoice/$1';
$route['admin/invoice/delete-invoice/(:num)/(:any)'] = 'website/lembaga/Management/disable_invoice/$1/$2';
$route['admin/report-ujian'] = 'website/lembaga/Tes_online/report_ujian';
$route['admin/detail-report-ujian/(:any)/(:any)'] = 'website/lembaga/Tes_online/detail_report_ujian/$1/$2';
$route['admin/export-report-ujian/(:any)/(:any)'] = 'website/lembaga/Tes_online/export_detail_report_ujian/$1/$2';
$route['admin/export-report-ujian-statistik/(:any)/(:any)'] = 'website/lembaga/Tes_online/export_detail_report_ujian_st/$1/$2';
$route['admin/detail-ujian-peserta/(:any)/(:any)/(:any)'] = 'website/lembaga/Tes_online/detail_ujian_peserta/$1/$2/$3';
$route['admin/report-buku'] = 'website/lembaga/Tes_online/report_buku';
$route['admin/detail-report-buku/(:any)/(:any)'] = 'website/lembaga/Tes_online/detail_report_buku/$1/$2';
$route['admin/detail-buku-peserta/(:any)/(:any)/(:any)'] = 'website/lembaga/Tes_online/detail_buku_peserta/$1/$2/$3';
$route['admin/export-buku-ujian/(:any)/(:any)'] = 'website/lembaga/Tes_online/export_detail_report_buku/$1/$2';
$route['admin/voucher'] = 'website/lembaga/Management/voucher';
$route['admin/add-voucher'] = 'website/lembaga/Management/add_voucher';
$route['admin/edit-voucher/(:num)'] = 'website/lembaga/Management/edit_voucher/$1';
$route['admin/delete-voucher/(:num)'] = 'website/lembaga/Management/disable_voucher/$1';
$route['admin/active-voucher/(:num)'] = 'website/lembaga/Management/active_voucher/$1';
$route['admin/event'] = 'website/lembaga/Management/event_all';
$route['admin/event-add'] = 'website/lembaga/Management/event_add';
$route['admin/event-edit/(:any)'] = 'website/lembaga/Management/event_edit/$1';
$route['admin/event-detail/(:any)'] = 'website/lembaga/Management/event_detail/$1';
$route['admin/event-delete/(:any)'] = 'website/lembaga/Management/event_delete/$1';
/*
|
| START WEBSITE URL FOR LEMBAGA ONLY
|
*/
