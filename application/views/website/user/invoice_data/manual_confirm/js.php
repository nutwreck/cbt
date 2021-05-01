<!-- Untuk menampilkan nama file saat upload soal audio -->
<script>
    if (document.getElementById('bukti_pembayaran') != null) 
        document.querySelector("#bukti_pembayaran").onchange = function(){
            document.querySelector("#file-name").textContent = this.files[0].name;
        }
</script>