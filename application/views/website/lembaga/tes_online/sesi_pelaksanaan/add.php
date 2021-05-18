<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Tambah Sesi Pelaksanaan</div>
                            <div class="col text-right">
                                <a href="<?=base_url()?>admin/paket-sesi-pelaksana" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                        <form id="formadd" name="formadd" action="<?php echo base_url(); ?>website/lembaga/Tes_online/submit_add_sesi_pelaksana" class="form-sesi-pelaksana" method="POST" enctype="multipart/form-data" onsubmit="return(validate_addform());">
                        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                        <input type="hidden" id="id_paket_soal" name="id_paket_soal" value="<?=$id_paket_soal?>" style="display: none">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Pilihan Paket Soal</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <h5>
                                                <?=$paket_soal->nama_paket_soal?><br />
                                                Materi <?=$paket_soal->materi_name?> <?=$paket_soal->kelas_name?><br />
                                                Jumlah Soal <?=$paket_soal->total_soal?>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Keterangan Sesi</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <textarea class="form-control" rows="4" cols="50" name="name" placeholder="Ex : Sesi Ujian Fisika Kelas 12 IPA" required></textarea>
                                        </div>
                                    </div>
                                </div>
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
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Waktu Mulai</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input type="text" class="form-control datetimepicker-input" id="datetimepicker5" data-toggle="datetimepicker" data-target="#datetimepicker5" name="waktu_mulai" placeholder="Pilih tanggal dan waktu" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Lama Pengerjaan</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="lama_pengerjaan" name="lama_pengerjaan" type="number" class="form-control" aria-required="true" aria-invalid="false" placeholder="Menit" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Waktu Berakhir Fleksible</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="is_fleksible_tidak" name="is_fleksible" required value="0" checked onchange="fleksible_tidak()">
                                                <label class="custom-control-label" for="is_fleksible_tidak">Tidak</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="is_fleksible_ya" name="is_fleksible" required value="1" onchange="fleksible_ya()">
                                                <label class="custom-control-label" for="is_fleksible_ya">Ya</label>
                                            </div>
                                        </div>
                                        <div class="alert alert-info">
                                            <p>
                                                Waktu ujian berakhir fleksibel bisa dipilih apabila pelaksanaan ujian oleh peserta tidak serentak.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div id="fleksible_time" style="display:none">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                            <h5 class="label-text">Batas Waktu Pengerjaan</h5>
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <input type="text" class="form-control datetimepicker-input" id="datetimepicker6" data-toggle="datetimepicker" data-target="#datetimepicker6" name="batas_pengerjaan" placeholder="Pilih tanggal dan waktu"/>
                                            </div>
                                            <div class="alert alert-info">
                                                <p>
                                                    Batas waktu pengerjaan adalah ketika peserta ujian sudah tidak dapat mengerjakan ujian / mengakses ujian.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Durasi Blok Layar</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="blok_layar" name="blok_layar" type="number" class="form-control" aria-required="true" aria-invalid="false" value="0">
                                        </div>
                                        <div class="alert alert-info">
                                            <p>
                                                Tab browser peserta ujian akan di blok dalam beberapa menit sesuai inputan anda diatas jika peserta keluar dari browser atau pindah ke tab browser lainnya. Biarkan 0 jika tidak menggunakan fitur ini.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Tampilkan Hasil</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="is_hasil_tidak" name="is_hasil" required value="0" checked>
                                                <label class="custom-control-label" for="is_hasil_tidak">Tidak</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="is_hasil_ya" name="is_hasil" required value="1">
                                                <label class="custom-control-label" for="is_hasil_ya">Ya</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Tampilkan Ranking</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="is_ranking_tidak" name="is_ranking" required value="0" checked>
                                                <label class="custom-control-label" for="is_ranking_tidak">Tidak</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="is_ranking_ya" name="is_ranking" required value="1">
                                                <label class="custom-control-label" for="is_ranking_ya">Ya</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Tampilkan Pembahasan</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="is_pembahasan_tidak" name="is_pembahasan" required value="0" checked>
                                                <label class="custom-control-label" for="is_pembahasan_tidak">Tidak</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="is_pembahasan_ya" name="is_pembahasan" required value="1">
                                                <label class="custom-control-label" for="is_pembahasan_ya">Ya</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Tampilkan Kunci</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="is_kunci_pembahasan_tidak" name="is_kunci_pembahasan" required value="0" checked>
                                                <label class="custom-control-label" for="is_kunci_pembahasan_tidak">Tidak</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="is_kunci_pembahasan_ya" name="is_kunci_pembahasan" required value="1">
                                                <label class="custom-control-label" for="is_kunci_pembahasan_ya">Ya</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                        <h5 class="label-text">Komposisi Soal</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="komposisi_soal_semua" name="komposisi_soal" required value="0" checked onchange="komposisi_soal_semua_func()">
                                                <label class="custom-control-label" for="komposisi_soal_semua">Gunakan Semua Soal</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="komposisi_soal_atur" name="komposisi_soal" required value="1" onchange="komposisi_soal_atur_func()">
                                                <label class="custom-control-label" for="komposisi_soal_atur">Atur Komposisi</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="komposisi_soal_detail" style="display:none;">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3">
                                            
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <table class="table text-center">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Jenis Soal</th>
                                                            <th>Group Soal</th>
                                                            <th>Tingkat Kesulitan</th>
                                                            <th>Jumlah Soal</th>
                                                            <th width="10%">Digunakan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $no = 1;
                                                        foreach($komposisi_soal as $value){
                                                    ?>
                                                        <tr>
                                                            <td><?=$value->jenis_soal?></td>
                                                            <td><?=$value->name_group_soal?></td>
                                                            <td><?=$value->tipe_kesulitan?></td>
                                                            <td><?=$value->jumlah_soal?></td>
                                                            <td>
                                                                <input id="id_group_soal" name="id_group_soal[]" type="hidden" class="form-control text-center" aria-required="true" aria-invalid="false" value="<?=$value->id_group_soal?>" required>
                                                                <input id="total_soal" name="total_soal[]" type="number" class="form-control text-center" aria-required="true" aria-invalid="false" value="<?=$value->jumlah_soal?>" required>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
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