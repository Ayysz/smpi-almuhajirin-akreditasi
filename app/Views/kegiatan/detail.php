<table class="table table-bordered">
    <tr>
        <th width="200">Nama Kegiatan</th>
        <td><strong><?= esc($kegiatan['nama_kegiatan']) ?></strong></td>
    </tr>
    <tr>
        <th>Jenis Kegiatan</th>
        <td><span class="badge bg-info"><?= esc($kegiatan['jenis_kegiatan']) ?></span></td>
    </tr>
    <tr>
        <th>Tanggal Mulai</th>
        <td><?= date('d F Y', strtotime($kegiatan['tanggal_mulai'])) ?></td>
    </tr>
    <tr>
        <th>Tanggal Selesai</th>
        <td><?= $kegiatan['tanggal_selesai'] ? date('d F Y', strtotime($kegiatan['tanggal_selesai'])) : '<em class="text-muted">Kegiatan 1 hari</em>' ?></td>
    </tr>
    <tr>
        <th>Tempat</th>
        <td><?= esc($kegiatan['tempat']) ?></td>
    </tr>
    <tr>
        <th>Tahun Ajaran</th>
        <td><?= esc($kegiatan['tahun_ajaran']) ?></td>
    </tr>

    <tr>
        <th>Status Verifikasi</th>
        <td>
            <?php if ($kegiatan['status_verifikasi'] == 'disetujui'): ?>
                <span class="badge bg-success">Disetujui</span>
            <?php elseif ($kegiatan['status_verifikasi'] == 'ditolak'): ?>
                <span class="badge bg-danger">Ditolak</span>
                <?php if (!empty($kegiatan['alasan_penolakan'])): ?>
                    <div class="mt-1 small text-danger">Alasan: <?= esc($kegiatan['alasan_penolakan']) ?></div>
                <?php endif; ?>
            <?php else: ?>
                <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th>Dibuat Oleh</th>
        <td><?= esc($kegiatan['nama_pembuat'] ?? '-') ?></td>
    </tr>
    <tr>
        <th>Waktu Input</th>
        <td><?= date('d/m/Y H:i', strtotime($kegiatan['created_at'])) ?></td>
    </tr>
</table>

<h5 class="mt-4 mb-3 border-bottom pb-2">Dokumentasi & File</h5>
<div class="row g-3">
    <!-- Absensi -->
    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm bg-light">
            <div class="card-body">
                <label class="fw-bold mb-2"><i class="bi bi-file-earmark-check"></i> 
                    <?php 
                    if ($kegiatan['jenis_kegiatan'] == 'KARAKTER') echo 'Absensi Siswa';
                    elseif ($kegiatan['jenis_kegiatan'] == 'KEAGAMAAN') echo 'Absensi Peserta';
                    else echo 'Absensi';
                    ?>
                </label>
                <?php if (!empty($kegiatan['file_absensi'])): ?>
                    <div class="d-grid gap-2">
                        <a href="<?= base_url($kegiatan['file_absensi']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                            Lihat File
                        </a>
                    </div>
                <?php else: ?>
                    <p class="text-muted small mb-0">Tidak ada file</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Foto -->
    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm bg-light">
            <div class="card-body">
                <label class="fw-bold mb-2"><i class="bi bi-image"></i> Foto Kegiatan</label>
                <?php if (!empty($kegiatan['foto_kegiatan'])): ?>
                    <div class="d-grid gap-2">
                        <a href="<?= base_url($kegiatan['foto_kegiatan']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                            Lihat Foto
                        </a>
                    </div>
                <?php else: ?>
                    <p class="text-muted small mb-0">Tidak ada file</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Rundown -->
    <?php if (!empty($kegiatan['rundown_kegiatan']) || in_array($kegiatan['jenis_kegiatan'], ['KARAKTER', 'KEAGAMAAN', 'LAINNYA'])): ?>
    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm bg-light">
            <div class="card-body">
                <label class="fw-bold mb-2"><i class="bi bi-list-task"></i> Rundown Kegiatan</label>
                <?php if (!empty($kegiatan['rundown_kegiatan'])): ?>
                    <div class="d-grid gap-2">
                        <a href="<?= base_url($kegiatan['rundown_kegiatan']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                            Lihat Rundown
                        </a>
                    </div>
                <?php else: ?>
                    <p class="text-muted small mb-0">Tidak ada file</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- SK -->
    <?php if (!empty($kegiatan['surat_keterangan']) || in_array($kegiatan['jenis_kegiatan'], ['KEAGAMAAN', 'LAINNYA'])): ?>
    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm bg-light">
            <div class="card-body">
                <label class="fw-bold mb-2"><i class="bi bi-file-earmark-text"></i> Surat Keputusan / SK</label>
                <?php if (!empty($kegiatan['surat_keterangan'])): ?>
                    <div class="d-grid gap-2">
                        <a href="<?= base_url($kegiatan['surat_keterangan']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                            Lihat SK
                        </a>
                    </div>
                <?php else: ?>
                    <p class="text-muted small mb-0">Tidak ada file</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Laporan -->
    <?php if (!empty($kegiatan['proposal_laporan']) || in_array($kegiatan['jenis_kegiatan'], ['KARAKTER', 'KEAGAMAAN', 'EKSTRAKURIKULER', 'LAINNYA'])): ?>
    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm bg-light">
            <div class="card-body">
                <label class="fw-bold mb-2"><i class="bi bi-journal-text"></i> Laporan Kegiatan</label>
                <?php if (!empty($kegiatan['proposal_laporan'])): ?>
                    <div class="d-grid gap-2">
                        <a href="<?= base_url($kegiatan['proposal_laporan']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                            Lihat Laporan
                        </a>
                    </div>
                <?php else: ?>
                    <p class="text-muted small mb-0">Tidak ada file</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>