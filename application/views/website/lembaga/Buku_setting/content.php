 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Konversi</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <div class="table-data__tool">
                            <div class="table-data__tool-right">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="add_data()">
                                    <i class="zmdi zmdi-plus"></i>Tambah
                                </button>
                               
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-data2">
                            <table id="table_materi" class="display text-center">
                                <thead>
                                    <tr>
                                        <th width="15px">No.</th>
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

                                                <a href="<?=base_url()?>admin/detail-buku/<?=urlencode(base64_encode($value->id))?>" class="item" onclick="return confirm(<?=$value->id?>)">
                                                <i class="zmdi zmdi-plus"></i>
                                                </a>
                                               
                                                <a href="<?php echo base_url(); ?>admin/edit-buku/<?php echo $value->id; ?>" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                                </a>
                                                <a href="<?=base_url()?>admin/disable-buku/<?=urlencode(base64_encode($value->id))?>" class="item" onclick="return confirm(<?=$value->id?>)">
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