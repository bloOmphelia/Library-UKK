<div class="modal fade"
     id="approveModal{{ $transaction->id }}"
     tabindex="-1"
     aria-labelledby="approveTransaction{{ $transaction->id }}"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <form
            action="{{ route('admin.transactions.approve', $transaction->id) }}"
            method="POST"
            class="modal-content"
            style="border-radius: 12px; overflow: hidden; border: none;"
        >
            @csrf
            @method('PATCH')

            {{-- HEADER: Ubah ke Navy --}}
            <div class="modal-header d-flex justify-content-center align-items-center"
                 style="background-color: #1e1e1e; border-radius: 10px 10px 0 0; position: relative; border: none;">
                <h5 class="modal-title text-white" id="approveTransaction{{ $transaction->id }}" style="font-weight: 600;">
                    <i class="bi bi-check-circle me-2"></i> Approve Transaksi
                </h5>

                <button type="button"
                        class="btn-close btn-close-white position-absolute end-0 me-3"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>

            {{-- BODY: Layout Tetap --}}
            <div class="modal-body p-4">
                <h6 class="fw-bold text-center mb-4">
                    Yakin menyetujui peminjaman buku ini?
                </h6>

                <div class="mb-3">
                    <label class="form-label fw-bold small">TANGGAL PINJAM</label>
                    <input
                        type="date"
                        name="borrowed_at"
                        class="form-control"
                        style="border-radius: 8px; background-color: #f8f9fa;"
                        value="{{ now()->format('Y-m-d') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">TANGGAL PENGEMBALIAN</label>
                    <input
                        type="date"
                        name="due_at"
                        class="form-control"
                        style="border-radius: 8px; background-color: #f8f9fa;"
                        required
                    >
                </div>
            </div>

            {{-- FOOTER: Ubah ke Navy & Gold --}}
            <div class="modal-footer border-0">
                <button type="button"
                        class="btn text-white px-4"
                        style="background-color: #1e1e1e; border-radius: 8px; font-weight: 600;"
                        data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Batal
                </button>

                <button type="submit"
                        class="btn text-white px-4"
                        style="background-color: #ad9a79; border-radius: 8px; font-weight: 700;">
                    <i class="bi bi-check2-all me-1"></i> Iya, Setujui
                </button>
            </div>

        </form>
    </div>
</div>