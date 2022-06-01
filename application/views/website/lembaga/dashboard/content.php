 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">overview</h2>
                        </div>
                    </div>
                </div>
                <div class="row m-t-25">
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c1">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-book-image"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?php echo $total_paket_soal->total_paket_soal; ?></h2>
                                        <span>Paket Soal</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c3">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-account-o"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?php echo $total_peserta->total_peserta; ?></h2>
                                        <span>Peserta</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c4">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-flag"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?php echo $total_event->total_event; ?></h2>
                                        <span>Event</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="close_info()">×</button>
                            <span class="glyphicon glyphicon-info-sign"></span><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Informasi</strong>
                            <hr class="message-inner-separator">
                            <p>
                                Selamat datang, <b><?=ucwords($this->session->userdata('lembaga_user_name'))?></b> di aplikasi admin ujian online.
                            </p>
                        </div>
                    </div>
                </div>
