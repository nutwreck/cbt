<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Tambah Detail Pembayaran</div>
                            <div class="col text-right">
                                <a href="<?=base_url()?>admin/detail-pembayaran-master/<?=$id_pembayaran_master?>" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                        <form id="formadd" name="formadd" action="<?php echo base_url(); ?>website/lembaga/Management/submit_add_detail_pembayaran_master" class="form-paket-soal" method="POST" enctype="multipart/form-data" onsubmit="return(validate_addform());">
                        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                        <input type="hidden" id="id_pembayaran_master" name="id_pembayaran_master" value="<?=$id_pembayaran_master?>" style="display: none">
                            <div class="card-body">
                                <?php $pembayarn_master_id = base64_decode(urldecode($id_pembayaran_master)); ?>

                                <?php if($pembayarn_master_id == 1) { ?>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                            <h5 class="label-text">Logo Pembayaran</h5>
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="logo_payment" name="logo_payment">
                                                    <label id="file-name-logo" class="custom-file-label" for="logo_payment">Pilih Gambar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                            <h5 class="label-text">Nama Bank</h5>
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <select class="form-control" id="bank_name" name="bank_name">
                                                    <option value="bri">BRI</option>
                                                    <option value="bni">BNI</option>
                                                    <option value="bca">BCA</option>
                                                    <option value="mandiri_online">MANDIRI</option>
                                                    <option value="btpn_jenius">BTPN JENIUS</option>
                                                </select>
                                                <small>* Pilih nama bank hanya sesuai yang ada di list.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                            <h5 class="label-text">Akun Bank</h5>
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <input id="bank_account" name="bank_account" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                            <h5 class="label-text">No Rekening Bank</h5>
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <input id="bank_number" name="bank_number" type="number" class="form-control" aria-required="true" aria-invalid="false">
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                            <h5 class="label-text">Gambar Scan Qris Pembayaran</h5>
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image_payment" name="image_payment">
                                                    <label id="file-name-qris" class="custom-file-label" for="image_payment">Pilih Gambar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
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