<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_participants').DataTable( {
            
        } );
    } );

    function add_data() {
        window.location.href = "<?php echo base_url(); ?>admin/add-participants";
    }

    function import_excel() {
        window.location.href = "<?php echo base_url(); ?>admin/add-import-participants";
    }
</script>

<!-- Nama file muncul saat upload -->
<script>
    if (document.getElementById('data_peserta') != null) {
        document.querySelector("#data_peserta").onchange = function(){
            document.querySelector("#file-name").textContent = this.files[0].name;
        }
    }
</script>