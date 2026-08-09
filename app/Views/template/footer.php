</div> <!-- End content-wrapper -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<?php if (!empty($enableSelect2)): ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<?php endif; ?>

<script>
    // UI Helpers: Confirm Modal & Toast Notification
    (function() {
        const modalTpl = `
            <div class="modal fade" id="globalConfirmModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                  <div class="modal-header border-0">
                    <h5 class="modal-title"><i class="bi bi-question-circle text-primary"></i> Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p id="globalConfirmMessage" class="mb-0"></p>
                  </div>
                  <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="globalConfirmOk" class="btn btn-primary">
                      <i class="bi bi-check-circle"></i> Lanjutkan
                    </button>
                  </div>
                </div>
              </div>
            </div>`;
        const promptTpl = `
            <div class="modal fade" id="globalPromptModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content border-0 shadow">
                  <div class="modal-header border-0">
                    <h5 class="modal-title" id="globalPromptTitle"><i class="bi bi-pencil-square text-danger"></i> Alasan Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-2 text-muted small" id="globalPromptMessage">Tuliskan alasan penolakan agar pengaju dapat memperbaiki.</div>
                    <textarea id="globalPromptInput" class="form-control" rows="4" placeholder="Contoh: Dokumen belum lengkap, mohon lampirkan proposal..."></textarea>
                  </div>
                  <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="globalPromptOk" class="btn btn-danger">
                      <i class="bi bi-send"></i> Kirim
                    </button>
                  </div>
                </div>
              </div>
            </div>`;
        const toastTpl = `
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
              <div id="globalToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                  <div class="toast-body" id="globalToastBody"></div>
                  <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
              </div>
            </div>`;
        if (!document.getElementById('globalConfirmModal')) {
            document.body.insertAdjacentHTML('beforeend', modalTpl + promptTpl + toastTpl);
        }
        const confirmModalEl = document.getElementById('globalConfirmModal');
        const confirmModal = confirmModalEl ? new bootstrap.Modal(confirmModalEl) : null;
        const confirmMsg = document.getElementById('globalConfirmMessage');
        const confirmOkBtn = document.getElementById('globalConfirmOk');
        const promptModalEl = document.getElementById('globalPromptModal');
        const promptModal = promptModalEl ? new bootstrap.Modal(promptModalEl) : null;
        const promptTitle = document.getElementById('globalPromptTitle');
        const promptMsg = document.getElementById('globalPromptMessage');
        const promptInput = document.getElementById('globalPromptInput');
        const promptOkBtn = document.getElementById('globalPromptOk');
        const toastEl = document.getElementById('globalToast');
        const toastBody = document.getElementById('globalToastBody');
        const toastInst = toastEl ? new bootstrap.Toast(toastEl, { delay: 2500 }) : null;
        window.uiConfirm = function(message, onConfirm, confirmText) {
            if (!confirmModal) { if (confirm(message)) onConfirm(); return; }
            confirmMsg.textContent = message;
            confirmOkBtn.textContent = (confirmText || 'Lanjutkan');
            const handler = () => { onConfirm && onConfirm(); confirmModal.hide(); confirmOkBtn.removeEventListener('click', handler); };
            confirmOkBtn.addEventListener('click', handler);
            confirmModal.show();
        };
        window.uiPrompt = function(options) {
            if (!promptModal) {
                const reason = prompt(options && options.message ? options.message : 'Alasan penolakan:');
                if (reason !== null && String(reason).trim() !== '') {
                    options && options.onSubmit && options.onSubmit(String(reason).trim());
                }
                return;
            }
            promptTitle.textContent = options && options.title ? options.title : 'Alasan Penolakan';
            promptMsg.textContent = options && options.message ? options.message : 'Tuliskan alasan penolakan agar pengaju dapat memperbaiki.';
            promptInput.value = '';
            const handler = () => {
                const val = (promptInput.value || '').trim();
                if (val.length === 0) return;
                options && options.onSubmit && options.onSubmit(val);
                promptModal.hide();
                promptOkBtn.removeEventListener('click', handler);
            };
            promptOkBtn.textContent = options && options.okText ? options.okText : 'Kirim';
            promptOkBtn.addEventListener('click', handler);
            promptModal.show();
            setTimeout(() => { promptInput && promptInput.focus(); }, 250);
        };
        window.uiNotify = function(text, type) {
            if (!toastInst) { alert(text); return; }
            toastEl.classList.remove('text-bg-primary','text-bg-success','text-bg-danger','text-bg-warning');
            const m = { success: 'text-bg-success', danger: 'text-bg-danger', warning: 'text-bg-warning', info: 'text-bg-primary' };
            toastEl.classList.add(m[type] || 'text-bg-primary');
            toastBody.textContent = text;
            toastInst.show();
        };
    })();

    // Sidebar Toggle
    $('#sidebarToggle').click(function() {
        $('.sidebar').toggleClass('hide');
        $('.content-wrapper').toggleClass('expanded');
        
        if (window.innerWidth <= 768) {
            $('.sidebar').toggleClass('show-mobile');
        }
    });

    // JANGAN init DataTables di sini secara global!
    // Init dilakukan di masing-masing view hanya jika ada data
    
    // Auto hide alert after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Toggle submenu OSIS tanpa Bootstrap (hindari konflik)
    document.addEventListener('DOMContentLoaded', function() {
        var trigger = document.querySelector('.sidebar a[href="#collapseOsis"]');
        var target = document.getElementById('collapseOsis');
        if (trigger && target) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                var open = target.classList.toggle('is-open');
                trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        }
    });

    <?php if (!empty($enableSelect2)): ?>
    $(function() {
        $('.js-select2').each(function() {
            $(this).select2({
                width: '100%',
                placeholder: $(this).data('placeholder') || '',
            });
        });
    });
    <?php endif; ?>

    // Global File Size Validation
    document.addEventListener('change', function(e) {
        if (e.target && e.target.type === 'file') {
            const maxMB = e.target.dataset.maxSize || 5;
            const maxBytes = maxMB * 1024 * 1024;
            let fileLimitExceeded = false;
            
            for (let i = 0; i < e.target.files.length; i++) {
                if (e.target.files[i].size > maxBytes) {
                    fileLimitExceeded = true;
                    break;
                }
            }

            if (fileLimitExceeded) {
                uiNotify('Maaf, ukuran file terlalu besar! Maksimal ' + maxMB + ' MB. Silakan kompres file Anda terlebih dahulu.', 'danger');
                e.target.value = ''; // Reset input
            }
        }
    });
</script>
</body>
</html>
