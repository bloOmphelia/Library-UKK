 <script>
    // Enhanced responsive table handling
    document.addEventListener('DOMContentLoaded', function() {
        function handleResize() {
            const width = window.innerWidth;
            const checkAll = document.getElementById('check-all');
            
            if (width <= 480) {
                // Mobile: adjust checkbox label
                checkAll.nextElementSibling.textContent = 'SEMUA';
            } else {
                checkAll.nextElementSibling.textContent = 'ALL';
            }
        }
        
        window.addEventListener('resize', handleResize);
        handleResize(); // Initial call
    });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logika Modal Detail
        const modalDetail = document.getElementById('modalDetail');
        if (modalDetail) {
            modalDetail.addEventListener('show.bs.modal', function (event) {
                // Tombol yang memicu modal
                const button = event.relatedTarget;
                
                // Ambil data dari atribut data-*
                const name = button.getAttribute('data-name');
                const nis = button.getAttribute('data-nis');
                const email = button.getAttribute('data-email');
                const photo = button.getAttribute('data-photo');
                const phone = button.getAttribute('data-phone');
                const className = button.getAttribute('data-class');
                const address = button.getAttribute('data-address');
                const gender = button.getAttribute('data-gender');

                // Isi data ke dalam elemen modal
                document.getElementById('detail-photo').src = photo;
                document.getElementById('detail-name').textContent = name;
                document.getElementById('detail-nis').textContent = nis;
                document.getElementById('detail-email').textContent = email;
                document.getElementById('detail-phone').textContent = phone;
                document.getElementById('detail-class').textContent = className;
                document.getElementById('detail-address').textContent = address;
                document.getElementById('detail-gender').textContent = gender;
            });
        }

        // Logika Bulk Delete (Tetap sertakan yang ini)
        const checkAll = document.getElementById('check-all');
        if (checkAll) {
            checkAll.addEventListener('change', function() {
                document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = this.checked);
            });
        }
        
        const btnBulkDelete = document.getElementById('btn-bulk-delete');
        if (btnBulkDelete) {
            btnBulkDelete.addEventListener('click', function() {
                const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;

                if (checkedCount === 0) {
                    Toast.warning('Pilih setidaknya satu anggota.');
                    return;
                }

                Swal.fire({
                    title            : 'Hapus ' + checkedCount + ' anggota?',
                    text             : 'Data yang dihapus tidak dapat dikembalikan!',
                    icon             : 'warning',
                    showCancelButton : true,
                    confirmButtonColor : '#1e1e1e',
                    cancelButtonColor  : '#ad9a79',
                    confirmButtonText  : 'Ya, Hapus!',
                    cancelButtonText   : 'Batal',
                }).then(function(result) {
                    if (result.isConfirmed) {
                        document.getElementById('form-bulk-delete').submit();
                    }
                });
            });
        }
    });
</script>