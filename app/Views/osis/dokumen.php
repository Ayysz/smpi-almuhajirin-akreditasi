<!-- File: app/Views/osis/dokumen.php -->
<div class="container-fluid">
    <div class="d-flex justify-content-start align-items-center mb-4">
        <h2><i class="bi bi-file-earmark-text"></i> Dokumen OSIS</h2>
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
                <h5 class="mb-0">Daftar Dokumen OSIS</h5>
                <?php 
                    $role = session()->get('role');
                    $allowedCRUD = ['waka_kesiswaan', 'guru'];
                    if (in_array($role, $allowedCRUD) || strpos($role, 'guru') === 0): 
                ?>
                <a href="<?= base_url('osis/tambah_dokumen') ?>" class="btn btn-info btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Dokumen
                </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body">
            <?php if (!empty($dokumen)): ?>
                <div class="table-responsive">
                    <?php 
                        $showAksi = in_array($role, $allowedCRUD) || strpos($role, 'guru') === 0;
                    ?>
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Jenis Dokumen</th>
                                <th>Nama Dokumen</th>
                                <th>Periode</th>
                                <th>Tanggal Upload</th>
                                <?php if ($showAksi): ?>
                                <th>Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($dokumen as $d): ?>
                            <tr onclick="window.location.href='<?= base_url('osis/detail_dokumen/' . $d['id_dokumen']) ?>'" style="cursor: pointer;">
                                <td><?= $no++ ?></td>
                                <td><span class="badge bg-primary"><?= $d['jenis_dokumen'] ?></span></td>
                                <td><?= $d['nama_dokumen'] ?></td>
                                <td><?= $d['periode'] ?? '-' ?></td>
                                <td><?= date('d/m/Y', strtotime($d['created_at'])) ?></td>
                                <?php if ($showAksi): ?>
                                <td>
                                    <div class="btn-group btn-group-sm js-stop-row">
                                        <?php 
                                        $isOwner = isset($d['uploaded_by']) && $d['uploaded_by'] == session()->get('id_user');
                                        $canEdit = $isOwner;
                                        ?>
                                        <?php if ($canEdit): ?>
                                        <a href="<?= base_url('osis/edit_dokumen/' . $d['id_dokumen']) ?>" class="btn btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php endif; ?>
                                        <?php if ($role === 'waka_kesiswaan'): ?>
                                        <button onclick="hapusDokumen(event, <?= $d['id_dokumen'] ?>, '<?= addslashes($d['nama_dokumen']) ?>')" class="btn btn-danger" title="Hapus">
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
                    <i class="bi bi-file-earmark-text fs-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada dokumen OSIS</p>
                    <?php if (in_array(session()->get('role'), ['waka_kesiswaan', 'guru'])): ?>
                    <a href="<?= base_url('osis/tambah_dokumen') ?>" class="btn btn-info btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Dokumen Pertama
                    </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function hapusDokumen(e, id, nama) {
    if (e) e.stopPropagation();
    uiConfirm('Apakah Anda yakin ingin menghapus dokumen "' + nama + '"?\n\nData yang dihapus tidak dapat dikembalikan!', function() {
        window.location.href = '<?= base_url('osis/hapus_dokumen') ?>/' + id;
    }, 'Ya, Hapus');
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.js-stop-row').forEach(function(el) {
        el.addEventListener('click', function(e) { e.stopPropagation(); });
    });
});
</script>
