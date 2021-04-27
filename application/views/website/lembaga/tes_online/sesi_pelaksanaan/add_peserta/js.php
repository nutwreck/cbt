<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {

        kelompok_function();

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
</script>