<div class="container-fluid">
    <?php if (in_array(session()->get('role'), ['admin', 'waka_kesiswaan', 'kepala_sekolah'])): ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <?php 
            $roleTitle = 'Administrator';
            if (session()->get('role') == 'waka_kesiswaan') $roleTitle = 'Waka Kesiswaan';
            if (session()->get('role') == 'kepala_sekolah') $roleTitle = 'Kepala Sekolah';
        ?>
        <div>
            <h2 class="mb-0"><span class="gradient-text">Dashboard <?= $roleTitle ?></span></h2>
            <div class="text-muted">Selamat datang kembali, kelola sistem dengan efisien</div>
        </div>
        <span class="badge bg-primary">Halo, <?= session()->get('nama_lengkap') ?></span>
    </div>
    <?php else: ?>
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Selamat Datang, <?= esc(session()->get('nama_lengkap')) ?>!</h2>
                <small class="text-muted"><?= date('d F Y') ?></small>
            </div>
        </div>
        <div class="mt-3 p-4 rounded-3 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-semibold">Selamat datang! Kelola data kegiatan, prestasi, serta program OSIS.</div>
                    <small class="opacity-75">Pantau aktivitas kesiswaan dan sekolah di sini</small>
                </div>
                <a href="<?= base_url('kegiatan') ?>" class="btn btn-light btn-sm">Lihat Kegiatan</a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stat-card border-0 shadow-sm card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Kegiatan</h6>
                            <h3 class="mb-0"><?= $total_kegiatan ?></h3>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> Aktif</small>
                        </div>
                        <div class="metric-icon">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card border-0 shadow-sm card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Prestasi</h6>
                            <h3 class="mb-0"><?= $total_prestasi ?></h3>
                            <small class="text-success"><i class="bi bi-star-fill"></i> Pencapaian</small>
                        </div>
                        <div class="metric-icon">
                            <i class="fa-solid fa-trophy"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Dokumen Akreditasi</h6>
                            <h3 class="mb-0"><?/*= $total_dokumen*/ ?></h3>
                            <small class="text-info"><i class="bi bi-file-check"></i> Tersimpan</small>
                        </div>
                        <div class="fs-1 text-info">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        
        <?php if (in_array(session()->get('role'), ['admin', 'waka_kesiswaan'])): ?>
        <div class="col-md-3">
            <div class="card stat-card border-0 shadow-sm card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Pending Verifikasi</h6>
                            <h3 class="mb-0"><?= $pending_verifikasi ?></h3>
                            <small class="text-warning"><i class="fa-solid fa-clock"></i> Menunggu</small>
                        </div>
                        <div class="metric-icon">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Grafik Bulanan & Aktivitas Terbaru (Admin/Waka/Kepsek) -->
    <?php if (in_array(session()->get('role'), ['admin', 'waka_kesiswaan', 'kepala_sekolah'])): ?>
    <div class="card border-0 shadow-sm mb-4 card-hover">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fa-solid fa-chart-line"></i> Statistik Bulanan</h5>
        </div>
        <div class="card-body">
            <canvas id="lineChart" height="80"></canvas>
        </div>
    </div>
    <div class="card border-0 shadow-sm mb-4 card-hover">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fa-solid fa-bolt"></i> Aktivitas Terbaru</h5>
        </div>
        <div class="card-body">
            <ul class="list-unstyled mb-0">
                <?php foreach (($recent_kegiatan ?? []) as $rk): ?>
                <li class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-calendar-check me-2 text-primary"></i>
                    <span class="me-auto"><?= esc($rk['nama_kegiatan']) ?></span>
                    <small class="text-muted"><?= date('d M Y H:i', strtotime($rk['created_at'])) ?></small>
                </li>
                <?php endforeach; ?>
                <?php foreach (($recent_prestasi ?? []) as $rp): ?>
                <li class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-trophy me-2 text-success"></i>
                    <span class="me-auto"><?= esc($rp['nama_prestasi']) ?></span>
                    <small class="text-muted"><?= date('d M Y H:i', strtotime($rp['created_at'])) ?></small>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php else: ?>
    <!-- Grafik Bulanan (Pribadi) -->
    <div class="card border-0 shadow-sm mb-4 card-hover">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fa-solid fa-chart-line"></i> Statistik Bulanan (Pribadi)</h5>
        </div>
        <div class="card-body">
            <canvas id="lineChart" height="80"></canvas>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Belum Verifikasi (Admin/Waka/Kepsek) -->
    <?php if (in_array(session()->get('role'), ['admin', 'waka_kesiswaan', 'kepala_sekolah'])): ?>
    <div class="card border-0 shadow-sm mb-4 card-hover">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fa-solid fa-triangle-exclamation"></i> Belum Verifikasi</h5>
            <a href="<?= base_url('kegiatan') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
            <?php if (empty($kegiatan_belum_verifikasi)): ?>
                <div class="text-center py-5">
                    <i class="fa-regular fa-calendar-xmark fs-1 text-muted"></i>
                    <p class="text-muted mt-3">Tidak ada kegiatan menunggu verifikasi</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Tempat</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($kegiatan_belum_verifikasi as $kg): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= $kg['nama_kegiatan'] ?></strong></td>
                                <td><?= date('d M Y', strtotime($kg['tanggal_mulai'])) ?></td>
                                <td><?= $kg['tempat'] ?? '-' ?></td>
                                <td><span class="badge bg-warning"><i class="fa-solid fa-clock"></i> Menunggu</span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php if (true): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const seriesKegiatan = <?= json_encode(array_values($series_kegiatan ?? array_fill(0,12,0))) ?>;
    const seriesPrestasi = <?= json_encode(array_values($series_prestasi ?? array_fill(0,12,0))) ?>;
    const ctx = document.getElementById('lineChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                { label: 'Kegiatan', data: seriesKegiatan, borderColor: '#667eea', backgroundColor: 'rgba(102,126,234,0.15)', tension: 0.3 },
                { label: 'Prestasi', data: seriesPrestasi, borderColor: '#764ba2', backgroundColor: 'rgba(118,75,162,0.15)', tension: 0.3 }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
<?php endif; ?>
