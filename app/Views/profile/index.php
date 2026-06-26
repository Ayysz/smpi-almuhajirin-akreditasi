<div class="container-fluid">
    <h2 class="mb-4"><i class="bi bi-person-circle"></i> Profile Saya</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-x-circle"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <?php 
                        $foto = $user['foto'] ?? '';
                        $src  = $foto ? base_url('download/view/profile/' . basename($foto)) : '';
                        ?>
                        <?php if (!empty($foto)): ?>
                        <img src="<?= $src ?>" alt="Foto Profile" class="rounded-circle" width="150" height="150" style="object-fit: cover;">
                        <?php else: ?>
                        <i class="bi bi-person-circle" style="font-size: 150px; color: #667eea;"></i>
                        <?php endif; ?>
                    </div>
                    <h4><?= $user['nama_lengkap'] ?></h4>
                    <p class="text-muted mb-1">@<?= $user['username'] ?></p>
                    <span class="badge bg-primary"><?= ucwords(str_replace('_', ' ', $user['role'])) ?></span>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Profile</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('profile/update') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="<?= $user['username'] ?>" disabled>
                            <small class="text-muted">Username tidak dapat diubah</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_lengkap" value="<?= $user['nama_lengkap'] ?>" required>
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
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Profile</label>
                            <input type="file" class="form-control" name="foto" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Max 2MB</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                            <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
