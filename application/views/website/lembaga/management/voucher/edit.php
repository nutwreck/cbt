<!-- MAIN CONTENT-->
<div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div id="info_user" class="col-sm-12 col-lg-6">
                        <div class="row mt-3 ml-0 mr-0 mb-0">
                            <div class="col-sm-12">
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="close_info()">×</button>
                                    <span class="glyphicon glyphicon-info-sign"></span><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Informasi</strong>
                                    <hr class="message-inner-separator">
                                    <p>
                                        Potongan kode voucher akan langsung memotong harga diinvoice
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="content_add" class="col-sm-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">Tambah Materi</div>
                            <div class="card-body">
                                <form id="formedit" name="formedit" action="<?php echo base_url(); ?>website/lembaga/Management/submit_edit_voucher" method="post" onsubmit = "return(validate_editform());">
                                <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                <input type="hidden" id="id" name="id" value="<?=$voucher->id?>" style="display: none" required>
                                    <div class="form-group">
                                        <label for="voucher" class="control-label mb-1">Kode Voucher</label>
                                        <small for="voucher" id="voucher_er" class="bg-danger text-white"></small>
                                        <input id="voucher" name="voucher" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Kode Voucher" value="<?=$voucher->name?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="potongan" class="control-label mb-1">Potongan</label>
                                        <small for="potongan" id="potongan_er" class="bg-danger text-white"></small>
                                        <input id="potongan" name="potongan" type="number" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Potongan Harga" value="<?=$voucher->potongan?>">
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-lg btn-info btn-block">
                                            <i class="fa fa-check fa-md"></i>&nbsp;
                                            <span>Update</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>