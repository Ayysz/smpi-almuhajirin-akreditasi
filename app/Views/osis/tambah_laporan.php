<?php $isEdit = isset($laporan); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-journal-check"></i> <?= $isEdit ? 'Edit Laporan Kegiatan' : 'Tambah Laporan Kegiatan' ?></h2>
        <a href="<?= base_url('osis/laporan-kegiatan') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="<?= $isEdit ? base_url('osis/update_laporan') : base_url('osis/simpan_laporan_kegiatan') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <?php if ($isEdit): ?>
                    <input type="hidden" name="id_laporan" value="<?= $laporan['id_laporan'] ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_kegiatan" 
                           placeholder="Contoh: Lomba 17 Agustus 2024" 
                           value="<?= $isEdit ? esc($laporan['nama_kegiatan']) : old('nama_kegiatan') ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_pelaksanaan" 
                                   value="<?= $isEdit ? $laporan['tanggal_pelaksanaan'] : old('tanggal_pelaksanaan') ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jumlah Peserta <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="jumlah_peserta" 
                                   placeholder="Contoh: 150" min="1" 
                                   value="<?= $isEdit ? esc($laporan['jumlah_peserta']) : old('jumlah_peserta') ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Upload Dokumentasi (Foto/PDF) <?= $isEdit ? '' : '<span class="text-danger">*</span>' ?></label>
                            <input type="file" class="form-control" name="dokumentasi" accept=".jpg,.jpeg,.png,.pdf" <?= $isEdit ? '' : 'required' ?>>
                            <small class="text-muted">Format: JPG, JPEG, PNG, atau PDF (Maks 2MB)</small>
                            <?php if ($isEdit && !empty($laporan['dokumentasi'])): ?>
                                <div class="mt-2">
                                    <a href="<?= base_url('file/view/' . $laporan['dokumentasi']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Lihat File Lama
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Upload Laporan Kegiatan (PDF) <?= $isEdit ? '' : '<span class="text-danger">*</span>' ?></label>
                            <input type="file" class="form-control" name="file_laporan" accept=".pdf" <?= $isEdit ? '' : 'required' ?>>
                            <small class="text-muted">Format: PDF (Maks 5MB)</small>
                            <?php if ($isEdit && !empty($laporan['file_laporan'])): ?>
                                <div class="mt-2">
                                    <a href="<?= base_url('file/view/' . $laporan['file_laporan']) ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-eye"></i> Lihat File Lama
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> <?= $isEdit ? 'Update Laporan' : 'Simpan Laporan' ?>
                    </button>
                    <a href="<?= base_url('osis/laporan-kegiatan') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
