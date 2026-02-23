<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filterForm');
    if (!form) return; // Keamanan jika form tidak ditemukan

    let timeout = null;

    document.querySelectorAll('.auto-submit').forEach(element => {
        // Untuk Dropdown (Select)
        element.addEventListener('change', function () {
            // Kita cek jika bukan input text, langsung submit
            if (this.tagName !== 'INPUT') {
                form.submit();
            }
        });

        // Untuk Input Text (Search) dengan Debounce
        if (element.tagName === 'INPUT' && element.type === 'text') {
            element.addEventListener('input', function () { // 'input' lebih responsif dari 'keyup'
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    form.submit();
                }, 500);
            });
        }
    });
});
</script>