 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Modul Buku <b><?=$buku_name?></b></h2>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <div class="table-data__tool">
                            <div class="table-data__tool-right">
                                <button class="au-btn au-btn-icon au-btn--blue au-btn--small" onclick="add_data_detail()">
                                    <i class="zmdi zmdi-plus"></i>Tambah
                                </button>
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="return window.history.back();">Kembali</button>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-data2">
                            <table id="table_setting_buku" class="display text-center">
                                <thead>
                                    <tr>
                                        <th width="15px">No</th>
                                        <th>Judul</th>
                                        <th>Tipe File</th>         
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
                                        <td><?=$value->name?></td>
                                        <td>
                                            <?php if($value->type_file == 1){
                                                echo 'Gambar';
                                            } elseif($value->type_file == 2){
                                                echo 'Audio';
                                            } elseif($value->type_file == 3){
                                                echo 'Video';
                                            } elseif($value->type_file == 4){
                                                echo 'Text';
                                            } elseif($value->type_file == 5){
                                                echo 'Link';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="<?php echo base_url(); ?>admin/edit-buku-detail/<?=urlencode(base64_encode($value->id))?>" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </a>
                                                <a href="<?=base_url()?>admin/disable-buku-detail/<?=urlencode(base64_encode($value->id))?>" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>