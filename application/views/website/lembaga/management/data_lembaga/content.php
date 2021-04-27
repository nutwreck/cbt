<!-- MAIN CONTENT-->
<?php
foreach($data_lembaga as $value){
    $lembaga_id = $value->lembaga_id;
    $lembaga_name = $value->lembaga_name;
    $lembaga_type_id = $value->lembaga_type_id;
    $lembaga_type_name = $value->lembaga_type_name;
    $lembaga_email = $value->lembaga_email;
    $lembaga_alamat = $value->lembaga_alamat;
    $lembaga_phone = $value->lembaga_phone;
    $lembaga_kota_kab_id = $value->lembaga_kota_kab_id;
    $lembaga_kota_kab = $value->lembaga_kota_kab;
    $informasi = $value->informasi;
}
?>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Data Lembaga</div>
                        </div>
                    </div>
                    <form id="formdata" name="formdata" action="<?php echo base_url(); ?>website/lembaga/Management/submit_edit_data_lembaga" class="form-data-lembaga" method="POST" enctype="multipart/form-data" onsubmit="return(validate_form());">
                    <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <input type="hidden" id="lembaga_id" name="lembaga_id" value="<?=$lembaga_id?>" style="display: none" required>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Nama Lembaga</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="name" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Nama Lembaga" value="<?=$lembaga_name?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Tipe Lembaga</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" data-live-search="true" data-width="auto" name="lembaga_type_id" required>
                                            <option value = "<?=$lembaga_type_id?>" selected><?=$lembaga_type_name?></option>
                                            <?php foreach($get_type_lembaga as $val_type_lembaga){ ?>
                                                <option data-tokens="<?=$val_type_lembaga->name?>" value="<?=$val_type_lembaga->id?>"><?=$val_type_lembaga->name?></option>
                                            <?php } ?>
                                        </select>
                                        <small for="lembaga_type_id" id="lembaga_type_id_er" class="bg-danger text-white"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">No Telp Lembaga</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="no_telp" name="no_telp" type="number" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan No Telp Lembaga" value="<?=$lembaga_phone?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Email</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="email" name="email" type="email" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Email Data Lembaga" value="<?=$lembaga_email?>" required>
                                    </div>
                                    <small for="email" id="email_er" class="bg-danger text-white"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Alamat Lembaga</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <textarea class="summernote note-math-dialog" id="alamat" name="alamat" rows='5'><?=$lembaga_alamat?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Kota/Kab Lembaga</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" data-live-search="true" data-width="auto" name="kota_kab_id" required>
                                            <option value = "<?=$lembaga_kota_kab_id?>|<?=$lembaga_kota_kab?>" selected><?=$lembaga_kota_kab?></option>
                                            <?php foreach($get_kota_kab as $val_kota_kab){ ?>
                                                <option data-tokens="<?=$val_kota_kab->name?>" value="<?=$val_kota_kab->id?>|<?=$val_kota_kab->name?>"><?=$val_kota_kab->name?></option>
                                            <?php } ?>
                                        </select>
                                        <small for="kota_kab_id" id="kota_kab_id_er" class="bg-danger text-white"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Informasi Lembaga<br /><small>(Bila Diperlukan)</small></h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <textarea class="summernote note-math-dialog" id="informasi" name="informasi" rows='5'><?=$informasi?></textarea>
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