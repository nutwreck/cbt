<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Tambah Peserta Sesi Pelaksanaan</div>
                            <div class="col text-right">
                                <a href="<?=base_url()?>admin/sesi-pelaksana" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                        <form id="formadd" name="formadd" action="<?php echo base_url(); ?>website/lembaga/Tes_online/submit_add_peserta_sesi_pelaksana" class="form-sesi-pelaksana" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                        <input type="hidden" id="id_sesi_pelaksana" name="id_sesi_pelaksana" value="<?=$id_sesi_pelaksana?>" style="display: none">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Mode Peserta</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="mode_peserta_kelompok" name="mode_peserta" required value="1" checked onchange="kelompok_function()">
                                                <label class="custom-control-label" for="mode_peserta_kelompok">Kelompok Peserta</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="mode_peserta_manual" name="mode_peserta" required value="2" onchange="manual_function()">
                                                <label class="custom-control-label" for="mode_peserta_manual">Pilih Manual</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="kelompok_peserta" style="display: block;">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                            <h5 class="label-text">Kelompok Peserta</h5>
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <select id="group_peserta_id" class="form-control selectpicker dropup" data-header="Pilih Kelompok Soal" data-live-search="true" data-width="auto" name="group_peserta_id[]" multiple>
                                                    <?php foreach($group_peserta as $val_group_peserta){ ?>
                                                        <option data-tokens="<?=$val_group_peserta->group_peserta_name?>" value="<?=$val_group_peserta->group_peserta_id?>"><?=$val_group_peserta->group_peserta_name?> (<?=$val_group_peserta->jumlah_peserta?> Peserta)</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="manual_peserta" style="display: none;">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                            <h5 class="label-text">Pilih Peserta</h5>
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <select name="manual_peserta_id[]" id="manual_peserta_id" class="form-control select2" multiple>
                                                    <option value='0'></option>
                                                </select>
                                            </div>
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