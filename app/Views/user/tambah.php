<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-person-plus"></i> Tambah User Baru</h2>
        <a href="<?= base_url('user') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('user/simpan') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="username" required>
                            <small class="text-muted">Username untuk login (tanpa spasi)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" required minlength="6">
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_lengkap" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin/Operator</option>
                                <option value="waka_kesiswaan">Waka Kesiswaan</option>
                                <option value="guru">Guru</option>
                                <option value="kepala_sekolah">Kepala Sekolah</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">NIP/NIS</label>
                            <input type="text" class="form-control" name="nip_nis">
                            <small class="text-muted">Diisi sesuai role (NIP untuk guru)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> <strong>Penjelasan Role:</strong>
                    <ul class="mb-0 mt-2">
                        <li><strong>Admin:</strong> Akses penuh sistem, kelola user dan semua data</li>
                        <li><strong>Waka Kesiswaan:</strong> Verifikator akhir, memantau kegiatan dan laporan</li>
                        <li><strong>Guru:</strong> Menginput data kegiatan, prestasi, dan OSIS</li>
                        <li><strong>Kepala Sekolah:</strong> Memantau dashboard dan laporan (read only)</li>
                    </ul>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan User
                    </button>
                    <a href="<?= base_url('user') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
