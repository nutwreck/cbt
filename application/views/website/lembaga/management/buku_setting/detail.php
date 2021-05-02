 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Modul Buku <b><?=$buku_name?></b> Group <b><?=$group_buku_name?></b></h2>
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
                                <a href="<?=base_url()?>admin/group-buku/<?=$id_buku?>" class="btn btn-md btn-outline-secondary">Kembali</a>
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
                                            } elseif($value->type_file == 6){
                                                echo 'File';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="<?=base_url()?>admin/delete-detail-buku/<?=urlencode(base64_encode($value->id))?>/<?=urlencode(base64_encode($value->buku_id))?>" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
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