<div class="modal fade" id="rejectModal{{ $transaction->id }}" tabindex="-1" data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 
            0 10px 20px -8px rgba(0, 0, 0, 0.15), 
            0 4px 8px -4px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);">
            <div class="modal-header border-0 p-4" style="background-color: #1e1e1e;">
                <h5 class="modal-title text-white fw-bold d-flex align-items-center">
                    <i class="bi bi-x-circle-fill me-2 text-danger"></i> TOLAK PEMINJAMAN
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.transactions.reject', $transaction->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="modal-body p-4">
                    <div class="alert alert-warning border-0 small mb-4" style="background-color: #fff9e6; color: #856404; border-radius: 12px;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Memberikan alasan yang jelas membantu pengguna memahami mengapa permintaan mereka ditolak.
                    </div>

                    <div class="form-group">
                        <label class="mb-2 fw-bold text-dark small text-uppercase" style="letter-spacing: 0.5px;">
                            Alasan Penolakan
                        </label>
                        <textarea name="reason" class="form-control border-0 shadow-sm @error('reason') is-invalid @enderror" 
                            style="background-color: #f8f9fa; border-radius: 15px; padding: 15px; resize: none;" 
                            rows="5" 
                            placeholder="Contoh: Stok buku sedang dalam perbaikan atau data tidak valid..." required ></textarea>
                        @error('reason')
                            <div class="invalid-feedback small mt-2 ps-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn px-4 py-2 fw-bold" 
                            style="background-color: #eee; color: #666; border-radius: 10px; border: none;" 
                            data-bs-dismiss="modal">
                        BATAL
                    </button>
                    <button type="submit" class="btn px-4 py-2 fw-bold text-white shadow-sm" 
                            style="background-color: #dc3545; border-radius: 10px; border: none; transition: 0.3s;">
                        KONFIRMASI TOLAK
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>