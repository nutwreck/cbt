</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="<?php echo base_url(); ?>admin">
                            <img src="https://see.fontimg.com/api/renderfont4/BW768/eyJyIjoiZnMiLCJoIjo2NCwidyI6MTAwMCwiZnMiOjY0LCJmZ2MiOiIjMUVBREZGIiwiYmdjIjoiI0ZGRkZGRiIsInQiOjF9/dWppYW4gb25saW5l/gv-time-regular.png" width="60%" alt="logo-ujian-online">
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="active">
                            <a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-tachometer"></i>Dashboard</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#"><i class="fa fa-book"></i>Tes Online</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/materi">Materi</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/paket-soal">Paket Soal</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/sesi-pelaksana">Sesi Pelaksana</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/report-ujian">Report Ujian</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/report-buku">Report Tes Buku</a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#"><i class="fa fa-users"></i>User Management</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/user-lembaga">User Admin</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/group-participants">Group Peserta</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/participants">Peserta</a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#"><i class="fa fa-folder-open"></i>Lembaga Management</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/data-lembaga">Data Lembaga</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/konversi-skor">Konversi Skor</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/buku-setting">Buku Setting</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/pembayaran-master">Master Pembayaran</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/voucher">Kode Voucher</a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#"><i class="fa fa-folder-money"></i>Keuangan</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/invoice">All Invoice</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/invoice-confirm">Konfirmasi Pembayaran</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/invoice-expired">Invoice Expired</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/invoice-success">Pembayaran Sukses</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>admin/logout"><i class="zmdi zmdi-power"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->