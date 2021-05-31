<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div id="content_add" class="col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">Tambah Detail Modul Buku</div>
                                <div class="col text-right">
                                    <a href="<?=base_url()?>admin/detail-buku/<?=$id_buku?>" class="btn btn-sm btn-outline-secondary">Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Jenis File</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <select id="pilihan_jenis_modul" class="form-control selectpicker" data-width="auto" name="jenis_modul" required onchange="choosen_type()">
                                            <option value="-1">Pilih Tipe Modul</option>
                                            <option data-tokens="Gambar" value="1">Gambar</option>
                                            <option data-tokens="Audio" value="2">Audio</option>
                                            <option data-tokens="Video" value="3">Video</option>
                                            <!-- <option data-tokens="Text" value="4">Text</option> -->
                                            <option data-tokens="Link" value="5">Link</option>
                                            <option data-tokens="File" value="6">File</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="upload_gambar">
                                <form method="post" action="<?php echo base_url(); ?>website/lembaga/Management/save_gambar_buku_detail" enctype="multipart/form-data" >
                                <?php if(base64_decode(urldecode($id_buku)) == 2){ ?>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Tipe Jurusan</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select id="tipe_gambar" class="form-control selectpicker" data-width="auto" name="detail_buku_id">
                                                <option value = "0" selected>Pilih</option>
                                                <?php foreach($detail_jurusan as $val_detail_jurusan){ ?>
                                                    <option data-tokens="<?=$val_detail_jurusan->name?>" value="<?=$val_detail_jurusan->id?>"><?=$val_detail_jurusan->name?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Judul Modul</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="name_gambar" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Gambar</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input type="hidden" id="csrf-hash-form-gambar" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                            <input type="hidden" id="id_buku1" name="id_buku" value="<?=$id_buku?>">
                                            <input type="hidden" id="id_config_buku1" name="id_config_buku" value="<?=$id_config_buku?>">
                                            <input type="hidden" id="id_config_buku_group1" name="id_config_buku_group" value="<?=$id_config_buku_group?>">
                                            <input type="file" id="filegambar" name="filegambar">    
                                        </div>
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">                                  
                                            </i>submit
                                        </button>
                                    </div>
                                </div>
                                </form>
                            </div>

                            <div id="upload_audio">
                                <form method="post" action="<?php echo base_url(); ?>website/lembaga/Management/save_audio_buku_detail" enctype="multipart/form-data" >
                                <?php if(base64_decode(urldecode($id_buku)) == 2){ ?>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Tipe Jurusan</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select id="tipe_audio" class="form-control selectpicker" data-width="auto" name="detail_buku_id">
                                                <option value = "0" selected>Pilih</option>
                                                <?php foreach($detail_jurusan as $val_detail_jurusan){ ?>
                                                    <option data-tokens="<?=$val_detail_jurusan->name?>" value="<?=$val_detail_jurusan->id?>"><?=$val_detail_jurusan->name?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Judul Modul</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="name_audio" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Audio</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input type="hidden" id="csrf-hash-form-audio" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                            <input type="hidden" id="id_buku2" name="id_buku" value="<?=$id_buku?>">
                                            <input type="hidden" id="id_config_buku2" name="id_config_buku" value="<?=$id_config_buku?>">
                                            <input type="hidden" id="id_config_buku_group2" name="id_config_buku_group" value="<?=$id_config_buku_group?>">
                                            <input type="file" id="fileaudio" name="fileaudio">
                                        </div>
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">                                  
                                            </i>submit
                                        </button>
                                    </div>
                                </div>
                                </form>
                            </div>

                            <div id="upload_video">
                                <form method="post" action="<?php echo base_url(); ?>website/lembaga/Management/save_video_buku_detail" enctype="multipart/form-data" >
                                <?php if(base64_decode(urldecode($id_buku)) == 2){ ?>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Tipe Jurusan</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select id="tipe_video" class="form-control selectpicker" data-width="auto" name="detail_buku_id">
                                                <option value = "0" selected>Pilih</option>
                                                <?php foreach($detail_jurusan as $val_detail_jurusan){ ?>
                                                    <option data-tokens="<?=$val_detail_jurusan->name?>" value="<?=$val_detail_jurusan->id?>"><?=$val_detail_jurusan->name?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Judul Modul</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="name_video" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Thumbnail <br> <small>Maksimal (320x180) 75kb</small></h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input type="file" id="thumbnail" name="thumbnail" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Video</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input type="hidden" id="csrf-hash-form-video" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">                              
                                            <input type="hidden" id="id_buku3" name="id_buku" value="<?=$id_buku?>">
                                            <input type="hidden" id="id_config_buku3" name="id_config_buku" value="<?=$id_config_buku?>">
                                            <input type="hidden" id="id_config_buku_group3" name="id_config_buku_group" value="<?=$id_config_buku_group?>">
                                            <input type="file" id="filevideo" name="filevideo" >
                                        </div>
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">                                  
                                            </i>submit
                                        </button>
                                    </div>
                                </div>
                                </form>
                            </div>

                            <div id="upload_text">
                                <form method="post" action="<?php echo base_url(); ?>website/lembaga/Management/save_text_buku_detail" enctype="multipart/form-data" >
                                <?php if(base64_decode(urldecode($id_buku)) == 2){ ?>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Tipe Jurusan</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select id="tipe_text" class="form-control selectpicker" data-width="auto" name="detail_buku_id">
                                                <option value = "0" selected>Pilih</option>
                                                <?php foreach($detail_jurusan as $val_detail_jurusan){ ?>
                                                    <option data-tokens="<?=$val_detail_jurusan->name?>" value="<?=$val_detail_jurusan->id?>"><?=$val_detail_jurusan->name?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Judul Modul</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="name_text" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Text</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input type="hidden" id="csrf-hash-form-text" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">                              
                                            <input  type="hidden" id="id_buku4" name="id_buku" value="<?=$id_buku?>" >  
                                            <input type="hidden" id="id_config_buku4" name="id_config_buku" value="<?=$id_config_buku?>">
                                            <input type="hidden" id="id_config_buku_group4" name="id_config_buku_group" value="<?=$id_config_buku_group?>">     
                                            <div class="form-group">
                                                <textarea class="summernote note-math-dialog" id="summernote" name="summernote" rows='10'></textarea>
                                            </div>
                                        </div>
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">                                  
                                            </i>submit
                                        </button>
                                    </div>
                                </div>
                                </form>
                            </div>

                            <div id="upload_link">
                                <form method="post" action="<?php echo base_url(); ?>website/lembaga/Management/save_link_buku_detail" enctype="multipart/form-data" >
                                <?php if(base64_decode(urldecode($id_buku)) == 2){ ?>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Tipe Jurusan</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select id="tipe_link" class="form-control selectpicker" data-width="auto" name="detail_buku_id">
                                                <option value = "0" selected>Pilih</option>
                                                <?php foreach($detail_jurusan as $val_detail_jurusan){ ?>
                                                    <option data-tokens="<?=$val_detail_jurusan->name?>" value="<?=$val_detail_jurusan->id?>"><?=$val_detail_jurusan->name?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Judul Modul</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="name_link" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Link</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input type="hidden" id="csrf-hash-form-link" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                            <input  type="hidden" id="id_buku5" name="id_buku" value="<?=$id_buku?>" > 
                                            <input type="hidden" id="id_config_buku5" name="id_config_buku" value="<?=$id_config_buku?>">
                                            <input type="hidden" id="id_config_buku_group5" name="id_config_buku_group" value="<?=$id_config_buku_group?>">
                                            <input id="link" name="link" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan link">
                                        </div>
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">                                  
                                            </i>submit
                                        </button>
                                    </div>
                                </div>
                                </form>
                            </div>

                            <div id="upload_file">
                                <form method="post" action="<?php echo base_url(); ?>website/lembaga/Management/save_file_buku_detail" enctype="multipart/form-data" >
                                <?php if(base64_decode(urldecode($id_buku)) == 2){ ?>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Tipe Jurusan</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <select id="tipe_link" class="form-control selectpicker" data-width="auto" name="detail_buku_id">
                                                <option value = "0" selected>Pilih</option>
                                                <?php foreach($detail_jurusan as $val_detail_jurusan){ ?>
                                                    <option data-tokens="<?=$val_detail_jurusan->name?>" value="<?=$val_detail_jurusan->id?>"><?=$val_detail_jurusan->name?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Judul File</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input id="name_file" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                        <h5 class="label-text">Upload File (Word, Excel, PDF, PowerPoint)</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-9">
                                        <div class="form-group">
                                            <input type="hidden" id="csrf-hash-form-link" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                            <input  type="hidden" id="id_buku5" name="id_buku" value="<?=$id_buku?>" > 
                                            <input type="hidden" id="id_config_buku5" name="id_config_buku" value="<?=$id_config_buku?>">
                                            <input type="hidden" id="id_config_buku_group5" name="id_config_buku_group" value="<?=$id_config_buku_group?>">
                                            <input type="file" id="filedokumen" name="filedokumen" >
                                        </div>
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">                                  
                                            </i>submit
                                        </button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>