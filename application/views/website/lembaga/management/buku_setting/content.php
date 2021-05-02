 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Setting Buku</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="table-responsive table-responsive-data2">
                            <table id="table_setting_buku" class="display text-center">
                                <thead>
                                    <tr>
                                        <th width="15px">No</th>
                                        <th>Nama Buku</th>  
                                        <th>Jumlah Paket Gratis</th>  
                                        <th>Harga</th>                               
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($buku_data as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$value->name?></td>
                                        <td><?=$value->free_paket?></td>
                                        <td><?=$value->price?></td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="<?=base_url()?>admin/group-buku/<?=urlencode(base64_encode($value->buku_id))?>" class="item" data-toggle="tooltip" data-placement="top" title="Tambah Modul">
                                                    <i class="zmdi zmdi-plus"></i>
                                                </a>
                                                <a href="<?php echo base_url(); ?>admin/edit-buku-setting/<?php echo urlencode(base64_encode($value->id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="zmdi zmdi-edit"></i>
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