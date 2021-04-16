<!-- MAIN CONTENT-->
<div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div id="info_user" class="col-sm-12 col-lg-6">
                                <div class="row mt-3 ml-0 mr-0 mb-0">
                                    <div class="col-sm-12">
                                        <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="close_info()">×</button>
                                            <span class="glyphicon glyphicon-info-sign"></span><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Informasi</strong>
                                            <hr class="message-inner-separator">
                                            <p>
                                                Pembeda tingkatan (<b>SD, SMP, SMA, Dll</b>) bisa diinput saat pembuatan <b>paket soal</b>.<br />
                                                Untuk itu <b>penamaan materi</b> tidak perlu dicantumkan <b>nama tingkatannya</b>.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="content_add" class="col-sm-12 col-lg-6">
                                <div class="card">
                                    <div class="card-header">Tambah Materi</div>
                                    <div class="card-body">
                                        <form id="formadd" name="formadd" action="<?php echo base_url(); ?>website/lembaga/Tes_online/submit_add_materi" method="post" onsubmit = "return(validate_addform());">
                                        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                            <div class="form-group">
                                                <label for="materi" class="control-label mb-1">Nama Materi</label>
                                                <small for="materi" id="materi_er" class="bg-danger text-white"></small>
                                                <input id="materi" name="materi" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan nama materi">
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-lg btn-info btn-block">
                                                    <i class="fa fa-check fa-md"></i>&nbsp;
                                                    <span>Submit</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>