<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-calendar-event"></i> Laporan Kegiatan Kesiswaan</h2>
        <a href="<?= base_url('laporan') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tahun Ajaran</label>
                    <select class="form-select" name="tahun_ajaran">
                        <option value="">Semua Tahun Ajaran</option>
                        <option value="2029/2030" <?= ($tahun_ajaran == '2029/2030') ? 'selected' : '' ?>>2029/2030</option>
                        <option value="2028/2029" <?= ($tahun_ajaran == '2028/2029') ? 'selected' : '' ?>>2028/2029</option>
                        <option value="2027/2028" <?= ($tahun_ajaran == '2027/2028') ? 'selected' : '' ?>>2027/2028</option>
                        <option value="2026/2027" <?= ($tahun_ajaran == '2026/2027') ? 'selected' : '' ?>>2026/2027</option>
                        <option value="2025/2026" <?= ($tahun_ajaran == '2025/2026') ? 'selected' : '' ?>>2025/2026</option>
                        <option value="2024/2025" <?= ($tahun_ajaran == '2024/2025') ? 'selected' : '' ?>>2024/2025</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jenis Kegiatan</label>
                    <select class="form-select" name="jenis_kegiatan">
                        <option value="">Semua Jenis</option>
                        <option value="KARAKTER" <?= ($jenis_kegiatan == 'KARAKTER') ? 'selected' : '' ?>>Karakter</option>
                        <option value="KEAGAMAAN" <?= ($jenis_kegiatan == 'KEAGAMAAN') ? 'selected' : '' ?>>Keagamaan</option>
                        <option value="EKSTRAKURIKULER" <?= ($jenis_kegiatan == 'EKSTRAKURIKULER') ? 'selected' : '' ?>>Ekstrakurikuler</option>
                        <option value="LAINNYA" <?= ($jenis_kegiatan == 'LAINNYA') ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <?php
    $total_kegiatan = count($kegiatan);
    $disetujui = count(array_filter($kegiatan, fn($k) => $k['status_verifikasi'] == 'disetujui'));
    $ditolak = count(array_filter($kegiatan, fn($k) => $k['status_verifikasi'] == 'ditolak'));
    $menunggu = $total_kegiatan - $disetujui - $ditolak;
    ?>
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-primary"><?= $total_kegiatan ?></h3>
                    <p class="text-muted mb-0">Total Kegiatan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-success"><?= $disetujui ?></h3>
                    <p class="text-muted mb-0">Disetujui</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-warning"><?= $menunggu ?></h3>
                    <p class="text-muted mb-0">Menunggu</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-danger"><?= $ditolak ?></h3>
                    <p class="text-muted mb-0">Ditolak</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Laporan -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Tempat</th>
                            <th>Tahun Ajaran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($kegiatan)): ?>
                            <?php $no = 1; foreach ($kegiatan as $k): ?>
                            <tr onclick="lihatDetail(<?= $k['id_kegiatan'] ?>)" style="cursor: pointer;">
                                <td><?= $no++ ?></td>
                                <td><a href="javascript:void(0)" class="text-decoration-none fw-bold"><?= $k['nama_kegiatan'] ?></a></td>
                                <td><span class="badge bg-info"><?= $k['jenis_kegiatan'] ?></span></td>
                                <td><?= date('d/m/Y', strtotime($k['tanggal_mulai'])) ?></td>
                                <td><?= $k['tempat'] ?></td>
                                <td><?= $k['tahun_ajaran'] ?></td>
                                <td>
                                    <?php if ($k['status_verifikasi'] == 'disetujui'): ?>
                                        <span class="badge bg-success">Disetujui</span>
                                    <?php elseif ($k['status_verifikasi'] == 'ditolak'): ?>
                                        <span class="badge bg-danger">Ditolak</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Menunggu</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada data kegiatan
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tombol Export Excel (di bawah tabel) -->
            <?php if (!empty($kegiatan)): ?>
            <div class="mt-3">
                <a href="<?= base_url('laporan/export_kegiatan') ?>?tahun_ajaran=<?= $tahun_ajaran ?>&jenis_kegiatan=<?= $jenis_kegiatan ?>" class="btn btn-success">
                    <i class="bi bi-file-excel"></i> Export Excel
                </a>
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
</script>
