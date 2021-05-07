<div class="container" style="margin-top:-25px;">
	<div class="row text-center">
        <div class="col-sm-12">
            <br><br> <h2 style="color:#0fad00">Invoice Terkirim</h2>
            <img class="img-responsive" src="<?=config_item('_assets_general')?>image/email-send.ico" width="95px;" height="85px">
            <h3>Dear, <?=$user_name?></h3>
            <p style="font-size:20px;color:#5C5C5C;">
                Terimakasih telah melakukkan pembelian Paket Soal <?=$buku_name?> <?=!empty($detail_buku_name) ? '('.$detail_buku_name.')' : ''?>, Invoice pembayaran kami kirimkan ke email anda <?=$user_email?>, Berikut detail dari pembelian anda :
            </p>
            <div class="col-sm-6 offset-sm-3">
                <table class="table">
                    <tr>
                        <td colspan="3" class="font-weight-bold">No Invoice <br /> #<?=$invoice_number?> <br /> <span class="text-danger">Exp <?=format_indo($invoice_date_expirate)?></span></td>
                    </tr>
                    <tr>
                        <td>Harga</td><td>:</td><td class="text-left"><?=rupiah($price)?></td>
                    </tr>
                    <?php if($voucher_name != '' && $voucher_potongan != 0) { ?>
                    <tr>
                        <td>Potongan Harga</td><td>:</td><td class="text-left"><?=rupiah($voucher_potongan)?></td>
                    </tr>
                    <?php } else { echo ''; }; ?>
                    <tr>
                        <td>Kode Unik</td><td>:</td><td class="text-left"><?=rupiah($kode_unik)?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Total Pembayaran</td><td>:</td><td class="text-right font-weight-bold text-danger"><?=rupiah($invoice_total_cost)?></td>
                    </tr>
                    <?php if($payment_method_id != 1){ ?>
                        <tr>
                            <td colspan="3" class="font-weight-bold">Informasi Pembayaran</td>
                        </tr>
                        <tr>
                            <td colspan="3">Scan Qris dibawah ini bisa menggunakan (OVO, Gopay, DOKU, DANA, Link Aja, Shopeepay)</td>
                        </tr>
                        <tr>
                            <td colspan="3"><img clas="img-responsive" src="<?=config_item('_dir_website')?>lembaga/grandsbmptn/master_pembayaran/<?=$qris?>" alt="Qris-scan" width="220px;" height="300px;" alt="qris-pembayaran"></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="color:#5C5C5C;">Segera lakukkan pembayaran sebelum tanggal <?=format_indo($invoice_date_expirate)?>, Pastikan nominal bayar sesuai dengan total pembayaran diatas jika tidak maka konfirmasi tidak akan diterima.</td>
                        </tr>
                        <tr>
                            <td colspan="3">Lakukkan konfirmasi manual melalui menu <a href="<?=base_url()?>purchase" class="btn btn-success">Status Pembelian</a></td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td colspan="3" class="font-weight-bold">Informasi Pembayaran</td>
                        </tr>
                        <tr>
                            <td>Bank</td><td>:</td><td class="text-left"><?=$bank?></td>
                        </tr>
                        <tr>
                            <td>No Rekening</td><td>:</td><td class="text-left"><?=$bank_number?></td>
                        </tr>
                        <tr>
                            <td>Atas Nama</td><td>:</td><td class="text-left"><?=$bank_account?></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="color:#5C5C5C;">Segera lakukkan pembayaran sebelum tanggal <?=format_indo($invoice_date_expirate)?>, Pastikan transfer sesuai dengan total pembayaran diatas jika tidak maka konfirmasi otomatis pembayaran anda tidak terdeteksi oleh sistem.</td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="m-3">
                <p>Untuk melakukkan pengecekan status invoice</p>
                <a href="<?=base_url()?>purchase" class="btn btn-success">Klik Disini</a>
            </div>
            <br><br>
        </div>
        
	</div>
</div>