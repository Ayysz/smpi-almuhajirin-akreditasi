<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-calendar-event"></i> Data Kegiatan Kesiswaan</h2>
        <?php 
            $role = session()->get('role');
            $canInput = in_array($role, ['waka_kesiswaan']) || strpos($role, 'guru') === 0;
            if ($canInput): 
        ?>
        <a href="<?= base_url('kegiatan/tambah') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Kegiatan
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
            <?php if (!empty($kegiatan)): ?>
                <div class="table-responsive">
                    <?php 
                        $role = session()->get('role');
                        $showAksi = in_array($role, ['waka_kesiswaan']) || strpos($role, 'guru') === 0;
                    ?>
                    <table class="table table-hover" id="tableKegiatan">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Kegiatan</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Tempat</th>
                                <th>Tahun Ajaran</th>
                                <th>Status</th>
                                <?php if ($showAksi): ?>
                                <th>Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($kegiatan as $k): ?>
                            <tr class="table-row-click" onclick="lihatDetail(<?= $k['id_kegiatan'] ?>)" style="cursor: pointer;">
                                <td><?= $no++ ?></td>
                                <td><strong><?= $k['nama_kegiatan'] ?></strong></td>
                                <td><span class="badge bg-info"><?= $k['jenis_kegiatan'] ?></span></td>
                                <td><?= date('d/m/Y', strtotime($k['tanggal_mulai'])) ?></td>
                                <td><?= $k['tempat'] ?></td>
                                <td><?= esc($k['tahun_ajaran']) ?></td>
                                <td>
                                    <?php if ($k['status_verifikasi'] == 'disetujui'): ?>
                                        <span class="badge bg-success">Disetujui</span>
                                    <?php elseif ($k['status_verifikasi'] == 'ditolak'): ?>
                                        <span class="badge bg-danger">Ditolak</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Menunggu</span>
                                    <?php endif; ?>
                                </td>
                                <?php if ($showAksi): ?>
                                <td>
                                    <div class="btn-group btn-group-sm js-stop-row">
                                        <!-- Edit - Admin/Waka saat menunggu, Guru saat menunggu/ditolak -->
                                        <?php
                                            $isGuru = strpos($role, 'guru') === 0;
                                            $canEdit = (in_array($role, ['waka_kesiswaan']) && $k['status_verifikasi'] == 'menunggu')
                                                || ($isGuru && in_array($k['status_verifikasi'], ['menunggu', 'ditolak']));
                                        ?>
                                        <?php if ($canEdit): ?>
                                        <a href="<?= base_url('kegiatan/edit/' . $k['id_kegiatan']) ?>" class="btn btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php endif; ?>

                                        <!-- Verifikasi - Admin & Waka -->
                                        <?php if (in_array($role, ['waka_kesiswaan']) && $k['status_verifikasi'] == 'menunggu'): ?>
                                        <button class="btn btn-success" onclick="verifikasi(<?= $k['id_kegiatan'] ?>, 'disetujui')" title="Setujui">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="verifikasi(<?= $k['id_kegiatan'] ?>, 'ditolak')" title="Tolak">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                        <?php endif; ?>

                                        <!-- Hapus - Hanya Admin -->
                                        <?php if ($role === 'waka_kesiswaan'): ?>
                                        <button class="btn btn-danger" onclick="hapusKegiatan(<?= $k['id_kegiatan'] ?>, '<?= addslashes($k['nama_kegiatan']) ?>')" title="Hapus">
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

                <script>
                $(document).ready(function() {
                    $('#tableKegiatan').DataTable({
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                        },
                        pageLength: 10,
                        order: [[3, 'desc']] // Urutkan dari tanggal terbaru
                    });
                });
                </script>

            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-3 mb-0">Belum ada data kegiatan</p>
                    <?php if (in_array(session()->get('role'), ['waka_kesiswaan', 'guru'])): ?>
                    <a href="<?= base_url('kegiatan/tambah') ?>" class="btn btn-primary btn-sm mt-3">
                        <i class="bi bi-plus-circle"></i> Tambah Kegiatan Pertama
                    </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Detail Kegiatan -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Kegiatan</h5>
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
        url: '<?= base_url('kegiatan/detail') ?>/' + id,
        type: 'GET',
        success: function(response) {
            $('#detailContent').html(response);
        },
        error: function() {
            $('#detailContent').html('<div class="alert alert-danger">Gagal memuat detail kegiatan</div>');
        }
    });
}

function verifikasi(id, status) {
    if (status === 'ditolak') {
        uiPrompt({
            title: 'Alasan Penolakan',
            message: 'Tuliskan alasan penolakan untuk pengaju.',
            okText: 'Kirim',
            onSubmit: function(reason) {
                $.ajax({
                    url: '<?= base_url('kegiatan/verifikasi') ?>/' + id,
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
        uiConfirm('Apakah Anda yakin ingin menyetujui kegiatan ini?', function() {
            $.ajax({
                url: '<?= base_url('kegiatan/verifikasi') ?>/' + id,
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

function hapusKegiatan(id, nama) {
    uiConfirm('Apakah Anda yakin ingin menghapus kegiatan \"' + nama + '\"?\n\nData yang terkait juga akan terhapus!', function() {
        window.location.href = '<?= base_url('kegiatan/hapus') ?>/' + id;
    }, 'Ya, Hapus');
}

// Hindari membuka modal detail ketika klik tombol aksi dalam baris
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.js-stop-row').forEach(function(el) {
        el.addEventListener('click', function(e) { e.stopPropagation(); });
    });
});
</script>
