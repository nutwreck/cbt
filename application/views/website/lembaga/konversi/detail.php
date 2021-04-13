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
                                        <th>Judul Konversi</th>                                   
                                        <th>Aksi</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($konversi_data as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$value->name?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?=base_url()?>admin/edit-konversi/<?=urlencode(base64_encode($value->id))?>" class="btn btn-sm btn-primary mr-1 "><i class="fa fa-pencil"></i></a>
                                                <a href="<?=base_url()?>admin/disable-konversi-skor/<?=urlencode(base64_encode($value->id))?>" class="btn btn-sm btn-danger" onclick="return confirm(<?=$value->id?>)"><i class="fa fa-trash"></i></a>
                                                <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Aksi
                                                 </button>
                                                     <div class="dropdown-menu" aria-labelledby="Aksi">
                                                     <a class="dropdown-item" href="<?=base_url()?>admin/detail-konversi/<?=urlencode(base64_encode($value->id))?>">Detail Konversi Skor</a>
                                                     </div>
                                                    </div>              
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