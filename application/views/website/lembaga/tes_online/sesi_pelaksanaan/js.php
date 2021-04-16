<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<!-- Moment JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.min.js" integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ==" crossorigin="anonymous"></script>
<!-- DateTimePicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#table_sesi').DataTable( {
            
        } );

        $('#table_paket').DataTable( {
            
        } );

        kelompok_function();

        fleksible_tidak();

        komposisi_soal_semua_func();

        $("#manual_peserta_id").select2({
            minimumInputLength: 3,
            ajax: { 
                url: '<?=base_url()?>website/lembaga/Tes_online/get_peserta_by_select',
                type: "post",
                dataType: 'json',
                delay: 250,
                theme: "bootstrap",
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
            },
                cache: true
            },
            allowClear: true,
        });
    } );

    function add_data() {
        window.location.href = "<?php echo base_url(); ?>admin/paket-sesi-pelaksana";
    }

    function kelompok_function(){
        var kelompok_peserta = document.getElementById('kelompok_peserta');
        var manual_peserta = document.getElementById('manual_peserta');
        kelompok_peserta.style.display = 'block';
        manual_peserta.style.display = 'none';
    }

    function manual_function(){
        var kelompok_peserta = document.getElementById('kelompok_peserta');
        var manual_peserta = document.getElementById('manual_peserta');
        kelompok_peserta.style.display = 'none';
        manual_peserta.style.display = 'block';
    }

    function fleksible_tidak(){
        var fleksible_time = document.getElementById('fleksible_time');
        fleksible_time.style.display = 'none';
    }

    function fleksible_ya(){
        var fleksible_time = document.getElementById('fleksible_time');
        fleksible_time.style.display = 'block';
    }

    function komposisi_soal_semua_func(){
        var komposisi_soal_detail = document.getElementById('komposisi_soal_detail');
        komposisi_soal_detail.style.display = 'none';
    }

    function komposisi_soal_atur_func(){
        var komposisi_soal_detail = document.getElementById('komposisi_soal_detail');
        komposisi_soal_detail.style.display = 'block';
    }
</script>

<script type="text/javascript">
  $(function () {
      $('#datetimepicker5').datetimepicker({
        locale: 'id',
        format: 'DD-MM-YYYY HH:mm',
        autoclose: true,
        defaultDate:new Date()
      });
  });

  $(function () {
      $('#datetimepicker6').datetimepicker({
        locale: 'id',
        format: 'DD-MM-YYYY HH:mm',
        autoclose: true
      });
  });
</script>