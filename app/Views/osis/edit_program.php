<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-pencil"></i> Edit Program Kerja OSIS</h2>
        <a href="<?= base_url('osis/program-kerja') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('osis/update_program') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id_program" value="<?= $program['id_program'] ?>">
                
                <div class="mb-3">
                    <label class="form-label">Nama Program <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_program" 
                           value="<?= $program['nama_program'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="3"><?= $program['deskripsi'] ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Seksi Penanggung Jawab</label>
                            <select class="form-select" name="seksi">
                                <option value="">-- Pilih Seksi --</option>
                                <option value="Ketaqwaan" <?= $program['seksi'] == 'Ketaqwaan' ? 'selected' : '' ?>>Ketaqwaan</option>
                                <option value="Budi Pekerti" <?= $program['seksi'] == 'Budi Pekerti' ? 'selected' : '' ?>>Budi Pekerti</option>
                                <option value="Olahraga" <?= $program['seksi'] == 'Olahraga' ? 'selected' : '' ?>>Olahraga</option>
                                <option value="Seni & Budaya" <?= $program['seksi'] == 'Seni & Budaya' ? 'selected' : '' ?>>Seni & Budaya</option>
                                <option value="Kewirausahaan" <?= $program['seksi'] == 'Kewirausahaan' ? 'selected' : '' ?>>Kewirausahaan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_mulai" 
                                   value="<?= $program['tanggal_mulai'] ?>" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="tanggal_selesai" 
                                   value="<?= $program['tanggal_selesai'] ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Periode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="periode" 
                                   value="<?= $program['periode'] ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Upload Proposal Baru (Opsional)</label>
                            <input type="file" class="form-control" name="file_proposal" accept=".pdf">
                            <?php if ($program['file_proposal']): ?>
                            <small class="text-muted">File saat ini: <?= basename($program['file_proposal']) ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Program
                    </button>
                    <a href="<?= base_url('osis/program-kerja') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>