<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-pencil"></i> Edit Dokumen OSIS</h2>
        <a href="<?= base_url('osis/dokumen') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('osis/update_dokumen') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id_dokumen" value="<?= $dokumen['id_dokumen'] ?>">
                
                <div class="mb-3">
                    <label class="form-label">Jenis Dokumen <span class="text-danger">*</span></label>
                    <select class="form-select" name="jenis_dokumen" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="SK Pembina" <?= $dokumen['jenis_dokumen'] == 'SK Pembina' ? 'selected' : '' ?>>SK Pembina</option>
                        <option value="SK Pengurus" <?= $dokumen['jenis_dokumen'] == 'SK Pengurus' ? 'selected' : '' ?>>SK Pengurus</option>
                        <option value="Struktur Organisasi" <?= $dokumen['jenis_dokumen'] == 'Struktur Organisasi' ? 'selected' : '' ?>>Struktur Organisasi</option>
                        <option value="LPJ" <?= $dokumen['jenis_dokumen'] == 'LPJ' ? 'selected' : '' ?>>LPJ (Laporan Pertanggungjawaban)</option>
                        <option value="Notulen Rapat" <?= $dokumen['jenis_dokumen'] == 'Notulen Rapat' ? 'selected' : '' ?>>Notulen Rapat</option>
                        <option value="Lainnya" <?= $dokumen['jenis_dokumen'] == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Dokumen <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_dokumen" 
                           value="<?= $dokumen['nama_dokumen'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Periode</label>
                    <input type="text" class="form-control" name="periode" 
                           value="<?= $dokumen['periode'] ?>" 
                           placeholder="Contoh: 2024/2025">
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload File Baru (Opsional)</label>
                    <input type="file" class="form-control" name="file_path" accept=".pdf">
                    <?php if ($dokumen['file_path']): ?>
                    <small class="text-muted">File saat ini: <?= basename($dokumen['file_path']) ?></small>
                    <br>
                    <a href="<?= base_url('writable/' . $dokumen['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-info mt-2">
                        <i class="bi bi-eye"></i> Lihat File Saat Ini
                    </a>
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Dokumen
                    </button>
                    <a href="<?= base_url('osis/dokumen') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>