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
                            <a href="<?php echo base_url(); ?>lembaga/dashboard"><i class="fa fa-tachometer"></i>Dashboard<small class="text-danger">(Coming Soon)</small></a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#"><i class="fa fa-book"></i>Tes Online</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="<?php echo base_url(); ?>lembaga/materi">Materi</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>lembaga/paket-soal">Paket Soal</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>lembaga/sesi-pelaksana">Sesi Pelaksana</a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#"><i class="fa fa-users"></i>User Management</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="<?php echo base_url(); ?>lembaga/user-lembaga">User Admin</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>lembaga/group-participants">Group Peserta</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>lembaga/participants">Peserta</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-home"></i>Lembaga<small class="text-danger">(Coming Soon)</small></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>lembaga/logout"><i class="zmdi zmdi-power"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->