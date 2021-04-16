 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Detail Buku</h2>
                        </div>
                    </div>
                </div>
                     
                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Jenis Soal</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select id="pilihan_jenis_soal" class="form-control selectpicker" data-live-search="true" data-width="auto" name="jenis_soal" required onchange="choosen_exam()">
                                               
                                                    <option data-tokens="0" value="0"></option>
                                                    <option data-tokens="Gambar" value="1">Gambar</option>
                                                    <option data-tokens="Audio" value="2">Audio</option>
                                                    <option data-tokens="Video" value="3">Video</option>
                                                    <option data-tokens="Text" value="4">Text</option>
                                                    <option data-tokens="Link" value="5">Link</option>
                                               
                                            </select>
                                            <small for="jenis_soal" id="jenis_soal_er" class="bg-danger text-white"></small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                               
                                    <div id="upload_gambar" class="col-sm-12 col-lg-3" style="margin-top:0.3%">          
                                    <form method="post" action="<?php echo base_url(); ?>website/lembaga/Buku_setting/save_gambar" enctype="multipart/form-data" >
                                    <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                     <input type="hidden" id="id_buku" name="id_buku" value="<?=$id_buku?>" >
                                            <h5 class="label-text">Select Image :</h5>
                                            <input type="file" id="namafile" name="namafile" >                                          
                                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">                                  
                                            </i>submit
                                            </button>
                                            </form>    
                                    </div> 
                                                                  
                                </div>
                                <div class="row">
                                <div id="upload_audio" class="col-sm-12 col-lg-3" style="margin-top:0.3%">          
                                    <form method="post" action="<?php echo base_url(); ?>website/lembaga/Buku_setting/save_audio" enctype="multipart/form-data" >
                                    <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                     <input type="hidden" id="id_buku" name="id_buku" value="<?=$id_buku?>" >
                                            <h5 class="label-text">Select Audio :</h5>
                                            <input type="file" id="fileaudio" name="fileaudio" >                                          
                                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">                                  
                                            </i>submit
                                            </button>
                                            </form>    
                                    </div> 
                                    
                                </div>
                                <div class="row">
                                    <div id="upload_video" class="col-sm-12 col-lg-3" style="margin-top:0.3%">      
                                    <form method="post" action="<?php echo base_url(); ?>website/lembaga/Buku_setting/save_video" enctype="multipart/form-data" >
                                    <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">                              
                                    <input type="hidden" id="id_buku" name="id_buku" value="<?=$id_buku?>" >       
                                            <h5 class="label-text">Select Video :</h5>
                                            <input type="file" id="filevideo" name="filevideo" >                                          
                                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">                                  
                                            </i>submit
                                            </button>
                                            </form>
                                    
                                    </div>                                   
                                </div>
                                <div class="row">
                                    <div id="upload_text" class="col-sm-12 col-lg-9">
                                    <form method="post" action="<?php echo base_url(); ?>website/lembaga/Buku_setting/save_text" enctype="multipart/form-data" >
                                    <input type="hidden" id="csrf-hash-form-text" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">                              
                                    <input  type="hidden" id="id_buku" name="id_buku" value="<?=$id_buku?>" >       

                                        <div class="form-group">
                                            <textarea class="summernote note-math-dialog" id="summernote" name="summernote" rows='10'></textarea>
                                        </div>
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">                                  
                                            </i>submit
                                            </button>
                                            </form>
                                    </div>
                                
                                </div>

                                <div class="row">
                                    <div id="upload_link" class="col-sm-12 col-lg-3" style="margin-top:0.3%">
                                    <form method="post" action="<?php echo base_url(); ?>website/lembaga/Buku_setting/save_link" enctype="multipart/form-data" >
                                    <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                    <input  type="hidden" id="id_buku" name="id_buku" value="<?=$id_buku?>" > 
                                        <h5 class="label-text">Masukan Link : </h5>
                                          <input id="link" name="link" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan link" required>
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">                                  
                                            </i>submit
                                            </button>
                                            </form>
                                    </div>
                                    
                                </div>


                <div class="row mt-3">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <div class="table-data__tool">
                       
                        <div class="table-responsive table-responsive-data2">
                            <table id="table_materi" class="display text-center">
                                <thead>
                                    <tr>
                                        <th width="15px">No.</th>
                                        <th>Nama File</th>    
                                                                    
                                        <th>Aksi</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($detail_buku as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$value->nama_file?></td>
                                       
                                        <td>
                                            <div class="table-data-feature">
                                            <a href="<?php echo base_url(); ?>admin/edit-buku-detail/<?php echo $value->id; ?>" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                                </a>
                                                <a href="<?=base_url()?>admin/disable-buku-detail/<?=urlencode(base64_encode($value->id))?>" class="item" onclick="return confirm(<?=$value->id?>)">
                                                <i class="zmdi zmdi-delete"></i>
                                        </td>                                     
                                      
                                    </tr>
                                    
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>