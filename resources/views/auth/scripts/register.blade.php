<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggles = document.querySelectorAll('.toggle-pass');

        toggles.forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === "password") {
                    input.type = "text";
                    if(icon) icon.className = 'bi bi-eye-slash'; 
                } else {
                    input.type = "password";
                    if(icon) icon.className = 'bi bi-eye';
                }
            });
        });
    });

    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function () {
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        });
    @endif
</script>