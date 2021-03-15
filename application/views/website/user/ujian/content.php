<?php
$waktu_habis = strtotime('2021-03-15 19:34:40');
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
                                    <td>Sesi Tes</td><td>:</td><td>UTBK Online</td>
                                </tr>
                                <tr>
                                    <td>Peserta</td><td>:</td><td>Candra Aji Pamungkas (<b>2021031000001</b>)</td>
                                </tr>
                                <tr>
                                    <td>Materi</td><td>:</td><td>Penalaran Umum - <b>10 Butir Soal</b></td>
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
                            <span class="sisawaktu font-arial-bold" data-intro="Sisa waktu pengerjaan anda." data-position="left" data-time="2021-03-15 19:34:40"></span>
                            <div class="row mt-3">
                                <div class="col" data-intro="Untuk menampilkan dan menyembunyikan navigasi soal." data-position="left">
                                    <button class="btn btn-md btn-primary" onclick="toggle_soal()"><i id="toogle-navigasi-ico" class="fa fa-chevron-circle-up" aria-hidden="true"></i> Navigasi</button>
                                </div>
                                <div class="col" data-intro="Jika anda sudah selesai mengerjakan sebelum waktu habis." data-position="left">
                                    <button class="btn btn-md btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Selesai</button>
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
            <div class="card text-left h-100 font-poppins">
                <div class="card-header bg-primary text-white">
                    <div class="row">
                        <div class="col">
                            <h5><i class="fa fa-braille" aria-hidden="true"></i> Soal No #2 / 10</h5>
                        </div>
                        <div class="col text-right">
                            <button id="_increase" class="btn btn-sm text-primary bg-white" data-intro="Memperbesar ukuran huruf pada lembar soal anda." data-position="up"><i class="fa fa-plus-square" aria-hidden="true" title="Zoom In"></i></button>
                            <button id="_reset" class="btn btn-sm text-primary bg-white" data-intro="Mengembalikan ukuran huruf seperti semula pada lembar soal anda." data-position="up"><i class="fa fa-refresh" aria-hidden="true" title="Default"></i></button>
                            <button id="_decrease" class="btn btn-sm text-primary bg-white" data-intro="Memperkecil ukuran huruf pada lembar soal anda." data-position="up"><i class="fa fa-minus-square" aria-hidden="true" title="Zoom Out"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-text text-justify"><p class="math">$$\begin{rcases}
                    a &\text{if } b \\
                    c &\text{if } d
                    \end{rcases}⇒…$$</p><p>Benda apakah itu?</p>
                    </div>
                    <hr>
                    <div class="card-text mt-2">
                        <p><b>Pilih salah satu jawaban!</b></p>
                    </div>
                    <div class="funkyradio text-justify">
                        <div class="funkyradio-success">
                            <input type="radio" id="opsi_a" name="opsi" value="A"> 
                            <label for="opsi_a">
                                <div class="huruf_opsi">A</div> 
                                <div class="card-text"><p class="math">$$\begin{rcases}
                                    a &\text{if } b \\
                                    c &\text{if } d
                                    \end{rcases}⇒…$$</p></div>
                            </label>
                        </div>
                        <div class="funkyradio-success">
                            <input type="radio" id="opsi_b" name="opsi" value="B"> 
                            <label for="opsi_b">
                                <div class="huruf_opsi">B</div> 
                                <div class="card-text"><p class="math">$$\begin{Vmatrix}
                                    a & b \\
                                    c & d
                                    \end{Vmatrix}$$</p></div>
                            </label>
                        </div>
                        <div class="funkyradio-success">
                            <input type="radio" id="opsi_c" name="opsi" value="C"> 
                            <label for="opsi_c">
                                <div class="huruf_opsi">C</div> 
                                <div class="card-text"><p class="math">$$x = \begin{cases}
                                    a &\text{if } b \\
                                    c &\text{if } d
                                    \end{cases}$$</p></div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <div class="row text-center">
                        <div class="col">
                            <button class="btn btn-md btn-primary">No 1</button>
                        </div>
                        <div class="col" data-intro="Membantu untuk menandai soal jika dirasa anda ragu untuk menjawabnya. Akan muncul warna oranye pada navigasi soal." data-position="up">
                            <button class="btn btn-md btn-warning">Ragu</button>
                        </div>
                        <div class="col">
                            <button class="btn btn-md btn-primary">No 3</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="panel-toogle-soal" data-intro="Menampilkan nomor soal untuk membantu anda mengakses halaman soal lebih cepat." data-position="up" class="col-sm-12 col-md-4 mb-3" style="display:block;">
            <div class="card text-center font-poppins">
                <h5 class="m-3">Navigasi Soal</h5>
                <div class="card-body text-white btn-navigasi">
                    <button class="btn button-round btn-success">1</button>
                    <button class="btn button-round btn-outline-secondary">2</button>
                    <button class="btn button-round btn-warning">3</button>
                    <button class="btn button-round btn-outline-secondary">4</button>
                    <button class="btn button-round btn-outline-secondary">5</button>
                    <button class="btn button-round btn-outline-secondary">6</button>
                    <button class="btn button-round btn-outline-secondary">7</button>
                    <button class="btn button-round btn-outline-secondary">8</button>
                    <button class="btn button-round btn-outline-secondary">9</button>
                    <button class="btn button-round btn-outline-secondary">10</button>
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