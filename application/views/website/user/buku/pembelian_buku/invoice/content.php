<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Invoice</title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
            }
            
            .invoice-box .notices{
                padding-left: 6px;
                border-left: 6px solid #3989c6;
                margin-top: 20px;
            }

            .invoice-box .notices .notice{
                font-size: 1.2em;
            }

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img src="https://scontent.fsub1-1.fna.fbcdn.net/v/t1.6435-9/180731000_5532264243480864_267979682565064452_n.jpg?_nc_cat=109&ccb=1-3&_nc_sid=730e14&_nc_eui2=AeG9XJn5KxCFMEK7wWq9f9uq2TZ9_pVv1MnZNn3-lW_Uyai12h9jrZO75n_RBY9KmXO5pGifHvrjXAhzJsGQkU10&_nc_ohc=ntBtyPJ6PvkAX8vxCN9&_nc_ht=scontent.fsub1-1.fna&oh=e9e2fea971823620b11e90696bb1c22f&oe=60B1E32B" style="width: 100%; max-width: 300px" alt="header-logo"/>
								</td>

								<td style="text-align:right">
									Invoice : #<?=$invoice_number?><br />
									Tanggal Dibuat: <?=format_indo($invoice_date_create)?><br />
									<span style="color:red;">Tanggal Kadaluarsa: <?=format_indo($invoice_date_expirate)?></span>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td>
						<table>
							<tr>
								<td>
                                    <?=$user_name?><br />
									<?=$user_email?>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td colspan="2" style="text-align:center;">Informasi Pembayaran</td>
				</tr>

                <?php if($payment_method_id == 1){ ?>
                    <tr class="details">
                        <td>Bank</td><td class="text-left"><?=$bank?></td>
                    </tr>
                    <tr class="details">
                        <td>No Rekening</td><td class="text-left"><?=$bank_number?></td>
                    </tr>
                    <tr class="details">
                        <td>Atas Nama</td><td class="text-left"><?=$bank_account?></td>
                    </tr>
                    <tr class="details">
                        <td colspan="3" style="color:#5C5C5C;">Pastikan transfer sesuai dengan total pembayaran dibawah ini jika tidak maka konfirmasi otomatis pembayaran anda tidak terdeteksi oleh sistem.</td>
                    </tr>
                <?php } else { ?>
                    <tr class="details">
                        <td colspan="2">Scan Qris dibawah ini bisa menggunakan (OVO, Gopay, DOKU, DANA, Link Aja, Shopeepay)</td>
                    </tr>
                    <tr class="details">
                        <td colspan="2"><img clas="img-responsive" src="<?=config_item('_dir_website')?>lembaga/grandsbmptn/master_pembayaran/<?=$qris?>" alt="Qris-scan" width="220px;" height="300px;" alt="qris-pembayaran"></td>
                    </tr>
                    <tr class="details">
                        <td colspan="2" style="color:#5C5C5C;">Pastikan nominal bayar sesuai dengan total pembayaran dibawah ini jika tidak maka konfirmasi tidak akan diterima.</td>
                    </tr>
                    <tr class="details">
                        <td colspan="2">Jika sudah melakukkan pembayaran silahkan konfirmasi manual lewat sistem melalui halaman <b>Status Pembelian</b></td>
                    </tr>
                <?php } ?>

				<tr class="heading">
					<td>Deskripsi</td>

					<td>Harga</td>
				</tr>

				<tr class="item">
					<td>Pembelian Paket Soal <?=$buku_name?> <?=!empty($detail_buku_name) ? '('.$detail_buku_name.')' : ''?></td>

					<td><?=rupiah($price)?></td>
				</tr>

				<?php if($voucher_name != '' && $voucher_potongan != 0) { ?>
				<tr class="item last">
					<td style="text-align:right;"><b>Potongan Harga</b></td><td><?=rupiah($voucher_potongan)?></td>
				</tr>
				<?php } else { echo ''; }; ?>

				<tr class="item last">
					<td style="text-align:right;"><b>Kode Unik</b></td><td><?=rupiah($kode_unik)?></td>
				</tr>

				<tr class="total">
					<td style="text-align:right"><b>Biaya yang harus dibayar</b></td>

					<td style="text-align:right"><b><?=rupiah($invoice_total_cost)?></b></td>
				</tr>
			</table>

            <div class="notices">
                <div>NOTE:</div>
                <?php if($payment_method_id == 1){ ?>
                    <div class="notice">Invoice ini hanya berlaku sampai <?=format_indo($invoice_date_expirate)?>, lakukkan pembayaran sebelum tanggal tersebut atau invoice anda akan hangus dan jika anda melakukkan pembayaran setelah tanggal tersebut maka pembayaran anda dianggap hangus.</div>   
                <?php } else { ?>
                    <div class="notice">Invoice ini hanya berlaku sampai <?=format_indo($invoice_date_expirate)?>, lakukkan pembayaran dan konfirmasi sebelum tanggal tersebut atau invoice anda akan hangus dan jika anda melakukkan pembayaran setelah tanggal tersebut maka pembayaran anda dianggap hangus.</div>
                <?php } ?>
            </div>
		</div>
	</body>
</html>