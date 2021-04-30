<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Edit Detail Pembayaran</div>
                            <div class="col text-right">
                                <a href="<?=base_url()?>admin/detail-pembayaran-master/<?=urlencode(base64_encode($detail_pembayaran_master->payment_method_id))?>" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                        <form id="formadd" name="formadd" action="<?php echo base_url(); ?>website/lembaga/Management/submit_edit_detail_pembayaran_master" class="form-paket-soal" method="POST" enctype="multipart/form-data" onsubmit="return(validate_addform());">
                        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                        <input type="hidden" id="id_pembayaran_detail_master" name="id_pembayaran_detail_master" value="<?=$id_pembayaran_detail_master?>" style="display: none">
                        <input type="hidden" id="id_pembayaran_master" name="id_pembayaran_master" value="<?=urlencode(base64_encode($detail_pembayaran_master->payment_method_id))?>" style="display: none">
                            <div class="card-body">
                                <?php if($detail_pembayaran_master->payment_method_id == 1) { ?>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                            <h5 class="label-text">Logo Pembayaran</h5>
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <div class="custom-file">
                                                    <input type="hidden" id="old_name_logo" name="old_name_logo" value="<?=$detail_pembayaran_master->logo_payment?>" style="display: none">
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
                                                <input id="bank_name" readonly name="bank_name" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Ex: Mandiri/BCA/BRI/BNI" value="<?=$detail_pembayaran_master->bank_name?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                            <h5 class="label-text">Akun Bank</h5>
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <input id="bank_account" name="bank_account" type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?=$detail_pembayaran_master->bank_account?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                            <h5 class="label-text">No Rekening Bank</h5>
                                        </div>
                                        <div class="col-sm-12 col-lg-9">
                                            <div class="form-group">
                                                <input id="bank_number" name="bank_number" type="number" class="form-control" aria-required="true" aria-invalid="false" value="<?=$detail_pembayaran_master->bank_number?>">
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
                                                    <input type="hidden" id="old_name_image" name="old_name_image" value="<?=$detail_pembayaran_master->image_payment?>" style="display: none">
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