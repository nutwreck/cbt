<div class="isi-content">
    <hr>
    <div class="card">
        <div class="card-header bg-header-produk">
            <h3 class="title font-arial-bold">Paket Soal <?=$buku_data->buku_name?></h3>     
        </div>
        <div class="row">
            <aside class="col-sm-12">
                <article class="card-body p-5 bg-article">
                    <p class="price-detail-wrap"> 
                        <span class="price h3 font-arial-bold"> 
                            <span class="num"><?=rupiah($buku_data->price)?></span>
                        </span> 
                    </p>
                    <?php
                    $book_id = base64_decode(urldecode($id_buku));
                    if($book_id == 1) { //TOEFL ?>
                        <div class="bg-book">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-5">
                                    <img src="<?=config_item('_assets_general')?>image/book/toefl.png" class="img-fluid mb-3" width="300">
                                    <h4 class="font-arial-bold text-center text-danger">Trik jitu dapatkan <br />skor 620 !!</h4>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-7">
                                    <div class="bg-book-desc-1 font-arial-bold">
                                        <ul>
                                            <li>Buku hardfile sebanyak <b class="bg-danger text-white">200 halaman</b></li>
                                            <li>Dilengkapi <b class="bg-danger text-white">ebook ribuan halaman</b></li>
                                            <li><b class="bg-danger text-white">Video pembelajaran</b> hingga <b class="bg-danger text-white">50jam</b></li>
                                            <li>Bank soal <b class="bg-danger text-white">1500++ soal</b> TOEFL & pembahasan</li>
                                            <li><b class="bg-danger text-white">Kiat</b> pasti dapatkan skor <b class="bg-danger text-white">620</b></li>
                                            <li>Grup diskusi TOEFL</li>
                                            <li>Setara dengan kursus <b class="bg-danger text-white">6 bulan</b></li>
                                            <li>Roadmap cara belajar efektif</li>
                                            <li><b class="bg-danger text-white">Mentoring</b> online <b class="bg-danger text-white">setiap minggu</b></li>
                                            <li><b class="bg-danger text-white">100% garansi</b> kepuasan <b class="bg-danger text-white">uang</b> kembali</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } elseif($book_id == 2) { //SBMPTN ?>
                        <div class="bg-book">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-5">
                                    <img src="<?=config_item('_assets_general')?>image/book/sbmptn.png" class="img-fluid mb-3" width="300">
                                    <h4 class="font-arial-bold text-center text-primary">Lolos UTBK <br />Di PTN Terbaik !!</h4>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-7">
                                    <div class="bg-book-desc-1 font-arial-bold">
                                        <ul>
                                            <li>Buku hardfile sebanyak <b class="bg-primary text-white">250 halaman</b></li>
                                            <li>Dilengkapi <b class="bg-primary text-white">ebook ribuan halaman</b></li>
                                            <li><b class="bg-primary text-white">Video pembelajaran</b> hingga <b class="bg-primary text-white">50jam ++</b></li>
                                            <li><b class="bg-primary text-white">9000 video pembahasan</b></li>
                                            <li>Bank soal <b class="bg-primary text-white">(9000++, soal + pembahasan)</b></li>
                                            <li>Kiat pasti <b class="bg-primary text-white">lolos UTBK</b></li>
                                            <li><b class="bg-primary text-white">Grup diskusi</b> sesama pejuang PTN</li>
                                            <li>Setara dengan <b class="bg-primary text-white">kursus 6 bulan</b></li>
                                            <li>Roadmap cara belajar efektif</li>
                                            <li><b class="bg-primary text-white">50x tryout</b></li>
                                            <li><b class="bg-primary text-white">Mentoring</b> online <b class="bg-primary text-white">setiap minggu</b></li>
                                            <li><b class="bg-primary text-white">Trik cepat</b> mengerjakan soal UTBK</li>
                                            <li><b class="bg-primary text-white">Ratusan rumus</b> SAINTEK & SOSHUM</li>
                                            <li><b class="bg-primary text-white">100% garansi kepuasan</b> uang kembali</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } elseif($book_id == 3) { //CPNS ?>
                        <div class="bg-book">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-5">
                                    <img src="<?=config_item('_assets_general')?>image/book/cpns.png" class="img-fluid mb-3" width="300">
                                    <h4 class="font-arial-bold text-center text-secondary">Lolos CPNS <br />Instansi Terbaik !!</h4>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-7">
                                    <div class="bg-book-desc-1 font-arial-bold">
                                        <ul>
                                            <li>Buku hardfile sebanyak <b class="bg-secondary text-white">200 halaman</b></li>
                                            <li>Dilengkapi <b class="bg-secondary text-white">ebook ribuan halaman</b></li>
                                            <li><b class="bg-secondary text-white">Video pembelajaran</b> hingga <b class="bg-secondary text-white">50jam</b></li>
                                            <li><b class="bg-secondary text-white">9000 video pembelajaran</b></li>
                                            <li>Bank soal <b class="bg-secondary text-white">9000 soal + pembahasan</b></li>
                                            <li><b class="bg-secondary text-white">Kiat</b> pasti lolos <b class="bg-secondary text-white">CPNS</b></li>
                                            <li><b class="bg-secondary text-white">Grup diskusi</b> TOEFL</li>
                                            <li>Setara dengan kursus <b class="bg-secondary text-white">6 bulan</b></li>
                                            <li>Roadmap cara belajar efektif</li>
                                            <li><b class="bg-secondary text-white">50x tryout</b></li>
                                            <li><b class="bg-secondary text-white">Mentoring</b> online <b class="bg-secondary text-white">setiap minggu</b></li>
                                            <li><b class="bg-secondary text-white">Trik cepat</b> mengerjakan soal CPNS</li>
                                            <li><b class="bg-secondary text-white">100% garansi kepuasan</b> uang kembali</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <dl class="item-property">
                        <dt><h5 class="font-arial-bold">Deskripsi</h5></dt>
                        <dd class="bg-book-desc-2"><p><?=$buku_data->desc?></p></dd>
                    </dl>

                    <hr>
                    <form id="form-payment" name="form-payment" action="<?php echo base_url(); ?>website/user/Buku/submit_payment" method="post">
                    <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <input type="hidden" name="id_buku" value="<?=$id_buku?>" required>
                    <input type="hidden" name="user_id" value="<?=$user_data->id?>" required>
                    <input type="hidden" name="invoice_total_cost" value="<?=$buku_data->price?>" required>
                    <div class="row bg-form shadow">
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <label for="user_name" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="user_name" name="user_name" value="<?=$user_data->peserta_name?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="user_email" name="user_email" value="<?=$user_data->username?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_no_telp" class="col-sm-2 col-form-label">No Telp</label>
                                <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="user_no_telp" name="user_no_telp" value="<?=$user_data->no_telp?>">
                                </div>
                            </div>
                            <?php if(base64_decode(urldecode($id_buku)) == 2){ ?>
                                <div class="form-group row">
                                    <label for="detail_buku_id" class="col-sm-2 col-form-label">Pilih Jurusan</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="detail_buku_id" name="detail_buku_id">
                                            <option value="1">SAINTEK (IPA)</option>
                                            <option value="2">SOSHUM (IPS)</option>
                                        </select>
                                        <small>* Paket soal yang akan ditampilkan nantinya sesuai dengan jurusan yang anda pilih.</small>
                                    </div>
                                </div>
                            <?php } else { echo ''; } ?>
                            <div class="form-group row">
                                <label for="voucher" class="col-sm-2 col-form-label">Kode Voucher</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="voucher" name="voucher">
                                    <small>* Punya kode voucher? Masukkan kode voucher anda.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!--PAYMENT-->
                    <!-- <div class="row mb-4">
                        <div class="col-lg-8 mx-auto text-center">
                            <h2 class="display-6">Pilihan Pembayaran</h2>
                        </div>
                    </div> --> <!-- End -->
                    <div class="row">
                        <div class="col-lg-6 mx-auto bg-pembayaran shadow">
                            <div class="card border-0" style="background: transparent;">
                                <div class="card-header">
                                    <div class="mx-auto text-center text-white font-arial-bold">
                                        <h2 class="display-6">Pilihan Pembayaran</h2>
                                    </div>
                                    <div class="pt-4 pl-2 pr-2 pb-2">
                                        <!-- Credit card form tabs -->
                                        <ul role="tablist" class="nav nav-pills nav-fill mb-3 bg-pembayaran-chos">
                                            <li class="nav-item"> <a id="bank-btn" data-toggle="pill" href="#banking" class="nav-link active" onclick="return bank_click();"> <i class="fas fa-credit-card mr-2"></i> Bank </a></li>
                                            <li class="nav-item"> <a id="qris-btn" data-toggle="pill" href="#qris" class="nav-link" onclick="return qris_click();"> <i class="fas fa-qrcode mr-2"></i> Qris </a></li>
                                        </ul>
                                    </div> <!-- End -->
                                    <!-- Qris form content -->
                                    <div class="tab-content">
                                        <!-- bank transfer info -->
                                        <div id="banking" class="tab-pane fade show active pt-3">
                                            <div class="form-group "> <label for="Bank">
                                                <h6 class="text-white">Bank</h6>
                                                </label> <select class="form-control selectpicker" id="payment_bank" name="payment_bank">
                                                    <?php foreach($payment_method_detail as $val_bank){ ?>
                                                        <option data-content="<img class='img-thumbnail' src='<?=config_item('_dir_website').'lembaga/grandsbmptn/master_pembayaran/'.$val_bank->logo_payment?>' alt='image_<?=$val_bank->id?>' width='80px' /> <?=$val_bank->bank_name?>" value="<?=$val_bank->id?>|<?=$val_bank->bank_name?>|<?=$val_bank->bank_account?>|<?=$val_bank->bank_number?>"></option>
                                                    <?php } ?>
                                                </select> </div>
                                            <p class="text-white">Note: Konfirmasi pembayaran akan dilakukkan otomatis oleh sistem 3-5 Menit setelah melakukkan transfer. Jika lebih dari 2 Jam belum menerima Email Konfirmasi Pembayaran, Silahkan melakukkan konfirmasi manual di menu status pembelian. Harap bukti pembayaran disimpan jika sewaktu-waktu pembayaran terjadi masalah. </p>
                                            </div> <!-- End -->

                                        <!-- Qris card info-->
                                        <div id="qris" class="tab-pane fade pt-3">
                                            <h6 class="pb-2 text-white text-center">Scan pembayaran Qris bisa dilakukkan di</h6>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col"><img src="<?=config_item('_dir_website')?>lembaga/grandsbmptn/master_pembayaran/doku.png" class="img-fluid" width="200"></div>
                                                    <div class="col"><img src="<?=config_item('_dir_website')?>lembaga/grandsbmptn/master_pembayaran/shopeepay.png" class="img-fluid" width="200"></div>
                                                    <div class="col"><img src="<?=config_item('_dir_website')?>lembaga/grandsbmptn/master_pembayaran/gopay.png" class="img-fluid" width="200"></div>
                                                    <div class="w-100"></div>
                                                    <div class="col"><img src="<?=config_item('_dir_website')?>lembaga/grandsbmptn/master_pembayaran/dana.png" class="img-fluid" width="200"></div>
                                                    <div class="col"><img src="<?=config_item('_dir_website')?>lembaga/grandsbmptn/master_pembayaran/ovo.png" class="img-fluid" width="200"></div>
                                                    <div class="col"><img src="<?=config_item('_dir_website')?>lembaga/grandsbmptn/master_pembayaran/linkaja.png" class="img-fluid" width="200"></div>
                                                </div>
                                            </div>
                                            <p class="text-white"> Note: Konfirmasi pembayaran Qris dilakukkan secara manual, dengan melakukkan upload bukti pembayaran ke menu status pembelian. </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <input id="payment_choosen" type="hidden" name="payment_choosen" value="1">
                        <button type="submit" class="btn btn-md btn-primary text-uppercase"> Submit </button>
                        <a href="<?=base_url()?>buku/sbmptn" class="btn btn-md btn-outline-secondary"> Kembali </a>
                    </div>
                    </form>
                    <hr />
                </article> <!-- card-body.// -->
            </aside> <!-- col.// -->
        </div> <!-- row.// -->
    </div> <!-- card.// -->
</div>
<!--container.//-->