<div class="isi-content">
  <div class="row">
      <div class="col-sm-12">
      <form action="<?php echo base_url(); ?>website/user/Buku/submit_konfirm_invoice" method="post" enctype="multipart/form-data">
        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
        <input type="hidden" id="id_invoice" name="id_invoice" value="<?=$id_invoice?>" style="display: none">
        <input type="hidden" id="invoice_number" name="invoice_number" value="<?=$invoice_detail->invoice_number?>" style="display: none">
        <input type="hidden" id="status" name="status" value="<?=$invoice_detail->status?>" style="display: none">

        <div class="row mt-1 ml-0 mr-0 mb-0">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span class="glyphicon glyphicon-info-sign"></span><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Informasi</strong>
                    <hr class="message-inner-separator">
                    <p>Tipe file upload bukti yang diijinkan hanya JPG, JPEG, PNG dengan maksimal ukuran file 500kb. Selain ketentuan tersebut file upload anda tidak terbaca.</p>
                </div>
            </div>
        </div>

        <?php if(!empty($invoice_detail->reject_desc)){ ?>
        <div class="row mt-1 ml-0 mr-0 mb-0">
            <div class="col-sm-12">
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span class="glyphicon glyphicon-info-sign"></span><i class="fas fa-sticky-note"></i> <strong>Pesan Reject</strong>
                    <hr class="message-inner-separator">
                    <p><?=$invoice_detail->reject_desc?></p>
                </div>
            </div>
        </div>
        <?php } else { echo ''; } ?>

        <div class="col-sm-6 offset-sm-3">
            <div class="form-group">
            <label for="name">Upload Bukti Pembayaran</label>
                <div class="custom-file">
                    <input type="hidden" id="old_bukti" name="old_bukti" value="<?=$invoice_detail->confirm_image?>" style="display: none">
                    <input type="file" class="custom-file-input" id="bukti_pembayaran" name="bukti_pembayaran">
                    <label id="file-name" class="custom-file-label" for="bukti_pembayaran">Pilih Gambar</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Konfirmasi</button>
            <?php if(!empty($invoice_detail->confirm_image)) { ?>
                <img src="<?=config_item('_dir_website')?>lembaga/grandsbmptn/confirm_payment/<?=$invoice_detail->confirm_image?>" alt="<?=$invoice_detail->invoice_number?>" class="img-thumbnail">
            <?php } else { echo ''; } ?>
        </div>

      </form>
      </div>
  </div>