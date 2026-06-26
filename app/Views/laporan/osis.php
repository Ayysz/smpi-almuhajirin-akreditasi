<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-clipboard-check"></i> Laporan OSIS</h2>
        <a href="<?= base_url('laporan') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tahun Ajaran / Periode</label>
                    <select class="form-select" name="periode">
                        <option value="">Semua Periode</option>
                        <option value="2025/2026" <?= (isset($periode) && $periode == '2025/2026') ? 'selected' : '' ?>>2025/2026</option>
                        <option value="2024/2025" <?= (isset($periode) && $periode == '2024/2025') ? 'selected' : '' ?>>2024/2025</option>
                        <option value="2023/2024" <?= (isset($periode) && $periode == '2023/2024') ? 'selected' : '' ?>>2023/2024</option>
                        <option value="2022/2023" <?= (isset($periode) && $periode == '2022/2023') ? 'selected' : '' ?>>2022/2023</option>
                    </select>
                </div>
                <input type="hidden" name="tab" id="activeTabFilter" value="<?= isset($_GET['tab']) ? esc($_GET['tab']) : 'proker' ?>">
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Pilihan Kategori Laporan -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-2">
            <ul class="nav nav-pills nav-fill" id="osisTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold" id="proker-tab" data-bs-toggle="tab" data-bs-target="#proker" type="button" role="tab">
                        <i class="bi bi-calendar-check"></i> Program Kerja
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="laporan-tab" data-bs-toggle="tab" data-bs-target="#laporan-kegiatan" type="button" role="tab">
                        <i class="bi bi-journal-check"></i> Laporan Kegiatan OSIS
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="dokumen-tab" data-bs-toggle="tab" data-bs-target="#dokumen" type="button" role="tab">
                        <i class="bi bi-file-earmark-text"></i> Dokumen
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="osisTabContent">
        <!-- Tab Program Kerja -->
        <div class="tab-pane fade show active" id="proker" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary">Daftar Program Kerja</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Program</th>
                                    <th>Seksi/Divisi</th>
                                    <th>Periode</th>
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($program)): ?>
                                    <?php $no = 1; foreach ($program as $p): ?>
                                    <tr onclick="lihatDetail(<?= $p['id_program'] ?>)" style="cursor: pointer;">
                                        <td><?= $no++ ?></td>
                                        <td class="fw-bold text-primary"><?= esc($p['nama_program']) ?></td>
                                        <td><?= esc($p['seksi']) ?></td>
                                        <td><?= esc($p['periode']) ?></td>
                                        <td><?= $p['tanggal_mulai'] ? date('d/m/Y', strtotime($p['tanggal_mulai'])) : '-' ?></td>
                                        <td><?= $p['tanggal_selesai'] ? date('d/m/Y', strtotime($p['tanggal_selesai'])) : '-' ?></td>
                                        <td>
                                            <?php 
                                            $vStatus = $p['status_verifikasi'] ?? 'menunggu';
                                            if ($vStatus == 'disetujui'): ?>
                                                <span class="badge bg-success">Disetujui</span>
                                            <?php elseif ($vStatus == 'ditolak'): ?>
                                                <span class="badge bg-danger" title="Alasan: <?= esc($p['alasan_penolakan'] ?? '-') ?>">Ditolak</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">Belum ada data program kerja</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if (!empty($program)): ?>
                    <div class="mt-3">
                        <a href="<?= base_url('laporan/export_osis_proker') ?>?periode=<?= isset($periode) ? $periode : '' ?>" class="btn btn-success">
                            <i class="bi bi-file-excel"></i> Export Excel
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tab Laporan Kegiatan -->
        <div class="tab-pane fade" id="laporan-kegiatan" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary">Daftar Laporan Kegiatan</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Tanggal Pelaksanaan</th>
                                    <th>Jumlah Peserta</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($laporan)): ?>
                                    <?php $no = 1; foreach ($laporan as $l): ?>
                                    <tr onclick="lihatDetailLaporan(<?= $l['id_laporan'] ?>)" style="cursor: pointer;">
                                        <td><?= $no++ ?></td>
                                        <td class="fw-bold text-primary"><?= esc($l['nama_kegiatan']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($l['tanggal_pelaksanaan'])) ?></td>
                                        <td><?= esc($l['jumlah_peserta']) ?></td>
                                        <td>
                                            <?php 
                                            $vStatus = $l['status_verifikasi'] ?? 'menunggu';
                                            if ($vStatus == 'disetujui'): ?>
                                                <span class="badge bg-success">Disetujui</span>
                                            <?php elseif ($vStatus == 'ditolak'): ?>
                                                <span class="badge bg-danger" title="Alasan: <?= esc($l['alasan_penolakan'] ?? '-') ?>">Ditolak</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Belum ada data laporan kegiatan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if (!empty($laporan)): ?>
                    <div class="mt-3">
                        <a href="<?= base_url('laporan/export_osis_laporan') ?>?periode=<?= isset($periode) ? $periode : '' ?>" class="btn btn-success">
                            <i class="bi bi-file-excel"></i> Export Excel
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tab Dokumen -->
        <div class="tab-pane fade" id="dokumen" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary">Daftar Dokumen OSIS</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Dokumen</th>
                                    <th>Jenis Dokumen</th>
                                    <th>Periode</th>
                                    <th>Tgl Upload</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dokumen)): ?>
                                    <?php $no = 1; foreach ($dokumen as $d): ?>
                                    <tr onclick="lihatDetailDokumen(<?= $d['id_dokumen'] ?>)" style="cursor: pointer;">
                                        <td><?= $no++ ?></td>
                                        <td class="fw-bold text-primary"><?= esc($d['nama_dokumen']) ?></td>
                                        <td><?= esc($d['jenis_dokumen']) ?></td>
                                        <td><?= esc($d['periode']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($d['created_at'])) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Belum ada data dokumen</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if (!empty($dokumen)): ?>
                    <div class="mt-3">
                        <a href="<?= base_url('laporan/export_osis_dokumen') ?>?periode=<?= isset($periode) ? $periode : '' ?>" class="btn btn-success">
                            <i class="bi bi-file-excel"></i> Export Excel
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"><i class="bi bi-info-circle"></i> Detail</h5>
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
    $('#modalTitle').html('<i class="bi bi-clipboard-check"></i> Detail Program Kerja');
    $('#modalDetail').modal('show');
    $('#detailContent').html('<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>');
    
    $.ajax({
        url: '<?= base_url('laporan/detail_osis') ?>/' + id,
        type: 'GET',
        success: function(response) {
            $('#detailContent').html(response);
        },
        error: function() {
            $('#detailContent').html('<div class="alert alert-danger">Gagal memuat detail program</div>');
        }
    });
}

function lihatDetailDokumen(id) {
    $('#modalTitle').html('<i class="bi bi-file-earmark-text"></i> Detail Dokumen');
    $('#modalDetail').modal('show');
    $('#detailContent').html('<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>');
    
    $.ajax({
        url: '<?= base_url('laporan/detail_dokumen') ?>/' + id,
        type: 'GET',
        success: function(response) {
            $('#detailContent').html(response);
        },
        error: function() {
            $('#detailContent').html('<div class="alert alert-danger">Gagal memuat detail dokumen</div>');
        }
    });
}

function lihatDetailLaporan(id) {
    $('#modalTitle').html('<i class="bi bi-journal-check"></i> Detail Laporan Kegiatan');
    $('#modalDetail').modal('show');
    $('#detailContent').html('<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>');
    
    $.ajax({
        url: '<?= base_url('laporan/detail_laporan') ?>/' + id,
        type: 'GET',
        success: function(response) {
            $('#detailContent').html(response);
        },
        error: function() {
            $('#detailContent').html('<div class="alert alert-danger">Gagal memuat detail laporan</div>');
        }
    });
}

$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');
    if (tab === 'laporan') {
        var triggerEl = document.querySelector('#laporan-tab')
        if (triggerEl) bootstrap.Tab.getOrCreateInstance(triggerEl).show()
    } else if (tab === 'dokumen') {
        var triggerEl = document.querySelector('#dokumen-tab')
        if (triggerEl) bootstrap.Tab.getOrCreateInstance(triggerEl).show()
    } else if (tab === 'proker') {
        var triggerEl = document.querySelector('#proker-tab')
        if (triggerEl) bootstrap.Tab.getOrCreateInstance(triggerEl).show()
    }
});

// Update active tab for filter
$('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    let target = $(e.target).attr('id').replace('-tab', '');
    $('#activeTabFilter').val(target);
});
</script>