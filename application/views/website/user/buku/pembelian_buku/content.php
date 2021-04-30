<div class="isi-content">
    <hr>

    <div class="card">
        <div class="row">
            <aside class="col-sm-12">
                <article class="card-body p-5">
                    <h3 class="title mb-3">Paket Soal TryOut <?=$buku_data->buku_name?></h3>
                    <p class="price-detail-wrap"> 
                        <span class="price h3 text-warning"> 
                            <span class="num"><?=rupiah($buku_data->price)?></span>
                        </span> 
                    </p>
                    <dl class="item-property">
                        <dt>Description</dt>
                        <dd><p><?=$buku_data->desc?></p></dd>
                    </dl>

                    <hr>
                    <form >
                    <input type="hidden" name="id_buku" value="<?=$id_buku?>">
                    <div class="row">
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
                                <div class="form-group">
                                    <label for="detail_buku_id">Pilih Jurusan Anda</label>
                                    <small>* Paket soal yang akan ditampilkan nantinya sesuai dengan jurusan yang anda pilih.</small>
                                    <select class="form-control" id="detail_buku_id" name="detail_buku_id">
                                        <option value="1">SAINTEK (IPA)</option>
                                        <option value="2">SOSHUM (IPS)</option>
                                    </select>
                                </div>
                            <?php } else { echo ''; } ?>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-lg btn-primary text-uppercase"> Submit </button>
                    </form>
                </article> <!-- card-body.// -->
            </aside> <!-- col.// -->
        </div> <!-- row.// -->
    </div> <!-- card.// -->
</div>
<!--container.//-->