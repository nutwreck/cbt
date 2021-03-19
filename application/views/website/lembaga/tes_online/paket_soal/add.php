<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">Tambah Paket Soal</div>
                        <form action="<?php echo base_url(); ?>website/lembaga/Tes_online/submit_add_materi" method="post" novalidate="novalidate">
                        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.7%">
                                        <h4 class="text-right">Nama Paket Soal</h4>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="paket_soal_name" name="paket_soal_name" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Ex: Soal Semester Ganjil (SMK Jurusan Bongkar Muat)" required>
                                        </div>
                                        <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="close_info()">×</button>
                                            <span class="glyphicon glyphicon-info-sign"></span><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Informasi</strong>
                                            <hr class="message-inner-separator">
                                            <p>
                                                Pembeda jurusan (<b>SD, SMP, SMA, Dll</b>) bisa diinput saat pembuatan <b>paket soal</b>.<br />
                                                Untuk itu <b>penamaan materi</b> tidak perlu dicantumkan <b>nama jurusannya</b>.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.7%">
                                        <h4 class="text-right">Kelas</h4>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select class="selectpicker" data-live-search="true" data-width="auto" required>
                                                <option data-tokens="">Pilih</option>
                                                <option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>
                                                <option data-tokens="mustard">Burger, Shake and a Smile</option>
                                                <option data-tokens="frosting">Sugar, Spice and all things nice</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.7%">
                                        <h4 class="text-right">Materi</h4>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select class="selectpicker" data-live-search="true" data-width="auto" required>
                                                <option data-tokens="">Pilih</option>
                                                <option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>
                                                <option data-tokens="mustard">Burger, Shake and a Smile</option>
                                                <option data-tokens="frosting">Sugar, Spice and all things nice</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 offset-sm-3">
                                        <button type="submit" class="btn btn-md btn-info btn-block">
                                            <i class="fa fa-check fa-md"></i>&nbsp;
                                            <span>Submit</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>