<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Tambah Paket Soal</div>
                            <div class="col text-right">
                                <a href="<?=base_url()?>admin/paket-soal" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                        <form id="formadd" name="formadd" action="<?php echo base_url(); ?>website/lembaga/Tes_online/submit_add_paket_soal" class="form-paket-soal" method="POST" enctype="multipart/form-data" onsubmit="return(validate_addform());">
                        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Nama Paket Soal</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="name" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Ex: Soal Semester Ganjil (SMK Jurusan Bongkar Muat)" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Tipe Paket</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select id="type_paket" class="form-control selectpicker" data-live-search="true" data-width="auto" name="type_paket" required onchange="choosen_type_paket()">
                                                <option value = "-1" selected>Pilih</option>
                                                <?php foreach($get_type_paket as $val_type_paket){ ?>
                                                    <option data-tokens="<?=$val_type_paket->name?>" value="<?=$val_type_paket->id?>|<?=$val_type_paket->name?>"><?=$val_type_paket->name?></option>
                                                <?php } ?>
                                            </select>
                                            <small for="type_paket" id="type_paket_er" class="bg-danger text-white"></small>
                                            <div class="alert alert-info mt-2">
                                                <p>
                                                    Jika paket yang akan dibuat untuk <b>keperluan ujian</b>, pilih <b>ujian</b> kemudian nantinya anda perlu setting <b>sesi pelaksanaannya</b>, Jika paket yang dibuat untuk <b>keperluan buku</b> maka pilih buku dan tidak perlu setting <b>sesi pelaksanaan</b>, jika paket yang anda buat untuk <b>ujian dan buku</b> pilih <b>Fleksible</b> dan tetap mengatur sesi pelaksanaannya untuk ujian.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="buku_pilih" style="display:none;">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                            <h5 class="label-text">Buku</h5>
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <select id="buku" class="form-control selectpicker" data-live-search="true" data-width="auto" name="buku" onchange="choosen_buku()">
                                                    <option value = "0" selected>Pilih</option>
                                                    <?php foreach($get_buku as $val_buku){ ?>
                                                        <option data-tokens="<?=$val_buku->name?>" value="<?=$val_buku->id?>|<?=$val_buku->name?>"><?=$val_buku->name?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="free_buku" style="display:none;">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3" style="margin-top:0.2%">
                                            <h5 class="label-text">Gratis</h5>
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="is_free_tidak" name="is_free" required value="0" checked>
                                                    <label class="custom-control-label" for="is_free_tidak">Tidak</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="is_free_ya" name="is_free" required value="1">
                                                    <label class="custom-control-label" for="is_free_ya">Ya</label>
                                                </div>
                                                <label for="is_free" id="text_free"></label>
                                            </div>
                                            <div class="alert alert-info">
                                                <p>
                                                    Jika memilih Ya, Maka paket ini akan ditampilkan sebagai paket buku gratis dihalaman user.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="detail_buku_pilih" style="display:none;">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                            <h5 class="label-text">Jurusan</h5>
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <select id="detail_buku" class="form-control selectpicker" data-live-search="true" data-width="auto" name="detail_buku">
                                                    <option value = "0" selected>Pilih</option>
                                                    <?php foreach($get_detail_buku as $val_detail_buku){ ?>
                                                        <option data-tokens="<?=$val_detail_buku->name?>" value="<?=$val_detail_buku->id?>|<?=$val_detail_buku->name?>"><?=$val_detail_buku->name?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Kelas</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select class="form-control selectpicker" data-live-search="true" data-width="auto" name="kelas" required>
                                                <option value = "-1" selected>Pilih</option>
                                                <?php foreach($get_kelas as $val_kelas){ ?>
                                                    <option data-tokens="<?=$val_kelas->description?>" value="<?=$val_kelas->kelas_id?>|<?=$val_kelas->description?>"><?=$val_kelas->description?></option>
                                                <?php } ?>
                                            </select>
                                            <small for="kelas" id="kelas_er" class="bg-danger text-white"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Materi</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select class="form-control selectpicker" data-live-search="true" data-width="auto" name="materi" required>
                                                <option value = "-1" selected>Pilih</option>
                                                <?php foreach($get_materi as $val_materi){ ?>
                                                    <option data-tokens="<?=$val_materi->name?>" value="<?=$val_materi->id?>|<?=$val_materi->name?>"><?=$val_materi->name?></option>
                                                <?php } ?>
                                            </select>
                                            <small for="materi" id="materi_er" class="bg-danger text-white"></small>
                                        </div>
                                        <div class="alert alert-info">
                                            <p>
                                                Jika ingin menambah <b>materi</b> <a href="<?php echo base_url(); ?>lembaga/add-materi" target="_blank">Klik Disini</a>.
                                            </p>
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
                                            <select class="form-control selectpicker" data-live-search="true" data-width="auto" name="mode_jawaban" required>
                                                <option value = "-1" selected>Pilih</option>
                                                <?php foreach($get_mode_jawaban as $val_mode_jwb){ ?>
                                                    <option data-tokens="<?=$val_mode_jwb->name?>" value="<?=$val_mode_jwb->id?>"><?=$val_mode_jwb->name?></option>
                                                <?php } ?>
                                            </select>
                                            <small for="mode_jawaban" id="mode_jawaban_er" class="bg-danger text-white"></small>
                                        </div>
                                        <div class="alert alert-info">
                                            <p>
                                                Konfigurasi <b>mode jawaban</b> yang perlu disetting jika nantinya memerlukan soal tipe <b>pilihan ganda</b>. Jika memilih <b>FLEXIBLE</b> pilihan jawaban bisa diatur sendiri maksimal sampai pilihan jawaban <b>"J"</b>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Acak Soal</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="acak_soal_tidak" name="acak_soal" required value="0" checked>
                                                <label class="custom-control-label" for="acak_soal_tidak">Tidak</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="acak_soal_ya" name="acak_soal" required value="1">
                                                <label class="custom-control-label" for="acak_soal_ya">Ya</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Acak Jawaban</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="acak_jawaban_tidak" name="acak_jawaban" required value="0" checked>
                                                <label class="custom-control-label" for="acak_jawaban_tidak">Tidak</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="acak_jawaban_ya" name="acak_jawaban" required value="1">
                                                <label class="custom-control-label" for="acak_jawaban_ya">Ya</label>
                                            </div>
                                            <div class="alert alert-info">
                                                <p>
                                                    Pemilihan acak soal & jawaban diatas jika ya maka akan <b>dirandom secara default oleh sistem</b>. Anda tetap <b>harus memilih soal / jawaban yang akan diacak</b> saat pembuatan soal nantinya.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Skala Penilaian</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select class="form-control selectpicker" data-live-search="true" data-width="auto" name="skala_nilai">
                                                <option value = "-1" selected>Pilih</option>
                                                <?php foreach($get_skala_nilai as $val_skala_nilai){ ?>
                                                    <option data-tokens="<?=$val_skala_nilai->detail?>" value="<?=$val_skala_nilai->id?>"><?=$val_skala_nilai->detail?></option>
                                                <?php } ?>
                                            </select>
                                            <small for="skala_nilai" id="skala_nilai_er" class="bg-danger text-white"></small>
                                        </div>
                                        <div class="alert alert-info">
                                            <p>
                                                Jika anda memilih skala penilaian <b>sesuai skor total</b>, maka anda perlu menambahkan skor pada jawaban benar. Jika memilih <b>skala 100</b> maka perhitungan skor pada jawaban benar akan otomatis dihitung proporsional dari total jumlah soal. <b>(Total Skor / 3) x 10</b> jika anda memilih untuk tes TOEFL tetapi <b>Penyusunan Group Soal</b> harus diperhatikan.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Skor Bila Tidak Menjawab</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="skor_tdk_jwb" name="skor_tdk_jwb" type="text" class="form-control" aria-required="true" aria-invalid="false" value="0" required>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Pengerjaan Continous</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="continous_tidak" name="continous" value="0" required checked>
                                            <label class="custom-control-label" for="continous_tidak">Tidak</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="continous_ya" name="continous" required value="1">
                                            <label class="custom-control-label" for="continous_ya">Ya</label>
                                        </div>
                                        <div class="alert alert-info">
                                            <p>
                                                <b>Continous</b> artinya peserta tidak boleh bolak balik dalam mengerjakan soal, jika anda memilih ya maka peserta wajib menjawab soal urut dari no 1 sampai akhir soal selesai.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Harus Menjawab</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="menjawab_tidak" name="menjawab" value="0" required checked>
                                            <label class="custom-control-label" for="menjawab_tidak">Tidak</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="menjawab_ya" name="menjawab" required value="1">
                                            <label class="custom-control-label" for="menjawab_ya">Ya</label>
                                        </div>
                                        <div class="alert alert-info">
                                            <p>
                                                Jika anda memilih ya, maka peserta ujian <b>wajib menjawab semua soal</b> sebelum submit selesai.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Batas Pemutaran Audio</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="audio_limit" name="audio_limit" type="text" class="form-control" aria-required="true" aria-invalid="false" value="0" required>
                                        </div>
                                        <div class="alert alert-info">
                                            <p>
                                                Tentukan batas pemutaran audio jika nantinya anda akan menggunakan <b>soal jenis audio</b>. <b>Biarkan 0</b> jika tidak ada batas pemutaran audio.
                                            </p>
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
                                            <textarea class="summernote note-math-dialog" id="summernote" name="petunjuk_text" rows='10'></textarea>
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
                                                <input type="file" class="custom-file-input" id="petunjuk_audio">
                                                <label id="file-name" class="custom-file-label" for="petunjuk_audio">Pilih Audio</label>
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