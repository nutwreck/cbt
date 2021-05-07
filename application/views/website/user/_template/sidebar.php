<!-- Sidebar  -->
<nav id="sidebar">
    <div class="sidebar-header">
        <img src="<?=config_item('_assets_general')?>header_logo/header_logo_user_center.png" alt="logo" width="150">
    </div>

    <ul class="list-unstyled components">
        <!-- <p>Dummy Heading</p> -->
        <li class="active">
            <a href="<?=base_url()?>dashboard"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
        </li>
        <li>
            <a href="<?=base_url()?>history"><i class="fa fa-database" aria-hidden="true"></i> History & Pembahasan</a>
        </li>
        <li>
            <a href="#simulasimateri" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-book" aria-hidden="true"></i> Buku</a>
            <ul class="collapse list-unstyled" id="simulasimateri">
                <li>
                    <a href="<?=base_url()?>buku/sbmptn/launch">SBMPTN</a>
                </li>
                <li>
                    <a href="<?=base_url()?>buku/toefl/launch">TOEFL</a>
                </li>
                <li>
                    <a href="<?=base_url()?>buku/cpns/launch">CPNS</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="<?=base_url()?>account"><i class="fa fa-user" aria-hidden="true"></i> Akun</a>
        </li>
        <li>
            <a href="<?=base_url()?>purchase"><i class="fa fa-list" aria-hidden="true"></i> Status Pembelian</a>
        </li>
        <li>
            <a href="<?=base_url()?>logout"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
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
