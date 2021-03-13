<?php
$waktu_habis = strtotime('2021-03-13 19:34:40');
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
        <div data-intro="Menampilkan sisa waktu pengerjaan tes anda." data-position="left" class="col-sm-12 col-md-4 h-100 mb-3">
            <a data-toggle="collapse" href="#collapseTimer" role="button" aria-expanded="true" aria-controls="collapseTimer" class="btn btn-warning btn-block py-2 shadow-sm with-chevron">
                <p class="d-flex align-items-center justify-content-between mb-0 px-3 py-2 text-white"><strong class="text-card-header"><i class="fa fa-window-maximize" aria-hidden="true"></i> Panel</strong><i class="fa fa-chevron-down"></i></p>
            </a>
            <div id="collapseTimer" class="collapse shadow-sm show">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="sisawaktu-title font-poppins">Sisa Waktu</h5>
                            <span class="sisawaktu font-arial-bold" data-time="2021-03-13 19:34:40"></span>
                            <div class="row mt-3">
                                <div class="col">
                                    <button class="btn btn-md btn-primary" onclick="toggle_soal()"><i id="toogle-navigasi-ico" class="fa fa-chevron-circle-up" aria-hidden="true"></i> Navigasi</button>
                                </div>
                                <div class="col">
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
                            <button id="_increase" class="btn btn-sm text-primary bg-white"><i class="fa fa-plus-square" aria-hidden="true" title="Zoom In"></i></button>
                            <button id="_reset" class="btn btn-sm text-primary bg-white"><i class="fa fa-refresh" aria-hidden="true" title="Default"></i></button>
                            <button id="_decrease" class="btn btn-sm text-primary bg-white"><i class="fa fa-minus-square" aria-hidden="true" title="Zoom Out"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-text text-justify"><!-- <p class="math">$$\begin{rcases}
                    a &\text{if } b \\
                    c &\text{if } d
                    \end{rcases}⇒…$$</p> --><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cokelat yang sering meniadi   primadona   untuk  memulihkan  rasa stres ternyata   dapat  mencegah  pertumbuhan  jerawat  yang sedang  diderita oleh    seseorang.   Sebuah  penelitian   yang  dilakukan   oleh    mahasiswa kedokteran    di   University     of   Miami     School     of   Medicine      berhasil menemukan  cokelat  memiliki    peran  mencegah    pertumbuhan  jerawat. Responden dalam   penelitian  tersebut  terdiri  atas sepuluh   pria  berusia 18 hingga 35 tahun.  Mereka diminta  memakan  cokelat murni sebanyak tiga hingga empat ons. Setelah  itu mereka harus diet  selama  seminggu. Selama proses diet inilah ditemukan  hormon jerawat yang kian hari kian memburuk.</p> <p></p></div>
                    <hr>
                    <div class="funkyradio text-justify">
                        <div class="funkyradio-success">
                            <input type="radio" id="opsi_a" name="opsi" value="A"> 
                            <label for="opsi_a">
                                <div class="huruf_opsi">A</div> 
                                <div class="card-text"><!-- <p class="math">$$\begin{rcases}
                                    a &\text{if } b \\
                                    c &\text{if } d
                                    \end{rcases}⇒…$$</p> -->Gangguan darah menjadi penyebab stroke otak dan mata Gangguan darah menjadi penyebab stroke otak dan mata Gangguan darah menjadi penyebab stroke otak dan mata Gangguan darah menjadi penyebab stroke otak dan mata Gangguan darah menjadi penyebab stroke otak dan mata</div>
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
                        <div class="col">
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
                <div class="card-body text-white">
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
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content text-center bg-warning font-poppins">
    <p id="msg_title_away" class="text-white"></p>
    <p id="msg_content_away" class="text-white"></p>
    <p id="msg_footer_away" class="text-white"></p>
  </div>

</div>