<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-pencil-square"></i> Edit User</h2>
        <a href="<?= base_url('user') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('user/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id_user" value="<?= $user['id_user'] ?? '' ?>">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="<?= $user['username'] ?? '' ?>" disabled>
                            <small class="text-muted">Username tidak dapat diubah</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_lengkap" value="<?= $user['nama_lengkap'] ?? '' ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" name="role" required>
                                <option value="admin" <?= ($user['role'] ?? '') == 'admin' ? 'selected' : '' ?>>Admin/Operator</option>
                                <option value="waka_kesiswaan" <?= ($user['role'] ?? '') == 'waka_kesiswaan' ? 'selected' : '' ?>>Waka Kesiswaan</option>
                                <option value="guru" <?= ($user['role'] ?? '') == 'guru' ? 'selected' : '' ?>>Guru</option>
                                <option value="kepala_sekolah" <?= ($user['role'] ?? '') == 'kepala_sekolah' ? 'selected' : '' ?>>Kepala Sekolah</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">NIP/NIS</label>
                            <input type="text" class="form-control" name="nip_nis" value="<?= $user['nip_nis'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?= $user['email'] ?? '' ?>">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Akun</label>
                    <select class="form-select" name="is_active">
                        <option value="1" <?= ($user['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= ($user['is_active'] ?? 1) == 0 ? 'selected' : '' ?>>Non-Aktif</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update User
                    </button>
                    <a href="<?= base_url('user') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>