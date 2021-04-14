
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Upload Data Detail Konversi</div>
                            <div class="col text-right">
                                <button class="btn btn-sm btn-outline-secondary" onclick="return window.history.back();">Kembali</button>
                            </div>
                        </div>
                    </div>
                    <form action="<?php echo base_url(); ?>website/lembaga/Management/submit_import_detail_konversi" class="form-konversi-peserta" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <input type="hidden" id="id_konversi" name="id_konversi" value="<?=$id_konversi?>" style="display: none" required>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                    <h5 class="label-text">Upload</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="data_konversi" name="data_konversi">
                                            <label id="file-name" class="custom-file-label" for="data_konversi">Pilih Excel</label>
                                        </div>
                                    </div>
                                    <div class="alert alert-info">
                                        <p>
                                            Untuk upload data konversi menggunakan excel silahkan download <a href="<?=config_item('_assets_website')?><?=$file_template->param?>" class="btn btn-sm btn-success">Template Excel</a> terlebih dahulu.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 offset-sm-3">
                                    <button type="submit" class="btn btn-md btn-info btn-block">
                                        <i class="fa fa-check fa-md"></i>&nbsp;
                                        <span>Submit</span>
                                    </button>
                                    <br />
                                    <span><?=$message?></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>