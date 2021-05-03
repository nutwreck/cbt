<!-- Page Content  -->
<div class="isi-content">
    <div class="row">
        <div class="col-sm-12">
            <?php if($status_user == 'free' && $free_paket > 0) { ?>
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span class="glyphicon glyphicon-info-sign"></span><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Informasi</strong>
                    <hr class="message-inner-separator">
                        <p>Selamat, Anda berhak mendapatkan <?=$free_paket?> Paket <b>TryOut SBMPTN secara GRATIS</b>. Untuk mendapatkan seluruh paket TryOut silahkan melakukkan <b>pembelian Paket TryOut SBMPTN</b> dengan cara <a href="<?=base_url()?>pembelian-buku/<?=$sbmptn_id?>" class="btn btn-sm btn-success">Klik Disini</a></p>
                </div>
            <?php } elseif($status_user == 'free') { ?>
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span class="glyphicon glyphicon-info-sign"></span><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Informasi</strong>
                    <hr class="message-inner-separator">
                        <p>Untuk mendapatkan seluruh paket TryOut silahkan melakukkan <b>pembelian Paket TryOut SBMPTN</b> dengan cara <a href="<?=base_url()?>pembelian-buku/<?=$sbmptn_id?>" class="btn btn-sm btn-success">Klik Disini</a></p>
                </div>
            <?php } else {  ?>
                <div id="main">
                    <div class="container">
                        <div class="accordion" id="faq">
                            <div class="card">
                                <div class="card-header" id="faqhead1">
                                    <a href="#" class="btn btn-header-link <?=$group_stat == 1 ? 'collapsed' : ''?>" data-toggle="collapse" data-target="#faq1"
                                    aria-expanded="true" aria-controls="faq1">Paket Soal</a>
                                </div>

                                <div id="faq1" class="collapse <?=$group_stat == 1 ? '' : 'show'?>" aria-labelledby="faqhead1" data-parent="#faq">
                                    <div class="card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf
                                        moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                                        Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                        shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea
                                        proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim
                                        aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="faqhead2">
                                    <a href="#" class="btn btn-header-link <?=$group_stat == 1 ? '' : 'collapsed'?>" data-toggle="collapse" data-target="#faq2"
                                    aria-expanded="true" aria-controls="faq2">Materi</a>
                                </div>

                                <div id="faq2" class="collapse <?=$group_stat == 1 ? 'show' : ''?>" aria-labelledby="faqhead2" data-parent="#faq">
                                    <div class="card-body">
                                        <div class="row">
                                            <?php if($group_stat == 1){ ?>
                                                <div class="col-sm-12">
                                                    <div class="alert alert-info">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                        <span class="glyphicon glyphicon-info-sign"></span><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Informasi</strong>
                                                        <hr class="message-inner-separator">
                                                            <p>Klik pada area file untuk mendownload / mengakses file.</p>
                                                    </div>
                                                </div>
                                            <?php } else { echo ''; } ?>
                                            <?php foreach($buku_group as $val_group) { ?>
                                            <div class="col-sm-12 col-md-6 col-lg-4 mt-3 mb-3">
                                                <?php if($group_stat == 1 && isset($val_group->nama_file) && isset($val_group->type_file)) {
                                                    $type_file = $val_group->type_file;
                                                    $nama_file = $val_group->nama_file;
                                                    if($type_file == 1){
                                                        $icon_folder = 'fas fa-image';
                                                        $access = base_url().'buku/download/'.$val_group->id;
                                                    } elseif($type_file == 2){
                                                        $icon_folder = 'fas fa-file-audio';
                                                        $access = base_url().'buku/download/'.$val_group->id;
                                                    } elseif($type_file == 3){
                                                        $icon_folder = 'fas fa-video';
                                                        $access = base_url().'buku/download/'.$val_group->id;
                                                    } elseif($type_file == 5){
                                                        $icon_folder = 'fas fa-link';
                                                        $access = $nama_file;
                                                    } elseif($type_file == 6){
                                                        $exp_file = explode(".", $nama_file);
                                                        $jenis_file = $exp_file[1];
                                                        $access = base_url().'buku/download/'.$val_group->id;

                                                        if($jenis_file == 'pdf'){
                                                            $icon_folder = 'fas fa-file-pdf';
                                                        } elseif($jenis_file == 'pptx'){
                                                            $icon_folder = 'fas fa-file-powerpoint';
                                                        } elseif($jenis_file == 'xlsx' || $jenis_file == 'xls'){
                                                            $icon_folder = 'fas fa-file-excel';
                                                        } elseif($jenis_file == 'docx' || $jenis_file == 'doc'){
                                                            $icon_folder = 'fas fa-file-word';
                                                        }
                                                    }
                                                ?>
                                                <a target="_blank" href="<?=$access?>">
                                                <div class="p-2 border border-secondary pointer">
                                                    <table class="table-responsive mb-0">
                                                        <tr>
                                                            <td><i class="<?=$icon_folder?> mr-2"></i></td>
                                                            <td><h6 style="margin-top:5px;"><?=$val_group->name?></h6></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                </a>
                                                <?php } else { ?>
                                                <a href="<?=base_url()?>buku/sbmptn/<?=urlencode(base64_encode($val_group->id))?>">
                                                <div class="p-2 border border-secondary pointer">
                                                    <table class="table-responsive mb-0">
                                                        <tr>
                                                            <td><i class="fas fa-folder-open mr-2"></i></td>
                                                            <td><h6 style="margin-top:5px;"><?=$val_group->name?></h6></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                </a>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>