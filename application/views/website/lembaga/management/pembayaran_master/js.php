<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_pembayaran').DataTable( {
            
        } );

        $('#table_detail_pembayaran').DataTable( {
            
        } );
    } );

    function add_data() {
        window.location.href = "<?php echo base_url(); ?>admin/add-detail-pembayaran-master/<?php if(isset($id_pembayaran_master)){ echo $id_pembayaran_master; } else { echo ''; }; ?>";
    }
</script>

<!-- Nama file logo muncul saat upload -->
<script>
    if (document.getElementById('logo_payment') != null) {
        document.querySelector("#logo_payment").onchange = function(){
            document.querySelector("#file-name-logo").textContent = this.files[0].name;
        }
    }
</script>

<!-- Nama file qris muncul saat upload -->
<script>
    if (document.getElementById('image_payment') != null) {
        document.querySelector("#image_payment").onchange = function(){
            document.querySelector("#file-name-qris").textContent = this.files[0].name;
        }
    }
</script>