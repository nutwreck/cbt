<!-- Page Content  -->
<div class="isi-content">
    <div class="row">
        <div class="col-sm-12">
            <?php if($status_user == 'free' && $free_paket > 0) { ?>
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span class="glyphicon glyphicon-info-sign"></span><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Informasi</strong>
                    <hr class="message-inner-separator">
                        <p>Selamat, Anda berhak mendapatkan <?=$free_paket?> Paket <b>Soal CPNS secara GRATIS</b>. Untuk mendapatkan seluruh paket soal CPNS dan Materi silahkan melakukkan <b>pembelian Paket Soal CPNS</b> dengan cara klik beli dibawah ini <!-- <a href="<?=base_url()?>pembelian-buku/<?=$cpns_id?>" class="btn btn-sm btn-success">Klik Disini</a> --></p>
                </div>
            <?php } elseif($status_user == 'free') { ?>
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span class="glyphicon glyphicon-info-sign"></span><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Informasi</strong>
                    <hr class="message-inner-separator">
                        <p>Untuk mendapatkan seluruh paket Soal dan Materi silahkan melakukkan <b>pembelian Paket Soal CPNS</b> dengan cara klik beli dibawah ini <!-- <a href="<?=base_url()?>pembelian-buku/<?=$cpns_id?>" class="btn btn-sm btn-success">Klik Disini</a> --></p>
                </div>
            <?php } ?>
            <?php if($status_user == 'free') { ?>
                <div class="bg-book">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-5">
                            <img src="<?=config_item('_assets_general')?>image/book/cpns.png" class="img-fluid mb-3" width="300">
                            <h4 class="font-arial-bold text-center text-secondary">Lolos CPNS <br />Instansi Terbaik !!</h4>
                            <div class="text-center">
                                <a href="<?=base_url()?>pembelian-buku/<?=$cpns_id?>"><img src="<?=config_item('_assets_general')?>image/book/beli-cpns.png" class="img-fluid mb-3" width="200"></a>
                            </div>
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
                <div id="main">
                    <div class="container">
                        <div class="accordion" id="faq">
                            <?php if(isset($cpns_paket)){ ?>
                            <div class="card">
                                <div class="card-header" id="faqhead1">
                                    <a href="#" class="btn btn-header-link <?=$group_stat == 1 ? 'collapsed' : ''?>" data-toggle="collapse" data-target="#faq1"
                                    aria-expanded="true" aria-controls="faq1">Paket Soal</a>
                                </div>

                                <div id="faq1" class="collapse <?=$group_stat == 1 ? '' : 'show'?>" aria-labelledby="faqhead1" data-parent="#faq">
                                    <div class="card-body">
                                        <div class="row">
                                            <?php foreach($cpns_paket as $val_paket){ ?>
                                            <div class="col-sm-12 col-md-6 col-lg-4 mt-3 mb-3">
                                                <div class="p-2 bg-paket-soal">
                                                    <div class="font-arial-bold text-center text-secondary sesi-head">
                                                        <?=ucwords(strtolower($val_paket->nama_paket_soal))?>
                                                    </div>
                                                    <hr />
                                                    <table class="table-responsive mb-0 sesi-detail">
                                                    <?php if(empty($val_paket->tgl_selesai) && $val_paket->status == 0 && !empty($val_paket->id_ujian)){ ?>
                                                        <tr>
                                                            <td colspan="3"><span class="badge badge-danger">Anda belum selesai mengerjakan paket soal ini! <?=$val_paket->tgl_selesai?> <?=$val_paket->status?></span></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php if($val_paket->is_free == 1) { ?>
                                                        <tr>
                                                            <td colspan="3"><img src="<?=config_item('_assets_website')?>image/book/cpns_free.png" class="img-fluid border border-secondary" width="300"></td>
                                                        </tr>
                                                    <?php } else { ?>
                                                        <tr>
                                                            <td colspan="3"><img src="<?=config_item('_assets_website')?>image/book/cpns_purchase.png" class="img-fluid border border-secondary" width="300"></td>
                                                        </tr>
                                                    <?php } ?>
                                                        <tr>
                                                            <td><i class="fas fa-book"></i> Nama Materi</td><td>:</td><td><?=$val_paket->materi_name?> <?=!empty($val_paket->detail_buku_name) || $val_paket->detail_buku_name != '' ? '('.$val_paket->detail_buku_name.')' : ''?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-braille" aria-hidden="true"></i> Jumlah Soal</td><td>:</td><td><?=$val_paket->total_soal?> Butir Soal</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fas fa-shopping-cart"></i> Jenis Paket</td><td>:</td><td><?=$val_paket->is_free == 1 ? 'Free' : 'Berbayar'?></td>
                                                        </tr>
                                                    </table>
                                                    <hr />
                                                    <div class="row">
                                                        <div class="col-sm-8 offset-sm-2">
                                                            <?php if($status_user == 'free') { ?>
                                                                <?php if($val_paket->is_free == 1 && $val_paket->status == 0 && empty($val_paket->id_ujian)) { ?>
                                                                    <a href="<?=base_url()?>buku/tes/mulai/<?=urlencode(base64_encode($val_paket->paket_soal_id))?>" class="btn btn-block btn-mulai">Mulai</a>
                                                                <?php } elseif($val_paket->is_free == 1 && $val_paket->status == 0 && !empty($val_paket->id_ujian)) { ?>
                                                                    <a href="<?=base_url()?>buku/tes/mulai/<?=urlencode(base64_encode($val_paket->paket_soal_id))?>" class="btn btn-block btn-mulai">Lanjut</a>
                                                                <?php } elseif($val_paket->is_free == 1 && $val_paket->status == 1) { ?>
                                                                    <a href="<?=base_url()?>buku/tes/pembahasan/<?=urlencode(base64_encode($val_paket->id_ujian))?>/<?=urlencode(base64_encode($val_paket->paket_soal_id))?>/<?=$this->session->userdata('user_id')?>" class="btn btn-block btn-mulai">Pembahasan</a>
                                                                <?php } else { ?>
                                                                    <button class="btn btn-block btn-mulai isDisabled" onclick="return purchase_before()"><i class="fas fa-lock"></i> Mulai</button>
                                                                <?php } ?>    
                                                            <?php } else { ?>
                                                                <?php if($val_paket->status == 0 && empty($val_paket->id_ujian)) { ?>
                                                                    <a href="<?=base_url()?>buku/tes/mulai/<?=urlencode(base64_encode($val_paket->paket_soal_id))?>" class="btn btn-block btn-mulai">Mulai</a>
                                                                <?php } elseif($val_paket->status == 0 && !empty($val_paket->id_ujian)) { ?>
                                                                    <a href="<?=base_url()?>buku/tes/mulai/<?=urlencode(base64_encode($val_paket->paket_soal_id))?>" class="btn btn-block btn-mulai">Lanjut</a>
                                                                <?php } else { ?>
                                                                    <a href="<?=base_url()?>buku/tes/pembahasan/<?=urlencode(base64_encode($val_paket->id_ujian))?>/<?=urlencode(base64_encode($val_paket->paket_soal_id))?>/<?=$this->session->userdata('user_id')?>" class="btn btn-block btn-mulai">Pembahasan</a>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } else { echo ''; }?>
                            <!--MATERI-->
                            <?php if($status_user == 'purchase' && isset($buku_group)){ ?>
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
                                                <?php if($this->uri->segment(3) == 'back' || $this->uri->segment(3) == 'launch'){ echo ''; } else { ?>
                                                    <div class="col-sm-12 text-left">
                                                        <a href="<?=base_url()?>buku/cpns/back#faq2" class="pointer">
                                                            <i class="fas fa-arrow-left"></i> Kembali
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            <?php } else { echo ''; } ?>
                                            <?php foreach($buku_group as $val_group) { ?>
                                            <div class="col-sm-12 col-md-6 col-lg-4 mt-3 mb-3">
                                                <?php if($group_stat == 1 && isset($val_group->nama_file) && isset($val_group->type_file)) {
                                                    $type_file = $val_group->type_file;
                                                    $nama_file = $val_group->nama_file;
                                                    if($type_file == 1){
                                                        $icon_folder = '<i class="fas fa-image fa-3x"></i>';
                                                        $access = base_url().'buku/download/'.$val_group->id;
                                                    } elseif($type_file == 2){
                                                        $icon_folder = '<i class="fas fa-file-audio fa-3x"></i>';
                                                        $access = base_url().'buku/download/'.$val_group->id;
                                                    } elseif($type_file == 3){
                                                        if($val_group->thumbnail){
                                                            $icon_folder = '<img src="'.config_item('_dir_website').'lembaga/grandsbmptn/modul/'.$val_group->thumbnail.'" style="width:100%;">';
                                                        } else {
                                                            $icon_folder = '<i class="fas fa-video fa-3x"></i>';
                                                        }
                                                        $access = base_url().'buku/download/'.$val_group->id;
                                                    } elseif($type_file == 5){
                                                        $pattern_yt = "/youtube/";
                                                        $preg_url = preg_match($pattern_yt, $nama_file);
                                                        if($preg_url == 1){
                                                            $get_id_yt = substr(str_replace("https://www.youtube.com/watch?v=", "", $nama_file), 0, 11);
                                                            $icon_folder = '<img src="https://img.youtube.com/vi/'.$get_id_yt.'/mqdefault.jpg" style="width:100%;">';
                                                        } else {
                                                            $icon_folder = '<i class="fas fa-link fa-3x"></i>';
                                                        }
                                                        // $access = $nama_file;
                                                        $access = base_url().'buku/tonton/'.$val_group->id;
                                                    } elseif($type_file == 6){
                                                        $exp_file = explode(".", $nama_file);
                                                        $jenis_file = $exp_file[1];
                                                        $access = base_url().'buku/download/'.$val_group->id;

                                                        if($jenis_file == 'pdf'){
                                                            $icon_folder = '<i class="fas fa-file-pdf fa-3x"></i>';
                                                        } elseif($jenis_file == 'pptx'){
                                                            $icon_folder = '<i class="fas fa-file-powerpoint fa-3x"></i>';
                                                        } elseif($jenis_file == 'xlsx' || $jenis_file == 'xls'){
                                                            $icon_folder = '<i class="fas fa-file-excel fa-3x"></i>';
                                                        } elseif($jenis_file == 'docx' || $jenis_file == 'doc'){
                                                            $icon_folder = '<i class="fas fa-file-word fa-3x"></i>';
                                                        }
                                                    }
                                                ?>
                                                <a target="_blank" href="<?=$access?>">
                                                <div class="p-2 border border-secondary pointer text-center table-responsive3 h-100">
                                                    <table class="table borderless mb-0">
                                                        <tr style="height:180px;">
                                                            <td><?=$icon_folder?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><h6 style="margin-top:1px;"><?=$val_group->name?></h6></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                </a>
                                                <?php } else { ?>
                                                <a href="<?=base_url()?>buku/cpns/<?=urlencode(base64_encode($val_group->id))?>">
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
                            <?php } else { echo ''; }?>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>