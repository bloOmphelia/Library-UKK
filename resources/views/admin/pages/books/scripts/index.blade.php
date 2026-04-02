<script>
function confirmStatus(id, currentStatus, activeLoans) {
    let title = "Terbitkan buku ini?";
    let text  = "Buku akan muncul di katalog siswa.";
    let icon  = "question";

    if (currentStatus === 'published') {
        title = "Tarik buku ini ke Arsip?";
        icon  = "warning";
        text  = activeLoans > 0
            ? `Hati-hati! Ada ${activeLoans} transaksi aktif untuk buku ini.`
            : "Buku akan ditarik dari katalog siswa.";
    }

    Swal.fire({
        title,
        text,
        icon,
        showCancelButton: true,
        confirmButtonColor: '#1e1e1e',
        cancelButtonColor:  '#d33',
        confirmButtonText:  'Ya, Lanjutkan!',
        cancelButtonText:   'Batal'
    }).then(result => {
        if (result.isConfirmed) {
            document.getElementById('status-form-' + id).submit();
        }
    });
}

function confirmDelete(action, bookTitle) {
    Swal.fire({
        title: 'Apakah kamu yakin?',
        text: `"${bookTitle}" akan dihapus permanen!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1e1e1e',
        cancelButtonColor:  '#d33',
        confirmButtonText:  'Ya, Hapus!',
        cancelButtonText:   'Batal',
    }).then(result => {
        if (result.isConfirmed) {
            const form     = document.createElement('form');
            form.method    = 'POST';
            form.action    = action;

            const csrf     = document.createElement('input');
            csrf.type      = 'hidden';
            csrf.name      = '_token';
            csrf.value     = '{{ csrf_token() }}';

            const method   = document.createElement('input');
            method.type    = 'hidden';
            method.name    = '_method';
            method.value   = 'DELETE';

            form.appendChild(csrf);
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>