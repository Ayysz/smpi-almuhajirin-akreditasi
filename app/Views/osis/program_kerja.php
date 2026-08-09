<div class="container-fluid">
    <div class="d-flex justify-content-start align-items-center mb-4">
        <h2><i class="bi bi-clipboard-check"></i> Program Kerja OSIS</h2>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Program Kerja OSIS</h5>
                <?php 
                    $role = session()->get('role');
                    $allowedCRUD = ['waka_kesiswaan', 'guru'];
                    if (in_array($role, $allowedCRUD) || strpos($role, 'guru') === 0): 
                ?>
                <a href="<?= base_url('osis/tambah_program') ?>" class="btn btn-success btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Program
                </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body">
            <?php if (!empty($program)): ?>
                <div class="table-responsive">
                    <?php 
                        $showAksi = in_array($role, $allowedCRUD) || strpos($role, 'guru') === 0;
                    ?>
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Program</th>
                                <th>Seksi</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <?php if ($showAksi): ?>
                                <th>Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($program as $pr): ?>
                            <tr onclick="window.location.href='<?= base_url('osis/detail_program/' . $pr['id_program']) ?>'" style="cursor: pointer;">
                                <td><?= $no++ ?></td>
                                <td><strong><?= esc($pr['nama_program']) ?></strong></td>
                                <td><?= esc($pr['seksi'] ?? '-') ?></td>
                                <td><?= date('d/m/Y', strtotime($pr['tanggal_mulai'])) ?></td>
                                <td>
                                    <?php 
                                    $vStatus = $pr['status_verifikasi'] ?? 'menunggu';
                                    if ($vStatus == 'disetujui'): ?>
                                        <span class="badge bg-success">Disetujui</span>
                                    <?php elseif ($vStatus == 'ditolak'): ?>
                                        <span class="badge bg-danger" title="Alasan: <?= esc($pr['alasan_penolakan'] ?? '-') ?>">Ditolak</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    <?php endif; ?>
                                </td>
                                <?php if ($showAksi): ?>
                                <td>
                                    <div class="btn-group btn-group-sm js-stop-row">
                                        <?php 
                                        $isOwner = isset($pr['created_by']) && $pr['created_by'] == session()->get('id_user');
                                        $canEdit = $isOwner && in_array($vStatus, ['menunggu', 'ditolak']);
                                        ?>
                                        <?php if ($canEdit): ?>
                                        <a href="<?= base_url('osis/edit_program/' . $pr['id_program']) ?>" class="btn btn-warning" title="Edit Program">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php endif; ?>

                                        <?php if (in_array($role, ['waka_kesiswaan']) && $vStatus == 'menunggu'): ?>
                                        <button class="btn btn-success" onclick="verifikasiProgram(<?= $pr['id_program'] ?>, 'disetujui')" title="Setujui">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="verifikasiProgram(<?= $pr['id_program'] ?>, 'ditolak')" title="Tolak">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                        <?php endif; ?>

                                        <?php if ($role === 'waka_kesiswaan'): ?>
                                        <button onclick="hapusProgram(event, <?= $pr['id_program'] ?>, '<?= addslashes($pr['nama_program']) ?>')" class="btn btn-danger" title="Hapus Program">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-clipboard-check fs-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada program kerja</p>
                    <?php if (in_array(session()->get('role'), ['waka_kesiswaan', 'guru'])): ?>
                    <a href="<?= base_url('osis/tambah_program') ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Program Pertama
                    </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function hapusProgram(e, id, nama) {
    if (e) e.stopPropagation();
    uiConfirm('Apakah Anda yakin ingin menghapus program "' + nama + '"?\n\nData yang dihapus tidak dapat dikembalikan!', function() {
        window.location.href = '<?= base_url('osis/hapus_program') ?>/' + id;
    }, 'Ya, Hapus');
}

function verifikasiProgram(id, status) {
    if (status === 'ditolak') {
        uiPrompt({
            title: 'Alasan Penolakan',
            message: 'Tuliskan alasan penolakan untuk pengaju.',
            okText: 'Kirim',
            onSubmit: function(reason) {
                $.ajax({
                    url: '<?= base_url('osis/verifikasi_program') ?>/' + id,
                    type: 'POST',
                    data: { 
                        status: status,
                        alasan: reason,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            uiNotify('Penolakan tersimpan', 'success');
                            setTimeout(function(){ location.reload(); }, 900);
                        } else {
                            uiNotify(response.message || 'Gagal memproses', 'danger');
                        }
                    },
                    error: function() {
                        uiNotify('Terjadi kesalahan sistem!', 'danger');
                    }
                });
            }
        });
    } else {
        uiConfirm('Apakah Anda yakin ingin menyetujui program kerja ini?', function() {
            $.ajax({
                url: '<?= base_url('osis/verifikasi_program') ?>/' + id,
                type: 'POST',
                data: { 
                    status: status,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        uiNotify(response.message, 'success');
                        setTimeout(function(){ location.reload(); }, 900);
                    } else {
                        uiNotify(response.message || 'Gagal memproses', 'danger');
                    }
                },
                error: function() {
                    uiNotify('Terjadi kesalahan sistem!', 'danger');
                }
            });
        }, 'Ya, Lanjutkan');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.js-stop-row').forEach(function(el) {
        el.addEventListener('click', function(e) { e.stopPropagation(); });
    });
});
</script>
