<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="overview-wrap">
                        <h2 class="title-1">Daftar Soal</h2>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8 button-config">
                    <p id="paket_soal_id" style="display:none;"><?=$id_paket_soal?></p>
                    <p id="bank_soal_first_id" style="display:none;"><?=!empty($soal_first_list) ? $soal_first_list : ''?></p>
                    <button class="btn btn-sm btn-outline-secondary m-1" onclick="return toogle_search()">Search</button>
                    <a href="<?=base_url()?>admin/add-soal/<?=$id_paket_soal?>" class="btn btn-sm btn-primary m-1">Tambah Soal</a>
                    <a href="<?=base_url()?>admin/import-soal/<?=$id_paket_soal?>" class="btn btn-sm btn-success m-1">Import Soal</a>
                    <a href="<?=base_url()?>admin/drop-all/<?=$id_paket_soal?>" class="btn btn-sm btn-danger m-1" onclick="return confirm('Apakah anda yakin menghapus semua soal dalam paket ini?')">Kosongkan</a>
                    <button class="btn btn-sm btn-outline-secondary m-1" onclick="return toggle_soal()">Toogle Soal</button>
                </div>
            </div>
            <div id="panel-toogle-search" class="row mt-3" style="display:none;">
                <div class="col-sm-12">
                <form id="formsearch" name="formsearch" action="<?php echo base_url(); ?>website/lembaga/Tes_online/submit_search_soal" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="id_paket_soal" name="id_paket_soal" value="<?=$id_paket_soal?>" style="display: none" required>
                    <div class="box-search">
                        <table class="table table-borderless text-left">
                            <tr>
                                <td colspan="3" style="font-size:25px">Search Data</td>
                            </tr>
                            <tr>
                                <td width="20%"><p>Group Soal</p></td><td width="2%"><p>:</p></td>
                                <td>
                                    <select class="form-control selectpicker" data-live-search="true" data-width="auto" id="group_soal_idx" name="group_soal_id" onchange="prevent_form()">
                                        <option data-tokens="PILIH GROUP SOAL" value="" >PILIH GROUP SOAL</option>
                                        <option data-tokens="ALL" value="all_soal">ALL</option>
                                        <option data-tokens="NO_GROUP" value="no_group">NO_GROUP</option>
                                        <?php foreach($list_group_soal as $val_list_group_soal){ ?>
                                            <option data-tokens="<?=$val_list_group_soal->name_group_soal?>" value="<?=$val_list_group_soal->id_group_soal?>"><?=$val_list_group_soal->name_group_soal?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%"><p>Kata Kunci Soal</p></td><td width="2%"><p>:</p></td>
                                <td><input class="form-control" type="text" placeholder="Masukkan kata kunci soal" id="kata_kunci_soalx" name="kata_kunci_soal"></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="col-sm-12 text-right">
                                        <button type="submit" class="btn btn-md btn-info btn-small">
                                            <i class="fa fa-check fa-md"></i>&nbsp;
                                            <span>Submit</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
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
                            <tr>
                                <td width="20%"><p><b>Noted</b></p></td><td width="2%"><p>:</p></td><td><b>Jika paket soal ini digunakan dalam sesi pelaksanaan dan sedang berlangsung, Harap tidak melakukkan delete atau edit jawaban. Lakukkan edit atau delete jawaban jika report ujian sudah diunduh.</b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mt-3 soal-content" <?=$paket_soal->total_soal == 0 ? 'style="display:none;"' : ''?>>
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