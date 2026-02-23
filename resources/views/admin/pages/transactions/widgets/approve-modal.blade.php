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
        >
            @csrf
            @method('PATCH')

            {{-- HEADER --}}
            <div class="modal-header d-flex justify-content-center align-items-center"
                 style="background-color:#7209DB; border-radius:10px 10px 0 0; position:relative;">
                <h5 class="modal-title text-white" id="approveTransaction{{ $transaction->id }}">
                    Approve Transaksi
                </h5>

                <button type="button"
                        class="btn-close position-absolute end-0 me-3"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">
                <h6 class="fw-bold text-center mb-3">
                    Yakin menyetujui peminjaman buku ini?
                </h6>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input
                        type="date"
                        name="borrowed_at"
                        class="form-control"
                        value="{{ now()->format('Y-m-d') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pengembalian</label>
                    <input
                        type="date"
                        name="due_at"
                        class="form-control"
                        required
                    >
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="modal-footer">
                <button type="button"
                        class="btn text-white"
                        style="background-color:#DB0909"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <button type="submit"
                        class="btn text-white"
                        style="background-color:#7209DB">
                    Iya, Setujui
                </button>
            </div>

        </form>
    </div>
</div>
