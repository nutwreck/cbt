<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Edit Soal</div>
                            <div class="col text-right">
                                <button class="btn btn-sm btn-outline-secondary" onclick="return window.history.back();">Kembali</button>
                            </div>
                        </div>
                    </div>
                        <form id="formedit" name="formedit" action="<?php echo base_url(); ?>website/lembaga/Tes_online/submit_edit_soal" class="form-soal" method="POST" enctype="multipart/form-data" onsubmit="return(validate_editform());">
                        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                        <input type="hidden" id="id_paket_soal" name="id_paket_soal" value="<?=$id_paket_soal?>" style="display: none" required>
                        <input type="hidden" id="id_bank_soal" name="id_bank_soal" value="<?=$id_bank_soal?>" style="display: none" required>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Nomor Soal</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="no_soal" name="no_soal" type="text" readonly class="form-control" aria-required="true" aria-invalid="false" value="<?=$nomor_soal?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Jenis Soal</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select id="pilihan_jenis_soal" class="form-control selectpicker" data-live-search="true" data-width="auto" name="jenis_soal" required>
                                                <option value="<?=$soal_detail->group_mode_jwb_id?>" selected><?=$soal_detail->group_mode_jwb_name?></option>
                                                <?php foreach($jenis_soal as $val_jenis_soal){ ?>
                                                    <option data-tokens="<?=$val_jenis_soal->name?>" value="<?=$val_jenis_soal->id?>"><?=$val_jenis_soal->name?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Soal</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <textarea class="summernote note-math-dialog" id="summernote" name="soal" rows='10'><?=$soal_detail->bank_soal_name?></textarea>
                                        </div>
                                        <small id="soal_er" class="bg-danger text-white"></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Kata Kunci</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="kata_kunci" name="kata_kunci" type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?=$soal_detail->kata_kunci?>" placeholder="Ex : matriks, vector, determinan (Pisahkan dengan tanda koma)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Tingkat Kesulitan</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select class="form-control selectpicker" data-live-search="true" data-width="auto" name="tipe_kesulitan" required>
                                                <option value="<?=$soal_detail->tipe_kesulitan_id?>" selected><?=$soal_detail->tipe_kesulitan_name?></option>
                                                <?php foreach($tipe_kesulitan as $val_kesulitan){ ?>
                                                    <option data-tokens="<?=$val_kesulitan->name?>" value="<?=$val_kesulitan->id?>"><?=$val_kesulitan->name?></option>
                                                <?php } ?>
                                            </select>
                                            <small for="tipe_kesulitan" id="tipe_kesulitan_er" class="bg-danger text-white"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Lampiran Audio<br /><small>(Berisi Soal)</small></h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="hidden" id="old_name_audio" name="old_name_audio" value="<?=$soal_detail->file?>" style="display: none">
                                                <input type="hidden" id="old_type_audio" name="old_type_audio" value="<?=$soal_detail->tipe_file?>" style="display: none">
                                                <input type="file" class="custom-file-input" id="soal_audio" name="soal_audio">
                                                <label id="file-name" class="custom-file-label" for="soal_audio">Pilih Audio</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Acak Soal</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="acak_soal_tidak" name="acak_soal" required value="0" <?=$soal_detail->is_acak_soal == 0 ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="acak_soal_tidak">Tidak</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="acak_soal_ya" name="acak_soal" required value="1" <?=$soal_detail->is_acak_soal == 1 ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="acak_soal_ya">Ya</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="content_acak_jawaban_head" class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Acak Jawaban</h5>
                                    </div>
                                    <div id="content_acak_jawaban_body" class="col-sm-12 col-lg-9">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="acak_jawaban_tidak" name="acak_jawaban" required value="0" <?=$soal_detail->is_acak_jawaban == 0 ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="acak_jawaban_tidak">Tidak</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="acak_jawaban_ya" name="acak_jawaban" required value="1" <?=$soal_detail->is_acak_jawaban == 1 ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="acak_jawaban_ya">Ya</label>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div id="content_jawaban" class="row" style="display:block;">
                                    <div class="col-sm-12">
                                    <table class="table table-bordered table-responsive">
                                        <thead class="table-primary text-center">
                                            <th width="7%">Opsi</th>
                                            <th width="7%">Pilih Jawaban</th>
                                            <th>Jawaban</th>
                                            <th width="7%">Skor</th>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $alpha = config_item('_def_opsi_jawaban');
                                            $key = config_item('_def_opsi_urutan');
                                            foreach ($jawaban_detail as $val_jawaban) {
                                        ?>
                                            <input type="hidden" id="id_jawaban<?=$key?>" name="id_jawaban[]" value="<?=$val_jawaban->id?>" style="display: none">
                                            <tr>
                                                <td class="text-center font-weight-bold"><?=$alpha++?></td>
                                                <td class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input position-static" type="radio" name="tanda_jawaban" value="<?=$key?>" id="blankRadio<?=$key?>" <?=$val_jawaban->is_key == 1 ? 'checked' : ''?>>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <textarea class="summernote note-math-dialog" id="summernote<?=$key?>" name="jawaban[]" rows='10'><?=$val_jawaban->name?></textarea>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-group">
                                                        <input id="skor_jawaban<?=$key?>" name="skor_jawaban[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?=$val_jawaban->score?>" required>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php $key++; } ?>
                                        </tbody>
                                    </table>
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