<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Edit Bacaan Soal</div>
                            <div class="col text-right">
                                <a href="<?=base_url()?>admin/bacaan-soal/<?=$id_paket_soal?>" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                        <form id="formadd" name="formadd" action="<?php echo base_url(); ?>website/lembaga/Tes_online/submit_edit_bacaan_soal" class="form-soal" method="POST" enctype="multipart/form-data" onsubmit="return(validate_addform());">
                        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                        <input type="hidden" id="id_paket_soal" name="id_paket_soal" value="<?=$id_paket_soal?>" style="display: none" required>
                        <input type="hidden" id="id_bacaan_soal" name="id_bacaan_soal" value="<?=$id_bacaan_soal?>" style="display: none" required>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Judul Bacaan</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="name" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?=$bacaan_soal->name?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Kode Bacaan</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="kode_bacaan" name="kode_bacaan" type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?=$bacaan_soal->kode_bacaan?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Isi Bacaan</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <textarea class="summernote note-math-dialog" id="summernote" name="bacaan" rows='10'><?=$bacaan_soal->bacaan?></textarea>
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