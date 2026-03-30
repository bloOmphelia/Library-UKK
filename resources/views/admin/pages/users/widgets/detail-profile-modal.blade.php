<div class="modal fade" id="modalDetail" tabindex="-1" data-bs-backdrop="false" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
        <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
            <div class="modal-header border-0 text-white position-relative p-0" style="background: #1e1e1e; height: 110px;">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="position-absolute bottom-0 start-50 translate-middle-x" style="margin-bottom: -40px;">
                    <img id="detail-photo" src="" alt="Foto Profil"
                        class="rounded-circle border border-4 border-white shadow"
                        style="width: 80px; height: 80px; object-fit: cover; background-color: #eee;">
                </div>
            </div>

            <div class="modal-body pt-5 pb-4 px-4 text-center">
                <h5 class="fw-bold mb-0 mt-2" id="detail-name" style="color: #1e1e1e;"></h5>
                <small class="text-muted d-block" id="detail-email"></small>
                
                <div class="mt-2">
                    <span class="badge px-3 py-2" style="background-color: rgba(173, 154, 121, 0.1); color: #ad9a79; border-radius: 20px; font-size: 11px; letter-spacing: 0.5px;">
                        NIS : <span id="detail-nis" class="fw-bold"></span>
                    </span>
                </div>

                <hr class="my-4" style="opacity: 0.1;">

                <div class="text-start">
                    <div class="row g-3">
   
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background-color: #f8f9fa; border: 1px solid #eee; height: 75px;">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-telephone-fill" style="color: #ad9a79; font-size: 11px;"></i>
                                    <span class="fw-semibold" style="font-size: 10px; color: #ad9a79; text-transform: uppercase;">No. Telepon</span>
                                </div>
                                <p class="mb-0 fw-bold" id="detail-phone" style="color: #1e1e1e; font-size: 12px;"></p>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background-color: #f8f9fa; border: 1px solid #eee; height: 75px;">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-mortarboard-fill" style="color: #ad9a79; font-size: 11px;"></i>
                                    <span class="fw-semibold" style="font-size: 10px; color: #ad9a79; text-transform: uppercase;">Kelas</span>
                                </div>
                                <p class="mb-0 fw-bold" id="detail-class" style="color: #1e1e1e; font-size: 12px;"></p>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background-color: #f8f9fa; border: 1px solid #eee; height: 75px;">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-geo-alt-fill" style="color: #ad9a79; font-size: 11px;"></i>
                                    <span class="fw-semibold" style="font-size: 10px; color: #ad9a79; text-transform: uppercase;">Alamat</span>
                                </div>
                                <div style="max-height: 30px; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none;">
                                    <p class="mb-0 fw-bold" id="detail-address" style="color: #1e1e1e; font-size: 12px; line-height: 1.2;"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background-color: #f8f9fa; border: 1px solid #eee; height: 75px;">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-gender-ambiguous" style="color: #ad9a79; font-size: 11px;"></i>
                                    <span class="fw-semibold" style="font-size: 10px; color: #ad9a79; text-transform: uppercase;">Jenis Kelamin</span>
                                </div>
                                <p class="mb-0 fw-bold" id="detail-gender" style="color: #1e1e1e; font-size: 12px;"></p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 p-2 rounded-3 text-center" style="background-color: rgba(30, 30, 30, 0.03); border: 1px dashed rgba(0,0,0,0.05);">
                        <p class="mb-0" style="font-size: 11px; color: #6c757d;">
                            <i class="bi bi-info-circle-fill me-1" style="color: #ad9a79;"></i> 
                            Scroll pada kotak <strong>Alamat</strong> untuk melihat lokasi lengkap.
                        </p>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 justify-content-center pb-4 pt-0">
                <button type="button" class="btn px-5 fw-bold" data-bs-dismiss="modal" 
                    style="background-color: #1e1e1e; color: white; border-radius: 10px; font-size: 13px; transition: 0.3s;">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>