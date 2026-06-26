<div class="container-fluid">
    <div class="d-flex justify-content-start align-items-center mb-4">
        <h2><i class="bi bi-journal-check"></i> Laporan Kegiatan OSIS</h2>
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
                <h5 class="mb-0">Daftar Laporan Kegiatan OSIS</h5>
                <?php 
                    $role = session()->get('role');
                    $allowedCRUD = ['waka_kesiswaan', 'guru'];
                    if (in_array($role, $allowedCRUD) || strpos($role, 'guru') === 0): 
                ?>
                <a href="<?= base_url('osis/tambah-laporan-kegiatan') ?>" class="btn btn-success btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Laporan
                </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body">
            <?php if (!empty($laporan)): ?>
                <div class="table-responsive">
                    <?php 
                        $showAksi = in_array($role, $allowedCRUD) || strpos($role, 'guru') === 0;
                    ?>
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Jumlah Peserta</th>
                                <th>Status</th>
                                <?php if ($showAksi): ?>
                                <th>Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($laporan as $row): ?>
                            <tr onclick="window.location.href='<?= base_url('osis/detail_laporan/' . $row['id_laporan']) ?>'" style="cursor: pointer;">
                                <td><?= $no++ ?></td>
                                <td><strong><?= esc($row['nama_kegiatan']) ?></strong></td>
                                <td><?= date('d/m/Y', strtotime($row['tanggal_pelaksanaan'])) ?></td>
                                <td><?= esc($row['jumlah_peserta']) ?></td>
                                <td>
                                    <?php 
                                    $vStatus = $row['status_verifikasi'] ?? 'menunggu';
                                    if ($vStatus == 'disetujui'): ?>
                                        <span class="badge bg-success">Disetujui</span>
                                    <?php elseif ($vStatus == 'ditolak'): ?>
                                        <span class="badge bg-danger" title="Alasan: <?= esc($row['alasan_penolakan'] ?? '-') ?>">Ditolak</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    <?php endif; ?>
                                </td>
                                <?php if ($showAksi): ?>
                                <td>
                                    <div class="btn-group btn-group-sm js-stop-row">
                                        <?php 
                                        $canEdit = (in_array($role, ['waka_kesiswaan']) && $vStatus == 'menunggu')
                                            || (strpos($role, 'guru') === 0 && in_array($vStatus, ['menunggu', 'ditolak']));
                                        ?>
                                        <?php if ($canEdit): ?>
                                        <a href="<?= base_url('osis/edit_laporan/' . $row['id_laporan']) ?>" class="btn btn-warning" title="Edit Laporan">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php endif; ?>

                                        <?php if (in_array($role, ['waka_kesiswaan']) && $vStatus == 'menunggu'): ?>
                                        <button class="btn btn-success" onclick="verifikasiLaporan(<?= $row['id_laporan'] ?>, 'disetujui')" title="Setujui">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="verifikasiLaporan(<?= $row['id_laporan'] ?>, 'ditolak')" title="Tolak">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                        <?php endif; ?>

                                        <?php if ($role === 'waka_kesiswaan'): ?>
                                        <button onclick="hapusLaporan(event, <?= $row['id_laporan'] ?>, '<?= addslashes($row['nama_kegiatan']) ?>')" class="btn btn-danger" title="Hapus Laporan">
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
                    <i class="bi bi-journal-check fs-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada laporan kegiatan</p>
                    <?php if (in_array(session()->get('role'), $allowedCRUD) || strpos($role, 'guru') === 0): ?>
                    <a href="<?= base_url('osis/tambah-laporan-kegiatan') ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Laporan Pertama
                    </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function hapusLaporan(e, id, nama) {
    if (e) e.stopPropagation();
    uiConfirm('Apakah Anda yakin ingin menghapus laporan "' + nama + '"?\n\nData yang dihapus tidak dapat dikembalikan!', function() {
        window.location.href = '<?= base_url('osis/hapus_laporan') ?>/' + id;
    }, 'Ya, Hapus');
}

function verifikasiLaporan(id, status) {
    if (status === 'ditolak') {
        uiPrompt({
            title: 'Alasan Penolakan',
            message: 'Tuliskan alasan penolakan untuk pengaju.',
            okText: 'Kirim',
            onSubmit: function(reason) {
                $.ajax({
                    url: '<?= base_url('osis/verifikasi_laporan') ?>/' + id,
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
        uiConfirm('Apakah Anda yakin ingin menyetujui laporan kegiatan ini?', function() {
            $.ajax({
                url: '<?= base_url('osis/verifikasi_laporan') ?>/' + id,
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
