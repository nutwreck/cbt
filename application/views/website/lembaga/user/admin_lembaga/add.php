<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Tambah Admin Lembaga</div>
                            <div class="col text-right">
                                <a href="<?=base_url()?>admin/user-lembaga" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                    <form id="formadd" name="formadd" action="<?php echo base_url(); ?>website/lembaga/User/submit_add_user_lembaga" class="form-user-lembaga" method="POST" enctype="multipart/form-data" onsubmit="return(validate_addform());">
                    <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <input type="hidden" id="lembaga_id" name="lembaga_id" value="<?=$lembaga_id?>" style="display: none" required>
                    <input type="hidden" id="role_user_id" name="role_user_id" value="<?=$role_user_id?>" style="display: none" required>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Nama</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="name" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Nama Admin Lembaga" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Email</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="email" name="email" type="email" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Email Admin Lembaga" required>
                                    </div>
                                    <small for="email" id="email_er" class="bg-danger text-white"></small>
                                    <div class="alert alert-info">
                                        <p>
                                            Email juga digunakan sebagai username untuk nantinya ketika login. Pastikan email aktif!
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Password</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="password" name="password" type="password" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Password Admin Lembaga" required>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                    <h5 class="label-text">Foto Profil<br /><small>(Jika Ada)</small></h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file_photo" name="file_photo">
                                            <label id="file-name" class="custom-file-label" for="file_photo">Pilih Foto</label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
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