<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_list').DataTable( {
            
        } );

        $('.delete_checkbox').click(function(){
            if($(this).is(':checked')) {
                $(this).closest('tr').addClass('removeRow');
            } else {
                $(this).closest('tr').removeClass('removeRow');
            }
        });

        $('#delete_all').click(function(){
            var checkbox = $('.delete_checkbox:checked');
            if(checkbox.length > 0) {
                var checkbox_value = [];
                $(checkbox).each(function(){
                    checkbox_value.push($(this).val());
                });
                $.ajax({
                    url:"<?php echo base_url(); ?>website/lembaga/Tes_online/sesi_peserta_multiple_delete",
                    method:"POST",
                    data:{checkbox_value:checkbox_value},
                    success:function()
                    {
                        $('.removeRow').fadeOut(1500);
                        alert('Hapus peserta sesi sukses!');
                    }
                })
            } else {
                alert('Pilih minimal 1 data');
            }
        });
    } );

    function export_excel() {
        window.location.href = "<?php echo base_url(); ?>admin/export-peserta-sesi-pelaksana/<?=$id_sesi_pelaksana?>";
    }
</script>