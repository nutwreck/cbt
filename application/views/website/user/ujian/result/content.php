<div class="container-fluid mt-100-st">
    <div class="row">
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
                                <?php if($is_ranking == 1) { ?>
                                <tr>
                                    <td>Ranking</td><td>:</td><td><?=$ranking_user?> Dari <?=$total_user?></td>
                                </tr>
                                <?php } else { echo ''; } ?>
                                <tr>
                                    <td>Nilai / Score</td><td>:</td><td><?=ROUND($ujian->skor)?></td>
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
                            <h4 class="sisawaktu-title font-poppins">Summary</h4>
                            <div class="row mt-3">
                                <div class="col bg-success" style="outline-style: dotted; outline-width: 2px; margin:5px;">
                                    <h5 class="text-white">Benar<br /><?=$ujian->jml_benar?></h5>
                                </div>
                                <div class="col bg-danger" style="outline-style: dotted; outline-width: 2px; margin:5px;">
                                    <h5 class="text-white">Salah<br /><?=$ujian->jml_salah?></h5>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col bg-warning" style="outline-style: dotted; outline-width: 2px; margin:5px;">
                                    <h5 class="text-white">Ragu<br /><?=$ujian->jml_ragu?></h5>
                                </div>
                                <div class="col" style="outline-style: dotted; outline-width: 2px; margin:5px;">
                                    <h5>Tidak Dijawab<br /><?=$ujian->jml_kosong?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>