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
                    <div class="row">
                        <div class="col-sm-5">
                            
                        </div>
                        <div class="col-sm-7">

                        </div>
                    </div>
                    <hr>
                    <a href="#" class="btn btn-lg btn-primary text-uppercase"> Submit </a>
                </article> <!-- card-body.// -->
            </aside> <!-- col.// -->
        </div> <!-- row.// -->
    </div> <!-- card.// -->
</div>
<!--container.//-->