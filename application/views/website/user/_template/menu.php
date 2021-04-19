<nav class="navbar fixed-top navbar-expand-md custom-navbar navbar-dark">
    <!-- 324x112dp -->
    <img class="navbar-brand" src="https://see.fontimg.com/api/renderfont4/BW768/eyJyIjoiZnMiLCJoIjo2NCwidyI6MTAwMCwiZnMiOjY0LCJmZ2MiOiIjMUVBREZGIiwiYmdjIjoiI0ZGRkZGRiIsInQiOjF9/dWppYW4gb25saW5l/gv-time-regular.png" id="logo_custom" width="10%"  alt="logo">
    <button class="navbar-toggler navbar-toggler-right custom-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon "></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>dashboard"><i class="fa fa-home" aria-hidden="true"></i> <b>Dashboard</b></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#"><i class="fa fa-keyboard-o" aria-hidden="true"></i> <b>Simulasi dan Materi</b> </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"> SBMPTN</a></li>
                    <li><a class="dropdown-item" href="#"> TOEFL</a></li>
                    <li><a class="dropdown-item" href="#"> CPNS</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>history"><i class="fa fa-history" aria-hidden="true"></i> <b>Histori Ujian</b></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#"><i class="fa fa-user" aria-hidden="true"></i> <b>Akun</b> </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"> Manajemen Akun</a></li>
                    <li><a class="dropdown-item" href="#"> Status Pembayaran</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=base_url()?>logout"><i class="fa fa-sign-out" aria-hidden="true"></i> <b>Keluar</b></a>
            </li>
        </ul>
    </div>  
</nav>