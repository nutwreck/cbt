 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="overview-wrap">
                            <h2 class="title-1">Daftar Soal</h2>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 button-config">
                        <a href="<?=base_url()?>lembaga/add-soal/<?=$id_paket_soal?>" class="btn btn-sm btn-primary m-1">Tambah Soal</a>
                        <button class="btn btn-sm btn-danger m-1">Kosongkan</button>
                        <button class="btn btn-sm btn-outline-secondary m-1" onclick="return toggle_soal()">Toogle Soal</button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="box-head">
                            <table class="table table-borderless text-left">
                                <tr>
                                    <td width="20%"><p>Nama Paket Soal</p></td><td width="2%"><p>:</p></td><td><p>UAS Semester Ganjil</p></td>
                                </tr>
                                <tr>
                                    <td width="20%"><p>Materi</p></td><td width="2%"><p>:</p></td><td><p>PENALARAN UMUM KELAS SMA 12</p></td>
                                </tr>
                                <tr>
                                    <td width="20%"><p>Jumlah Soal</p></td><td width="2%"><p>:</p></td><td><p class="text-danger">Belum Ada Soal</p></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div id="lembar_soal" class="col-sm-12 col-md-8 mb-3">
                        <div class="card text-left h-100">
                            <div class="card-header bg-primary text-white">
                                <div class="row">
                                    <div class="col-8 p-1">
                                        <h5 class="text-white">
                                            <i class="fa fa-braille" aria-hidden="true"></i> Soal No 2 
                                            <span class="badge badge-success">Pilihan Ganda</span>
                                            <span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i> Acak Soal</span>
                                            <span class="badge badge-danger"><i class="fa fa-close" aria-hidden="true"></i> Acak Jawaban</span>
                                        </h5>
                                    </div>
                                    <div class="col-4 text-right">
                                        <button class="btn btn-sm btn-success" title="Edit Soal"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        <button class="btn btn-sm btn-danger" title="Hapus Soal"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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
                        </div>
                    </div>
                    <div id="panel-toogle-soal" class="col-sm-12 col-md-4 mb-3" style="display:block;">
                        <div class="card text-center">
                            <h5 class="m-3">Navigasi Soal</h5>
                            <div class="card-body text-white btn-navigasi">
                                <button class="btn button-round btn-outline-secondary">1</button>
                                <button class="btn button-round btn-outline-secondary">2</button>
                                <button class="btn button-round btn-outline-secondary">3</button>
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