<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Detail Paket Soal</div>
                            <div class="col text-right">
                                <a href="<?=base_url()?>admin/paket-soal" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                        <form action="" class="form-paket-soal">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Nama Paket Soal</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="name" name="name" readonly type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Ex: Soal Semester Ganjil (SMK Jurusan Bongkar Muat)" value="<?=$paket_soal->nama_paket_soal?>" required>
                                    </div>
                                </div>
                            </div>
                            <?php if(!empty($paket_soal->buku_name)){?>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Buku</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" data-live-search="true" readonly data-width="auto" name="buku" required>
                                            <option value="-1" selected><?=$paket_soal->buku_name?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php } else { echo ''; } ?>
                            <?php if(!empty($paket_soal->buku_name)){?>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.2%">
                                        <h5 class="label-text">Gratis</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="is_free_tidak" name="is_free" required value="0" <?=$paket_soal->is_free == 0 ? 'checked' : 'disabled'?>>
                                                <label class="custom-control-label" for="is_free_tidak">Tidak</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="is_free_ya" name="is_free" required value="1" <?=$paket_soal->is_free == 1 ? 'checked' : 'disabled'?>>
                                                <label class="custom-control-label" for="is_free_ya">Ya</label>
                                            </div>
                                            <label for="is_free" id="text_free"></label>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { echo ''; } ?>
                            <?php if(!empty($paket_soal->detail_buku_name) && !empty($paket_soal->buku_name)){?>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Jurusan</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select id="detail_buku" class="form-control selectpicker" data-live-search="true" data-width="auto" name="detail_buku">
                                                <option value = "-1" selected><?=$paket_soal->detail_buku_name?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { echo ''; } ?>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Kelas</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" data-live-search="true" readonly data-width="auto" name="kelas" required>
                                            <option value="-1" selected><?=$paket_soal->kelas_name?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Materi</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" data-live-search="true" readonly data-width="auto" name="materi" required>
                                            <option value="-1" selected><?=$paket_soal->materi_name?></option>
                                        </select>
                                        <small for="materi" id="materi_er" class="bg-danger text-white"></small>
                                    </div>
                                </div>
                            </div>
                            <hr >
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                    <h5 class="label-text">Mode Jawaban<br /><small>(Untuk Soal Pilihan Ganda)</small></h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" data-live-search="true" readonly data-width="auto" name="mode_jawaban" required>
                                            <option value="-1" selected><?=$paket_soal->nama_mode_jwb?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                    <h5 class="label-text">Acak Soal</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="acak_soal_tidak" name="acak_soal" required value="0" <?=$paket_soal->is_acak_soal == 0 ? 'checked' : 'disabled'?>>
                                        <label class="custom-control-label" for="acak_soal_tidak">Tidak</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="acak_soal_ya" name="acak_soal" required value="1" <?=$paket_soal->is_acak_soal == 1 ? 'checked' : 'disabled'?>>
                                        <label class="custom-control-label" for="acak_soal_ya">Ya</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                    <h5 class="label-text">Acak Jawaban</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="acak_jawaban_tidak" name="acak_jawaban" required value="0" <?=$paket_soal->is_acak_jawaban == 0 ? 'checked' : 'disabled'?>>
                                        <label class="custom-control-label" for="acak_jawaban_tidak">Tidak</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="acak_jawaban_ya" name="acak_jawaban" required value="1" <?=$paket_soal->is_acak_jawaban == 1 ? 'checked' : 'disabled'?>>
                                        <label class="custom-control-label" for="acak_jawaban_ya">Ya</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="display:none">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Skala Penilaian</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" readonly data-live-search="true" data-width="auto" name="skala_nilai" required>
                                            <option value="-1" selected><?=$paket_soal->detail_nama_pengaturan_universal?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Skor Bila Tidak Menjawab</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="skor_tdk_jwb" name="skor_tdk_jwb" readonly type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?=$paket_soal->skor_null?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                    <h5 class="label-text">Pengerjaan Continous</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="continous_tidak" name="continous" value="0" required <?=$paket_soal->is_continuous == 0 ? 'checked' : 'disabled'?>>
                                        <label class="custom-control-label" for="continous_tidak">Tidak</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="continous_ya" name="continous" required value="1" <?=$paket_soal->is_continuous == 1 ? 'checked' : 'disabled'?>>
                                        <label class="custom-control-label" for="continous_ya">Ya</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                    <h5 class="label-text">Harus Menjawab</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="menjawab_tidak" name="menjawab" value="0" required <?=$paket_soal->is_jawab == 0 ? 'checked' : 'disabled'?>>
                                        <label class="custom-control-label" for="menjawab_tidak">Tidak</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="menjawab_ya" name="menjawab" required value="1" <?=$paket_soal->is_jawab == 1 ? 'checked' : 'disabled'?>>
                                        <label class="custom-control-label" for="menjawab_ya">Ya</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Batas Pemutaran Audio</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="audio_limit" name="audio_limit" readonly type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?=$paket_soal->visual_limit?>" required>
                                    </div>
                                </div>
                            </div>
                            <hr >
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Petunjuk Pengerjaan<br /><small>(Bila Diperlukan)</small></h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <textarea class="summernote note-math-dialog" id="summernote" rows='10' readonly><?=$paket_soal->petunjuk?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                    <h5 class="label-text">Lampiran Audio<br /><small>(Berisi Petunjuk Pengerjaan)</small></h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="petunjuk_audio" value="<?=$paket_soal->lampiran_petunjuk?>">
                                            <label id="file-name" class="custom-file-label" for="petunjuk_audio">Pilih Audio</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>