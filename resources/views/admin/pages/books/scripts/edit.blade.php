<script>
    document.getElementById('coverInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const preview     = document.getElementById('coverPreview');
            const placeholder = document.getElementById('coverPlaceholder');

            preview.src           = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
</script>