<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-trophy"></i> Edit Prestasi</h2>
        <a href="<?= base_url('prestasi') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle"></i>
            <ul class="mb-0 mt-2">
                <?php foreach ((array) session()->getFlashdata('errors') as $e): ?>
                    <li><?= esc($e) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('prestasi/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id_prestasi" value="<?= $prestasi['id_prestasi'] ?>">
                
                <div class="mb-3">
                    <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_siswa" value="<?= esc(old('nama_siswa') ?? ($prestasi['nama_siswa'] ?? '')) ?>" placeholder="Masukkan nama lengkap siswa" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Prestasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_prestasi" value="<?= $prestasi['nama_prestasi'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tingkat <span class="text-danger">*</span></label>
                            <select class="form-select" name="tingkat" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="sekolah" <?= $prestasi['tingkat'] == 'sekolah' ? 'selected' : '' ?>>Sekolah</option>
                                <option value="kecamatan" <?= $prestasi['tingkat'] == 'kecamatan' ? 'selected' : '' ?>>Kecamatan</option>
                                <option value="kabupaten" <?= $prestasi['tingkat'] == 'kabupaten' ? 'selected' : '' ?>>Kabupaten/Kota</option>
                                <option value="provinsi" <?= $prestasi['tingkat'] == 'provinsi' ? 'selected' : '' ?>>Provinsi</option>
                                <option value="nasional" <?= $prestasi['tingkat'] == 'nasional' ? 'selected' : '' ?>>Nasional</option>
                                <option value="internasional" <?= $prestasi['tingkat'] == 'internasional' ? 'selected' : '' ?>>Internasional</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Peringkat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="peringkat" value="<?= $prestasi['peringkat'] ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tahun Perolehan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="tahun_perolehan" min="2000" max="2030" value="<?= $prestasi['tahun_perolehan'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Penyelenggara <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="penyelenggara" value="<?= $prestasi['penyelenggara'] ?>" required>
                        </div>
                    </div>
                </div>

                <!-- FIELD LOMBA BARU -->
                <div class="p-3 mb-4 border rounded bg-light">
                    <h5 class="mb-3">Detail Pelaksanaan Lomba</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal_pelaksanaan" value="<?= esc($prestasi['tanggal_pelaksanaan'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tempat / Lokasi Lomba <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lokasi_lomba" value="<?= esc($prestasi['lokasi_lomba'] ?? '') ?>" placeholder="Contoh: GOR Kota Bogor" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Sertifikat Baru (Opsional saat edit) -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Sertifikat <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="file_sertifikat" accept=".pdf" <?= empty($prestasi['file_sertifikat']) ? 'required' : '' ?>>
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah sertifikat. Format: PDF ONLY</small>
                            <?php if (!empty($prestasi['file_sertifikat'])): ?>
                            <div class="mt-2">
                                <a href="<?= base_url('view/prestasi/' . basename($prestasi['file_sertifikat'])) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-file-earmark-pdf"></i> Lihat Sertifikat Saat Ini
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Surat Undangan (Opsional)</label>
                            <input type="file" class="form-control" name="surat_tugas[]" accept=".pdf,.jpg,.jpeg,.png" multiple>
                            <small class="text-muted">Bisa menambahkan lebih dari satu file. Format: PDF/JPG/PNG</small>
                            <?php if (!empty($prestasi['surat_tugas'])): ?>
                            <?php $tugas = json_decode($prestasi['surat_tugas'], true); ?>
                            <?php if (is_array($tugas) && count($tugas) > 0): ?>
                            <div class="mt-2">
                                <label class="form-label">Surat Undangan / Tugas Saat Ini:</label>
                                <ul class="list-unstyled mb-0">
                                    <?php foreach ($tugas as $i => $tg): ?>
                                    <li class="mb-1">
                                        <a href="<?= base_url('view/prestasi/' . basename($tg)) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-file-earmark"></i> Lihat Surat <?= $i + 1 ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Dokumentasi <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" name="dokumen_pendukung[]" accept=".pdf,.jpg,.jpeg,.png" multiple <?= empty($prestasi['dokumen_pendukung']) ? 'required' : '' ?>>
                    <small class="text-muted">Bisa menambahkan lebih dari satu dokumen. Format: PDF/JPG/PNG</small>
                    <?php if (!empty($prestasi['dokumen_pendukung'])): ?>
                    <?php $docs = json_decode($prestasi['dokumen_pendukung'], true); ?>
                    <?php if (is_array($docs) && count($docs) > 0): ?>
                    <div class="mt-2">
                        <label class="form-label">Dokumentasi Kegiatan Saat Ini:</label>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($docs as $i => $doc): ?>
                            <li class="mb-1">
                                <a href="<?= base_url('view/prestasi/' . basename($doc)) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-paperclip"></i> Lihat Dokumen <?= $i + 1 ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> <strong>Info:</strong> Setelah diupdate, status verifikasi akan kembali menjadi "Menunggu"
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Prestasi
                    </button>
                    <a href="<?= base_url('prestasi') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
