<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Detail Bacaan Soal</div>
                            <div class="col text-right">
                                <a href="<?=base_url()?>admin/bacaan-soal/<?=urlencode(base64_encode($bacaan_soal->paket_soal_id))?>" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Judul Bacaan</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="name" name="name" readonly type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?=$bacaan_soal->name?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Kode Bacaan</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="kode_bacaan" readonly name="kode_bacaan" type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?=$bacaan_soal->kode_bacaan?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Isi Bacaan</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <p><?=$bacaan_soal->bacaan?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>