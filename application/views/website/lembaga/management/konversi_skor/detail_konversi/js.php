<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_detail_konversi').DataTable( {
            
        } );
    } );

    function add_data() {
        window.location.href = "<?php echo base_url(); ?>admin/add-detail-konversi-skor/<?php echo $id_konversi; ?>";
    }

    function import_excel() {
        window.location.href = "<?php echo base_url(); ?>admin/import-detail-konversi-skor/<?php echo $id_konversi; ?>";
    }
</script>

<!-- Nama file muncul saat upload -->
<script>
    if (document.getElementById('data_konversi') != null) {
        document.querySelector("#data_konversi").onchange = function(){
            document.querySelector("#file-name").textContent = this.files[0].name;
        }
    }
</script>