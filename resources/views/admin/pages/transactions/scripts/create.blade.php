<script>
    $(document).ready(function() {
        // Inisialisasi semua yang punya class .select2-init
        $('.select2-init').each(function() {
            $(this).select2({
                // Mengambil teks placeholder dari atribut data-placeholder di HTML
                placeholder: $(this).data('placeholder'),
                allowClear: true,
                width: '100%'
            });
        });
    });
</script>