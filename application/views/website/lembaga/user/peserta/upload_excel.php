
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Upload Data Peserta</div>
                            <div class="col text-right">
                                <a href="<?=base_url()?>admin/participants" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                    <form action="<?php echo base_url(); ?>website/lembaga/User/submit_upload_add_peserta" class="form-group-peserta" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <input type="hidden" id="role_user_id" name="role_user_id" value="<?=$role_user_id?>" style="display: none" required>
                    <input type="hidden" id="lembaga_id" name="lembaga_id" value="<?=$lembaga_id?>" style="display: none" required>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                    <h5 class="label-text">Upload</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="data_peserta" name="data_peserta">
                                            <label id="file-name" class="custom-file-label" for="data_peserta">Pilih Excel</label>
                                        </div>
                                    </div>
                                    <div class="alert alert-info">
                                        <p>
                                            Untuk upload data peserta menggunakan excel silahkan download <a href="<?=config_item('_assets_website')?><?=$file_template->param?>" class="btn btn-sm btn-success">Template Excel</a> terlebih dahulu dan input sesuai ketentuan. Pastikan tidak ada data duplikat.
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