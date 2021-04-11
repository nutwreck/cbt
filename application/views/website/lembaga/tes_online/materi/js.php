<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_materi').DataTable( {
            
        } );
    } );

    function add_data() {
        window.location.href = "<?php echo base_url(); ?>admin/add-materi";
    }
</script>

<!-- Info Close -->
<script>
    function close_info() {
        var cont = document.getElementById('info_user');
        cont.style.display = 'none';
        document.getElementById('content_add').className = 'col-lg-6'; //Ganti ukuran form add
    }
</script>

<!-- Validasi Form Add -->
<script type = "text/javascript">
    function validate_addform(){
        if( document.formadd.materi.value == "" ) {
            document.getElementById('materi_er').innerHTML = 'Wajib diisi!';
            document.formadd.materi.focus() ;
            return false;
        }
        return( true );
    }
</script>

<!-- Validasi Form Edit -->
<script type = "text/javascript">
    function validate_editform(){
        if( document.formedit.materi.value == "" ) {
            document.getElementById('materi_er').innerHTML = 'Wajib diisi!';
            document.formedit.materi.focus() ;
            return false;
        }
        return( true );
    }
</script>