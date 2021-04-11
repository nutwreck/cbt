 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="overview-wrap">
                            <h2 class="title-1">Daftar Soal</h2>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 button-config">
                        <p id="paket_soal_id" style="display:none;"><?=$id_paket_soal?></p>
                        <p id="bank_soal_first_id" style="display:none;"><?=!empty($soal_first_list) ? $soal_first_list : ''?></p>
                        <a href="<?=base_url()?>admin/add-soal/<?=$id_paket_soal?>" class="btn btn-sm btn-primary m-1">Tambah Soal</a>
                        <a href="<?=base_url()?>admin/drop-all/<?=$id_paket_soal?>" class="btn btn-sm btn-danger m-1" onclick="return confirm('Apakah anda yakin menghapus semua soal dalam paket ini?')">Kosongkan</a>
                        <button class="btn btn-sm btn-outline-secondary m-1" onclick="return toggle_soal()">Toogle Soal</button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="box-head">
                            <table class="table table-borderless text-left">
                                <tr>
                                    <td width="20%"><p>Nama Paket Soal</p></td><td width="2%"><p>:</p></td><td><p><?=$paket_soal->nama_paket_soal?></p></td>
                                </tr>
                                <tr>
                                    <td width="20%"><p>Materi</p></td><td width="2%"><p>:</p></td><td><p><?=$paket_soal->materi_name.' '.$paket_soal->kelas_name?></p></td>
                                </tr>
                                <tr>
                                    <td width="20%"><p>Jumlah Soal</p></td><td width="2%"><p>:</p></td><td><?=$paket_soal->total_soal == 0 ? '<p class="text-danger">Belum ada soal</p>' : $paket_soal->total_soal?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" <?=$paket_soal->total_soal == 0 ? 'style="display:none;"' : ''?>>
                    <p id="csrf-name-form" style="display:none;"><?=$this->security->get_csrf_token_name();?></p>
                    <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <div id="lembar_soal" class="col-sm-12 col-md-8 mb-3">
                        <div class="card text-left h-100">
                            <div id="header-soal" class="card-header bg-primary text-white">
                                    
                            </div>
                            <div class="card-body">
                                <div id="content-soal">
                                
                                </div>
                                <hr>
                                <div id="jawaban-soal" class="funkyradio text-justify">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="panel-toogle-soal" class="col-sm-12 col-md-4 mb-3" style="display:block;">
                        <div class="card text-center">
                            <h5 class="m-3">Navigasi Soal</h5>
                            <div class="card-body text-white btn-navigasi">
                                <?php foreach($id_soal_list as $val_id_soal){ ?>
                                    <button id="<?=$val_id_soal->id?>" class="btn button-round btn-outline-secondary" onclick="return get_soal(this.id, <?=$val_id_soal->no_soal?>)"><?=$val_id_soal->no_soal?></button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>