<?php
    $waktu_habis = strtotime($waktu_selesai);
    if(time() >= $waktu_habis)
    {
        redirect('ujian-berakhir', 'location', 301);
    }
?>
<div id="loading">
    <img id="loading-image" src="<?php echo config_item('_assets_website'); ?>loading/BeanEater-1s-100px.gif" alt="Loading..." /><br />
    <h5>Portal ujian sedang disiapkan. Mohon tunggu dan jangan direfresh.</h5>
</div>
<div class="container-fluid mt-100-st">
    <div class="row all-exam">
        <div class="col-sm-12 col-md-8 h-100 mb-3">
            <a data-toggle="collapse" href="#collapseInformasi" role="button" aria-expanded="true" aria-controls="collapseInformasi" class="btn btn-info btn-block py-2 shadow-sm with-chevron">
                <p class="d-flex align-items-center justify-content-between mb-0 px-3 py-2 text-white"><strong class="text-card-header"><i class="fa fa-info-circle" aria-hidden="true"></i> Informasi</strong><i class="fa fa-chevron-down"></i></p>
            </a>
            <div id="collapseInformasi" class="collapse shadow-sm show">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>Sesi Tes</td><td>:</td><td><?=ucwords($sesi_pelaksana->sesi_pelaksanaan_name)?></td>
                                </tr>
                                <tr>
                                    <td>Peserta</td><td>:</td><td><?=ucwords($this->session->userdata('peserta_name'))?> (<b><?=$this->session->userdata('no_peserta')?></b>)</td>
                                </tr>
                                <tr>
                                    <td>Materi</td><td>:</td><td><?=ucwords(strtolower($sesi_pelaksana->materi_name))?> - <b><?=$sesi_pelaksana->total_soal?> Butir Soal</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 h-100 mb-3">
            <a data-toggle="collapse" href="#collapseTimer" role="button" aria-expanded="true" aria-controls="collapseTimer" class="btn btn-warning btn-block py-2 shadow-sm with-chevron">
                <p class="d-flex align-items-center justify-content-between mb-0 px-3 py-2 text-white"><strong class="text-card-header"><i class="fa fa-window-maximize" aria-hidden="true"></i> Panel</strong><i class="fa fa-chevron-down"></i></p>
            </a>
            <div id="collapseTimer" class="collapse shadow-sm show">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="sisawaktu-title font-poppins">Sisa Waktu</h5>
                            <span class="sisawaktu font-arial-bold" data-time="<?=$waktu_selesai?>"></span>
                            <input type="hidden" id="waktusekarang" value="<?=$waktu_sekarang?>">
                            <div class="row mt-3">
                                <div class="col">
                                    <button id="button-nav" class="btn btn-md btn-primary" onclick="toggle_soal()"><i id="toogle-navigasi-ico" class="fa fa-chevron-circle-up" aria-hidden="true"></i> Navigasi</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-md btn-success" onclick="done_soal()"><i class="fa fa-check-circle" aria-hidden="true"></i> Selesai</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row tampilan_soal_jwb">
        <div id="lembar_soal" class="col-sm-12 col-md-8 mb-3">
            <?=form_open('', array('id'=>'ujian'), array('id'=> $ujian_id, 'random_secure' => $random_secure));?>
                <h3 class="box-title" style="display:none;"><span class="badge bg-blue">Soal #<span id="soalke"></span> </span></h3>
                <?=$lembar_jawaban?>
                <input type="hidden" name="jml_soal" id="jml_soal" value="<?=$jumlah_soal; ?>">
            <?=form_close();?>
        </div>
        <div id="panel-toogle-soal" class="col-sm-12 col-md-4 mb-3" style="display:block;">
            <div class="card text-center font-poppins">
                <h5 class="m-3">Navigasi Soal</h5>
                <div id="tampil_jawaban" class="card-body text-white btn-navigasi">
                
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="alert-away" class="modal">

  <!-- Modal content -->
  <div class="modal-content text-center bg-warning font-poppins">
    <p id="msg_title_away" class="text-white"></p>
    <p id="msg_content_away" class="text-white"></p>
    <p class="text-white"><span id="countdownblocktimer">0</span> Detik lagi</p>
    <p id="msg_footer_away" class="text-white"></p>
  </div>

</div>

<!-- Modal -->
<div class="modal" id="petunjukModal" data-backdrop="false">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 id="title-group" class="modal-title"></h4>
        </div>
        <div id="body-group" class="modal-body">

        </div>
        <div id="footer-group" class="modal-footer">
            
        </div>
    </div>
</div>