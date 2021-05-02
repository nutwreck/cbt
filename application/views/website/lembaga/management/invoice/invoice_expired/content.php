<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">All Expired Invoice</h3>
                    <div class="table-data__tool">
                        <div class="table-data__tool-right">
                            <button id="add" class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="export_data()">
                                <i class="zmdi zmdi-download"></i>Export Data
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                    <p id="csrf-hash" style="display: none"><?php echo $this->security->get_csrf_hash(); ?></p>
                    <table id="table" class="display responsive nowrap text-center" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Aksi</th>
                                <th>Invoice</th>
                                <th>Status Invoice</th>
                                <th>Price</th>
                                <th>Payment</th>
                                <th>Buku</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>No Telp</th>
                                <th>Voucher</th>
                                <th>Potongan</th>
                                <th>Tanggal Invoice</th>
                                <th>Tanggal Expired</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>