<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-person-gear"></i> Kelola User</h2>
        <a href="<?= base_url('user/tambah') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah User
        </a>
    </div>

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

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <?php if (isset($users) && !empty($users)): ?>
                <div class="table-responsive">
                    <table class="table table-hover" id="tableUser">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>NIP/NIS</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($users as $u): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= $u['username'] ?></strong></td>
                                <td><?= $u['nama_lengkap'] ?></td>
                                <td><?= $u['nip_nis'] ?? '-' ?></td>
                                <td><?= $u['email'] ?? '-' ?></td>
                                <td>
                                    <?php
                                    $role_badges = [
                                        'admin' => 'danger',
                                        'guru1' => 'success',
                                        'guru2' => 'success',
                                        'guru3' => 'success',
                                        'guru4' => 'success',
                                        'guru5' => 'success',
                                        'guru_osis' => 'info',
                                        'waka' => 'primary',
                                        'kepala_sekolah' => 'warning'
                                    ];
                                    $badge = $role_badges[$u['role']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?= $badge ?>"><?= ucwords(str_replace(['_', 'guru'], [' ', 'Guru '], $u['role'])) ?></span>
                                </td>
                                <td>
                                    <?php if ($u['is_active'] == 1): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <!-- Edit - Semua Admin -->
                                        <a href="<?= base_url('user/edit/' . $u['id_user']) ?>" class="btn btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        <!-- Reset Password - Semua Admin -->
                                        <button class="btn btn-info" onclick="resetPassword(<?= $u['id_user'] ?>)" title="Reset Password">
                                            <i class="bi bi-key"></i>
                                        </button>
                                        
                                        <!-- Delete - Hanya untuk user selain admin & bukan diri sendiri -->
                                        <?php if ($u['username'] != 'admin' && $u['id_user'] != session()->get('id_user')): ?>
                                        <button class="btn btn-danger" onclick="hapusUser(<?= $u['id_user'] ?>, '<?= $u['nama_lengkap'] ?>')" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <script>
                $(document).ready(function() {
                    $('#tableUser').DataTable({
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                        },
                        pageLength: 10
                    });
                });
                </script>

            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-people fs-1 text-muted"></i>
                    <p class="text-muted mt-3 mb-0">Belum ada data user</p>
                    <a href="<?= base_url('user/tambah') ?>" class="btn btn-primary btn-sm mt-3">
                        <i class="bi bi-plus-circle"></i> Tambah User Pertama
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function resetPassword(id) {
    uiConfirm('Reset password user ini menjadi "password123"?', function() {
        $.ajax({
            url: '<?= base_url('user/reset_password') ?>/' + id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    uiNotify(response.message, 'success');
                } else {
                    uiNotify(response.message, 'danger');
                }
            },
            error: function() {
                uiNotify('Terjadi kesalahan saat mereset password!', 'danger');
            }
        });
    }, 'Reset Password');
}

function hapusUser(id, nama) {
    uiConfirm('Apakah Anda yakin ingin menghapus user <strong>' + nama + '</strong>?<br><small class="text-danger">Data yang terkait dengan user ini juga akan terhapus!</small>', function() {
        window.location.href = '<?= base_url('user/hapus') ?>/' + id;
    }, 'Hapus User');
}
</script>
