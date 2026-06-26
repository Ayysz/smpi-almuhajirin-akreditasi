<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-file-earmark-plus"></i> Tambah Dokumen OSIS</h2>
        <a href="<?= base_url('osis/dokumen') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('osis/simpan_dokumen') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
<div class="mb-3">
                    <label class="form-label">Jenis Dokumen <span class="text-danger">*</span></label>
                    <select class="form-select" name="jenis_dokumen" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="SK Pembina">SK Pembina</option>
                        <option value="SK Pengurus">SK Pengurus</option>
                        <option value="Struktur Organisasi">Struktur Organisasi</option>
                        <option value="LPJ">LPJ (Laporan Pertanggungjawaban)</option>
                        <option value="Notulen Rapat">Notulen Rapat</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Dokumen <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_dokumen" 
                           placeholder="Contoh: Dokumen OSIS Periode 2024/2025" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Periode</label>
                    <input type="text" class="form-control" name="periode" 
                           placeholder="Contoh: 2024/2025">
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload File Dokumen <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" name="file_path" accept=".pdf" required>
                    <small class="text-muted">Format: PDF. Maksimal 10MB</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-info">
                        <i class="bi bi-save"></i> Simpan Dokumen
                    </button>
                    <a href="<?= base_url('osis/dokumen') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>