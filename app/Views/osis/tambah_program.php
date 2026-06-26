<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-clipboard-plus"></i> Tambah Program Kerja OSIS</h2>
        <a href="<?= base_url('osis/program-kerja') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('osis/simpan_program') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label class="form-label">Nama Program <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_program" 
                           placeholder="Contoh: Peringatan Hari Kemerdekaan" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="3" 
                              placeholder="Jelaskan program kerja..."></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Seksi Penanggung Jawab</label>
                            <select class="form-select" name="seksi">
                                <option value="">-- Pilih Seksi --</option>
                                <option value="Ketaqwaan">Ketaqwaan</option>
                                <option value="Budi Pekerti">Budi Pekerti</option>
                                <option value="Olahraga">Olahraga</option>
                                <option value="Seni & Budaya">Seni & Budaya</option>
                                <option value="Kewirausahaan">Kewirausahaan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_mulai" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="tanggal_selesai">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Periode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="periode" 
                                   placeholder="Contoh: 2024/2025" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Upload Proposal (Opsional)</label>
                            <input type="file" class="form-control" name="file_proposal" accept=".pdf">
                            <small class="text-muted">Format: PDF</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Program
                    </button>
                    <a href="<?= base_url('osis/program-kerja') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>