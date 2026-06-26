<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-trophy"></i> Tambah Prestasi Baru</h2>
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
            <form action="<?= base_url('prestasi/simpan') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_siswa" value="<?= old('nama_siswa') ?>" placeholder="Masukkan nama lengkap siswa" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Prestasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_prestasi" placeholder="Contoh: Juara 1 OSN Matematika" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tingkat <span class="text-danger">*</span></label>
                            <select class="form-select" name="tingkat" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="sekolah">Sekolah</option>
                                <option value="kecamatan">Kecamatan</option>
                                <option value="kabupaten">Kabupaten/Kota</option>
                                <option value="provinsi">Provinsi</option>
                                <option value="nasional">Nasional</option>
                                <option value="internasional">Internasional</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Peringkat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="peringkat" placeholder="Juara 1, Juara 2, dst." required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tahun Perolehan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="tahun_perolehan" min="2000" max="2030" value="<?= date('Y') ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Penyelenggara <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="penyelenggara" placeholder="Contoh: Dinas Pendidikan Kab. Bogor" required>
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
                                <input type="date" class="form-control" name="tanggal_pelaksanaan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tempat / Lokasi Lomba <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lokasi_lomba" placeholder="Contoh: GOR Kota Bogor" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WAJIB: Upload Sertifikat PDF -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Sertifikat <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="file_sertifikat" accept=".pdf" required>
                            <small class="text-muted">Format: PDF ONLY. Maksimal 5MB</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Surat Undangan (Opsional)</label>
                            <input type="file" class="form-control" name="surat_tugas[]" accept=".pdf,.jpg,.jpeg,.png" multiple>
                            <small class="text-muted">Format: PDF/JPG/PNG.</small>
                        </div>
                    </div>
                </div>

                <!-- BARU: Dokumentasi Kegiatan -->
                <div class="mb-3">
                    <label class="form-label">Dokumentasi <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" name="dokumen_pendukung[]" accept=".pdf,.jpg,.jpeg,.png" multiple required>
                    <small class="text-muted">
                        Dokumentasi:
                        Format: PDF/JPG/PNG. 
                    </small>
                </div>

                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> <strong>Penting:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Sertifikat <strong>WAJIB</strong> format PDF</li>
                        <li>Pastikan nama di sertifikat sesuai dengan nama Anda</li>
                        <li>Upload dokumen pendukung untuk memperkuat validasi prestasi</li>
                        <li>Prestasi akan diverifikasi oleh Waka Kesiswaan</li>
                    </ul>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Prestasi
                    </button>
                    <a href="<?= base_url('prestasi') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
