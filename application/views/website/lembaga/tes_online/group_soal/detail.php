<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Detail Group Soal</div>
                            <div class="col text-right">
                                <a href="<?=base_url()?>admin/group-soal/<?=$id_paket_soal?>" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Nama Group</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="name" name="name" type="text" readonly class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Nama Group Soal" value="<?=$group_soal->name_group_soal?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Kode Group</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="kode_group" name="kode_group" readonly type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Kode Group Soal" value="<?=$group_soal->kode_group?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3">
                                    <h5 class="label-text">Petunjuk</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <p><?=$group_soal->petunjuk?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1.3%">
                                    <h5 class="label-text">Audio Group</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                    <?php if(!empty($group_soal->file)) { ?>
                                        <audio id="loop-limited" controls>
                                            <source src="<?=config_item('_dir_website')?>/lembaga/grandsbmptn/group_soal/group_<?=$group_soal->paket_soal_id?>/<?=$group_soal->file?>" type="<?=$group_soal->tipe_file?>">
                                            Browsermu tidak mendukung tag audio, upgrade donk!
                                        </audio>
                                    <?php } else { ?>
                                        <p>Tidak ada file audio</p>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3">
                                    <h5 class="label-text">Konversi Skor</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <p><?php if($group_soal->konversi_skor_id == 0){ echo 'Tidak Ada'; } else { echo $group_soal->name_konversi_skor; } ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3">
                                    <h5 class="label-text">Parent Group</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <p><?php if($group_soal->parent_id == 0){ echo 'Tidak Ada'; } else { echo $group_soal->name_parent; } ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="display:none;">
                                <div class="col-sm-12 col-lg-3">
                                    <h5 class="label-text">Continuous</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <p><?=$group_soal->continuous_name?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>