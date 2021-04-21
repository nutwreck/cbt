<?php
$waktu_habis = strtotime($waktu_selesai);
if(time() >= $waktu_habis)
{
    $this->session->set_flashdata('error', 'Waktu ujian telah berakhir!');
    redirect('dashboard', 'location', 301);
}
?>
<div class="container-fluid mt-100-st">
    <div class="row">
        <div data-intro="Informasi tes online anda." data-position="right" class="col-sm-12 col-md-8 h-100 mb-3">
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
                            <span class="sisawaktu font-arial-bold" data-intro="Sisa waktu pengerjaan anda." data-position="left" data-time="<?=$waktu_selesai?>"></span>
                            <div class="row mt-3">
                                <div class="col" data-intro="Untuk menampilkan dan menyembunyikan navigasi soal." data-position="left">
                                    <button class="btn btn-md btn-primary" onclick="toggle_soal()"><i id="toogle-navigasi-ico" class="fa fa-chevron-circle-up" aria-hidden="true"></i> Navigasi</button>
                                </div>
                                <div class="col" data-intro="Jika anda sudah selesai mengerjakan sebelum waktu habis." data-position="left">
                                    <button class="btn btn-md btn-success" onclick="done_soal()"><i class="fa fa-check-circle" aria-hidden="true"></i> Selesai</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="lembar_soal" data-intro="Lembar soal anda." data-position="right" class="col-sm-12 col-md-8 mb-3">
            <?=form_open('', array('id'=>'ujian'), array('id'=> $ujian_id));?>
                <h3 class="box-title" style="display:none;"><span class="badge bg-blue">Soal #<span id="soalke"></span> </span></h3>
                <?=$lembar_jawaban?>
                <input type="hidden" name="jml_soal" id="jml_soal" value="<?=$jumlah_soal; ?>">
            <?=form_close();?>
        </div>
        <div id="panel-toogle-soal" data-intro="Menampilkan nomor soal untuk membantu anda mengakses halaman soal lebih cepat." data-position="up" class="col-sm-12 col-md-4 mb-3" style="display:block;">
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