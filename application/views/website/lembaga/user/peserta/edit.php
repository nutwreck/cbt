<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Edit Peserta</div>
                            <div class="col text-right">
                                <a href="<?=base_url()?>admin/participants" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                    <form action="<?php echo base_url(); ?>website/lembaga/User/submit_edit_peserta" class="form-group-peserta" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <input type="hidden" id="lembaga_id" name="lembaga_id" value="<?=$id_lembaga?>" style="display: none" required>
                    <input type="hidden" id="peserta_id" name="peserta_id" value="<?=$id_peserta?>" style="display: none" required>
                    <input type="hidden" id="user_id" name="user_id" value="<?=$id_user?>" style="display: none" required>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Kelompok Peserta</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" data-live-search="true" data-width="auto" name="group_peserta">
                                            <option data-tokens="<?=$participants->group_peserta_name != '' ? $participants->group_peserta_name : 'Pilih'?>" value="<?=$participants->group_peserta_id != 0 ? $participants->group_peserta_id : 0?>" selected><?=$participants->group_peserta_name != '' ? $participants->group_peserta_name : 'Pilih'?></option>
                                            <?php foreach($group_peserta as $val_group_peserta){ ?>
                                                <option data-tokens="<?=$val_group_peserta->name?>" value="<?=$val_group_peserta->id?>"><?=$val_group_peserta->name?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="alert alert-info">
                                        <p>
                                            Kelompok peserta boleh tidak dipilih jika anda tidak memerlukan pengelompokan peserta, Jika ingin menambah Kelompok Peserta klik <a href="<?=base_url()?>admin/add-group-participants" class="btn btn-sm btn-primary">Disini</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Nomor Peserta</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="no_peserta" name="no_peserta" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Nomor Peserta" value="<?=$participants->no_peserta?>" required oninput="this.value = this.value.replace(/[^A-Za-z0-9.-]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    </div>
                                    <div class="alert alert-info">
                                        <p>
                                            Pastikan tidak ada nomor peserta yang sama dari semua peserta yang ada di list anda
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Nama Peserta</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="nama_peserta" name="nama_peserta" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Nama Peserta" value="<?=$participants->peserta_name?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Email Peserta</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="email_peserta" name="email_peserta" type="email" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Email Peserta" value="<?=$participants->username?>">
                                    </div>
                                    <div class="alert alert-info">
                                        <p>
                                            Jika email dikosongkan maka akan dibuatkan otomatis oleh sistem
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Password Peserta</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="password" name="password" type="password" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Password Peserta" value="<?=$password?>">
                                    </div>
                                    <div class="alert alert-info">
                                        <p>
                                            Jika password dikosongkan maka akan dibuatkan otomatis oleh sistem
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
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>