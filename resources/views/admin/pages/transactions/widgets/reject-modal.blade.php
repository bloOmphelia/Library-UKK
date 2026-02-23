<div class="modal fade" id="rejectModal{{ $transaction->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-md">
            <div class="modal-header" style="background-color: #7209DB; border-radius: 10px 10px 0 0;">
                <h5 class="modal-title text-white">Tolak Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.transactions.reject', $transaction->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="modal-body">
                    <div class="form-group">
                        <label class="mb-2 fw-semibold text-dark">Alasan</label>
                        <textarea name="reason" class="form-control" rows="7" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn text-white" style="background-color: #DB0909;" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn text-white" style="background-color: #7209DB;">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
