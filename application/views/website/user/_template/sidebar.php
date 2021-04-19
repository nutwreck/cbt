<!-- Sidebar  -->
<nav id="sidebar">
    <div class="sidebar-header">
        <img src="<?=config_item('_assets_general')?>header_logo/header_logo_user_center.png" alt="logo" width="150">
    </div>

    <ul class="list-unstyled components">
        <!-- <p>Dummy Heading</p> -->
        <li class="active">
            <a href="#"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
        </li>
        <li>
            <a href="#simulasimateri" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-book" aria-hidden="true"></i> Simulasi & Materi</a>
            <ul class="collapse list-unstyled" id="simulasimateri">
                <li>
                    <a href="#">Try Out SBMPTN</a>
                </li>
                <li>
                    <a href="#">Try Out TOEFL</a>
                </li>
                <li>
                    <a href="#">Try Out CPNS</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#pengaturan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-cogs" aria-hidden="true"></i> Pengaturan</a>
            <ul class="collapse list-unstyled" id="pengaturan">
                <li>
                    <a href="#">Akun</a>
                </li>
                <li>
                    <a href="#">History Ujian</a>
                </li>
                <li>
                    <a href="#">Status Pembelian</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="<?=base_url()?>logout">Logout</a>
        </li>
    </ul>
</nav>

<div id="content">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button type="button" id="sidebarCollapse" class="btn btn-info">
                <i class="fas fa-align-left"></i>
                <span>Toggle Sidebar</span>
            </button>

            <div style="margin-top:10px;">
                <h6>Hi, <?=$this->session->userdata('peserta_name')?></h6>
            </div>
        </div>
    </nav>
