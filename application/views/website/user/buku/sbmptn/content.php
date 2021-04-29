<!-- Page Content  -->
<div class="isi-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span class="glyphicon glyphicon-info-sign"></span><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Informasi</strong>
                    <hr class="message-inner-separator">
                    <?php if($status_user == 'free') { ?>
                        <p>Selamat, Anda berhak mendapatkan <?=$free_paket?> Paket <b>TryOut SBMPTN secara GRATIS</b>. Untuk mendapatkan seluruh paket TryOut silahkan melakukkan <b>pembelian Paket TryOut SBMPTN</b> dengan cara <a href="<?=base_url()?>history" class="btn btn-sm btn-success">Klik Disini</a></p>
                    <?php } else { ?>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>