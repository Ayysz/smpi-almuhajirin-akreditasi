<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-journal-check"></i> Detail Laporan Kegiatan</h2>
        <a href="<?= base_url('osis/laporan-kegiatan') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><?= esc($laporan['nama_kegiatan']) ?></h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Tanggal Pelaksanaan:</strong></div>
                        <div class="col-md-8">
                            <?= date('d F Y', strtotime($laporan['tanggal_pelaksanaan'])) ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Jumlah Peserta:</strong></div>
                        <div class="col-md-8">
                            <span class="badge bg-info"><?= esc($laporan['jumlah_peserta']) ?> Orang</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Dibuat Oleh:</strong></div>
                        <div class="col-md-8"><?= esc($laporan['uploader'] ?? '-') ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Tanggal Dibuat:</strong></div>
                        <div class="col-md-8"><?= date('d F Y H:i', strtotime($laporan['created_at'])) ?> WIB</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Status Verifikasi:</strong></div>
                        <div class="col-md-8">
                            <?php 
                            $vStatus = $laporan['status_verifikasi'] ?? 'menunggu';
                            if ($vStatus == 'disetujui'): ?>
                                <span class="badge bg-success fs-6">Disetujui</span>
                            <?php elseif ($vStatus == 'ditolak'): ?>
                                <span class="badge bg-danger fs-6">Ditolak</span>
                                <?php if (!empty($laporan['alasan_penolakan'])): ?>
                                    <div class="text-danger mt-1 small"><i class="bi bi-info-circle"></i> <strong>Alasan:</strong> <?= esc($laporan['alasan_penolakan']) ?></div>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark fs-6">Menunggu Verifikasi</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-3">
                <?php 
                    $role = session()->get('role');
                    $allowedCRUD = ['waka_kesiswaan', 'guru'];
                    if (in_array($role, $allowedCRUD) || strpos($role, 'guru') === 0): 
                ?>
                <a href="<?= base_url('osis/edit_laporan/' . $laporan['id_laporan']) ?>" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-4">
            <!-- File Laporan -->
            <?php if (!empty($laporan['file_laporan'])): ?>
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="bi bi-file-text"></i> Laporan Kegiatan (PDF)</h6>
                </div>
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 4rem;"></i>
                    <p class="mt-2 mb-0"><strong><?= basename($laporan['file_laporan']) ?></strong></p>
                    <div class="mt-3">
                        <a href="<?= base_url('file/view/' . $laporan['file_laporan']) ?>" 
                           target="_blank" 
                           class="btn btn-primary btn-sm">
                            <i class="bi bi-eye"></i> Lihat
                        </a>
                        <a href="<?= base_url('file/download/' . $laporan['file_laporan']) ?>" 
                           download 
                           class="btn btn-success btn-sm">
                            <i class="bi bi-download"></i> Unduh
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- File Dokumentasi -->
            <?php if (!empty($laporan['dokumentasi'])): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="bi bi-image"></i> Dokumentasi</h6>
                </div>
                <div class="card-body text-center">
                    <?php 
                        $ext = pathinfo($laporan['dokumentasi'], PATHINFO_EXTENSION);
                        if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])):
                    ?>
                        <img src="<?= base_url('file/view/' . $laporan['dokumentasi']) ?>" class="img-fluid rounded shadow-sm mb-2" alt="Dokumentasi">
                    <?php else: ?>
                        <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 4rem;"></i>
                    <?php endif; ?>
                    
                    <p class="mt-2 mb-0"><strong><?= basename($laporan['dokumentasi']) ?></strong></p>
                    <div class="mt-3">
                        <a href="<?= base_url('file/view/' . $laporan['dokumentasi']) ?>" 
                           target="_blank" 
                           class="btn btn-primary btn-sm">
                            <i class="bi bi-eye"></i> Lihat
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
