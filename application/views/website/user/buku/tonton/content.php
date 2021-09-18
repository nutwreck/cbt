<div class="container-fluid mt-100-st">
    <div class="row">
        <div class="col-sm-12 mt-3">
            <div class="text-center font-poppins">
                <div class="text-left">
                    <a href="<?=$url_back?>" class="pointer">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <h3 class="mb-3"><?=$data->name?></h3>
                <?php
                    $url_yt = str_replace("watch?v=", "embed/", $data->nama_file);
                ?>
                <div class="player">
                    <iframe class="player-video" src="<?=$url_yt?>" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>