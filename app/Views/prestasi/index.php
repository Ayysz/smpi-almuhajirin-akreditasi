<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-trophy"></i> Data Prestasi Siswa</h2>
        <?php 
            $role = session()->get('role');
            $canInput = in_array($role, ['waka_kesiswaan']) || strpos($role, 'guru') === 0;
            if ($canInput): 
        ?>
        <a href="<?= base_url('prestasi/tambah') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Prestasi
        </a>
        <?php endif; ?>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <?php if (!empty($prestasi)): ?>
                <div class="table-responsive">
                    <table class="table table-hover" id="tablePrestasi">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Nama Prestasi</th>
                                <th>Tingkat</th>
                                <th>Peringkat</th>
                                <th>Tahun Ajaran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($prestasi as $p): ?>
                            <tr class="table-row-click" onclick="lihatDetail(<?= $p['id_prestasi'] ?>)" style="cursor: pointer;">
                                <td><?= $no++ ?></td>
                                <td><?= !empty($p['nama_siswa']) ? $p['nama_siswa'] : ($p['nama_lengkap'] ?? '-') ?></td>
                                <td><strong><?= $p['nama_prestasi'] ?></strong></td>
                                <td>
                                    <?php
                                    $badges = [
                                        'sekolah' => 'secondary',
                                        'kecamatan' => 'info',
                                        'kabupaten' => 'primary',
                                        'provinsi' => 'warning',
                                        'nasional' => 'success',
                                        'internasional' => 'danger'
                                    ];
                                    $badge = $badges[$p['tingkat']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?= $badge ?>"><?= ucfirst($p['tingkat']) ?></span>
                                </td>
                                <td><span class="badge bg-warning text-dark"><?= $p['peringkat'] ?></span></td>
                                <td><?= $p['tahun_perolehan'] ?></td>
                                <td>
                                    <?php if ($p['status_verifikasi'] == 'disetujui'): ?>
                                        <span class="badge bg-success">Disetujui</span>
                                    <?php elseif ($p['status_verifikasi'] == 'ditolak'): ?>
                                        <span class="badge bg-danger">Ditolak</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Menunggu</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm js-stop-row">
                                        <!-- Edit - Admin & Waka & Guru -->
                                        <?php
                                        $isOwner = $p['created_by'] == session()->get('id_user');
                                        $canEdit = $isOwner && in_array($p['status_verifikasi'], ['menunggu', 'ditolak']);
                                        ?>
                                        <?php if ($canEdit): ?>
                                        <a href="<?= base_url('prestasi/edit/' . $p['id_prestasi']) ?>" 
                                           class="btn btn-warning" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php endif; ?>
                                        
                                        <!-- Verifikasi - Admin & Waka -->
                                        <?php if (in_array($role, ['waka_kesiswaan']) && $p['status_verifikasi'] == 'menunggu'): ?>
                                        <button class="btn btn-success" 
                                                onclick="verifikasiPrestasi(<?= $p['id_prestasi'] ?>, 'disetujui')" 
                                                title="Setujui">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        <button class="btn btn-danger" 
                                                onclick="verifikasiPrestasi(<?= $p['id_prestasi'] ?>, 'ditolak')" 
                                                title="Tolak">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                        <?php endif; ?>

                                        <!-- Hapus - Hanya Admin -->
                                        <?php if ($role === 'waka_kesiswaan'): ?>
                                        <button class="btn btn-danger" 
                                                onclick="hapusPrestasi(<?= $p['id_prestasi'] ?>, '<?= addslashes($p['nama_prestasi']) ?>')" 
                                                title="Hapus">
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
                    $('#tablePrestasi').DataTable({
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                        },
                        pageLength: 10,
                        order: [[6, 'desc']] // Urutkan dari tahun terbaru
                    });
                });
                </script>

            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-trophy fs-1 text-muted"></i>
                    <p class="text-muted mt-3 mb-0">Belum ada data prestasi</p>
                    <?php if (in_array(session()->get('role'), ['waka_kesiswaan', 'guru'])): ?>
                    <a href="<?= base_url('prestasi/tambah') ?>" class="btn btn-primary btn-sm mt-3">
                        <i class="bi bi-plus-circle"></i> Tambah Prestasi Pertama
                    </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Detail Prestasi -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-trophy"></i> Detail Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
function lihatDetail(id) {
    $('#modalDetail').modal('show');
    $('#detailContent').html('<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>');
    
    $.ajax({
        url: '<?= base_url('prestasi/detail') ?>/' + id,
        type: 'GET',
        success: function(response) {
            $('#detailContent').html(response);
        },
        error: function() {
            $('#detailContent').html('<div class="alert alert-danger">Gagal memuat detail prestasi</div>');
        }
    });
}

function verifikasiPrestasi(id, status) {
    if (status === 'ditolak') {
        uiPrompt({
            title: 'Alasan Penolakan',
            message: 'Tuliskan alasan penolakan untuk pengaju.',
            okText: 'Kirim',
            onSubmit: function(reason) {
                $.ajax({
                    url: '<?= base_url('prestasi/verifikasi') ?>/' + id,
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
        uiConfirm('Apakah Anda yakin ingin menyetujui prestasi ini?', function() {
            $.ajax({
                url: '<?= base_url('prestasi/verifikasi') ?>/' + id,
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

function hapusPrestasi(id, nama) {
    uiConfirm('Apakah Anda yakin ingin menghapus prestasi \"' + nama + '\"?\n\nData yang dihapus tidak dapat dikembalikan!', function() {
        window.location.href = '<?= base_url('prestasi/hapus') ?>/' + id;
    }, 'Ya, Hapus');
}

// Hindari membuka modal detail ketika klik tombol aksi dalam baris
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.js-stop-row').forEach(function(el) {
        el.addEventListener('click', function(e) { e.stopPropagation(); });
    });
});
</script>
