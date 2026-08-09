<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-trophy"></i> Laporan Prestasi Siswa</h2>
        <a href="<?= base_url('laporan') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tahun Ajaran</label>
                    <select class="form-select" name="tahun">
                        <option value="">Semua Tahun Ajaran</option>
                        <option value="2029/2030" <?= ($tahun == '2029/2030') ? 'selected' : '' ?>>2029/2030</option>
                        <option value="2028/2029" <?= ($tahun == '2028/2029') ? 'selected' : '' ?>>2028/2029</option>
                        <option value="2027/2028" <?= ($tahun == '2027/2028') ? 'selected' : '' ?>>2027/2028</option>
                        <option value="2026/2027" <?= ($tahun == '2026/2027') ? 'selected' : '' ?>>2026/2027</option>
                        <option value="2025/2026" <?= ($tahun == '2025/2026') ? 'selected' : '' ?>>2025/2026</option>
                        <option value="2024/2025" <?= ($tahun == '2024/2025') ? 'selected' : '' ?>>2024/2025</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tingkat</label>
                    <select class="form-select" name="tingkat">
                        <option value="">Semua Tingkat</option>
                        <option value="sekolah" <?= ($tingkat == 'sekolah') ? 'selected' : '' ?>>Sekolah</option>
                        <option value="kecamatan" <?= ($tingkat == 'kecamatan') ? 'selected' : '' ?>>Kecamatan</option>
                        <option value="kabupaten" <?= ($tingkat == 'kabupaten') ? 'selected' : '' ?>>Kabupaten</option>
                        <option value="provinsi" <?= ($tingkat == 'provinsi') ? 'selected' : '' ?>>Provinsi</option>
                        <option value="nasional" <?= ($tingkat == 'nasional') ? 'selected' : '' ?>>Nasional</option>
                        <option value="internasional" <?= ($tingkat == 'internasional') ? 'selected' : '' ?>>Internasional</option>
                    </select>
                  </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <?php if (!empty($prestasi)): ?>
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-primary"><?= count($prestasi) ?></h3>
                    <p class="text-muted mb-0">Total Prestasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-success"><?= count(array_filter($prestasi, fn($p) => $p['tingkat'] == 'nasional')) ?></h3>
                    <p class="text-muted mb-0">Tingkat Nasional</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-danger"><?= count(array_filter($prestasi, fn($p) => $p['tingkat'] == 'internasional')) ?></h3>
                    <p class="text-muted mb-0">Tingkat Internasional</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Tabel Laporan -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Nama Prestasi</th>
                            <th>Tingkat</th>
                            <th>Peringkat</th>
                            <th>Tahun Ajaran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($prestasi)): ?>
                            <?php $no = 1; foreach ($prestasi as $p): ?>
                            <tr onclick="lihatDetail(<?= $p['id_prestasi'] ?>)" style="cursor: pointer;">
                                <td><?= $no++ ?></td>
                                <td><a href="javascript:void(0)" class="text-decoration-none fw-bold"><?= !empty($p['nama_siswa']) ? $p['nama_siswa'] : ($p['nama_lengkap'] ?? '-') ?></a></td>
                                <td><?= $p['nama_prestasi'] ?></td>
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
                                <td><strong><?= $p['peringkat'] ?></strong></td>
                                <td><?= $p['tahun_perolehan'] ?></td>
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
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-trophy fs-1 d-block mb-2"></i>
                                    Belum ada data prestasi
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tombol Export Excel (di bawah tabel) -->
            <?php if (!empty($prestasi)): ?>
            <div class="mt-3">
                <a href="<?= base_url('laporan/export_prestasi') ?>?tahun=<?= $tahun ?>&tingkat=<?= $tingkat ?>" class="btn btn-success">
                    <i class="bi bi-file-excel"></i> Export Excel
                </a>
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
</script>
