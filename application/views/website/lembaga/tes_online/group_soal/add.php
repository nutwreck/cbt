<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Tambah Group Soal</div>
                            <div class="col text-right">
                                <a href="<?=base_url()?>admin/group-soal/<?=$id_paket_soal?>" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                        <form id="formadd" name="formadd" action="<?php echo base_url(); ?>website/lembaga/Tes_online/submit_add_group_soal" class="form-group" method="POST" enctype="multipart/form-data" onsubmit="return(validate_addform());">
                        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                        <input type="hidden" id="id_paket_soal" name="id_paket_soal" value="<?=$id_paket_soal?>" style="display: none" required>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Nama Group</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="name" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Nama Group Soal" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Kode Group</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="kode_group" name="kode_group" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Kode Group Soal" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Petunjuk</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <textarea class="summernote note-math-dialog" id="summernote" name="petunjuk" rows='10'></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Audio Group</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="audio_group" name="audio_group">
                                                <label id="file-name" class="custom-file-label" for="audio_group">Pilih Audio</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Konversi Skor</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select class="form-control selectpicker" data-live-search="true" data-width="auto" name="konversi_skor_id" required>
                                                <option value = "0" selected>Pilih</option>
                                                <?php foreach($konversi_skor as $val_konversi){ ?>
                                                    <option data-tokens="<?=$val_konversi->name?>" value="<?=$val_konversi->id?>"><?=$val_konversi->name?></option>
                                                <?php } ?>
                                            </select>
                                            <small for="konversi_skor_id" id="konversi_skor_id_er" class="bg-danger text-white"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Parent Group</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select class="form-control selectpicker" data-live-search="true" data-width="auto" name="parent_id" required>
                                                <option value = "0" selected>Pilih</option>
                                                <?php foreach($parent_group as $val_parent){ ?>
                                                    <option data-tokens="<?=$val_parent->name?>" value="<?=$val_parent->id?>"><?=$val_parent->name?></option>
                                                <?php } ?>
                                            </select>
                                            <small for="parent_id" id="parent_id_er" class="bg-danger text-white"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="display:none;">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Continuous</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="is_continuous_tidak" name="is_continuous" required value="0" checked>
                                            <label class="custom-control-label" for="is_continuous_tidak">Tidak</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="is_continuous_ya" name="is_continuous" required value="1">
                                            <label class="custom-control-label" for="is_continuous_ya">Ya</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
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