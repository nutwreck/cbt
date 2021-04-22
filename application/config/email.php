<?php

$config = [
	'useragent' => 'Zambert Testing Ujian Online',
	'protocol' => 'smtp',
	'mailtype'  => 'html',
	'mailpath' => '/usr/sbin/sendmail',
	'charset'   => 'utf-8',
	'smtp_host' => 'smtp.zoho.com',
	'smtp_user' => 'event@zambert-course.com',  // Email
	'smtp_pass'   => 'Tamankeludselatan5a',  // Password
	'smtp_timeout' => 600,
	'smtp_crypto' => 'tls',
	'smtp_port'   => 587,
	'send_multipart' => FALSE,
	'crlf'    => "\r\n",
	'wordwrap' => TRUE
];

/* How To Use
    1. Tambah e $this->load->config('email'); //SET CONFIG EMAIL ning function __construct class
    2. Kode email
            $from = $this->config->item('smtp_user');
			$subject = 'Testing Email;
			$message = $this->load->view("",$data,TRUE); //halaman view email, $data berisi data2 lemparan ke view

			$this->email->set_newline("\r\n");
			$this->email->from($from, '[NO-REPLY] Testing Sistem');
			$this->email->to($send_to);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->send();
			*/