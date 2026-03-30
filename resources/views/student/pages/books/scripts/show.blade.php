<script>
    let expanded = false;

    function toggleDesc() {
        const text      = document.getElementById('descText');
        const btn       = document.getElementById('toggleBtn');
        expanded        = !expanded;

        if (expanded) {
            text.classList.remove('clamped');
            btn.innerHTML = 'Sembunyikan <i class="bi bi-chevron-up ms-1"></i>';
        } else {
            text.classList.add('clamped');
            btn.innerHTML = 'Baca Selengkapnya <i class="bi bi-chevron-down ms-1"></i>';
        }
    }
</script>