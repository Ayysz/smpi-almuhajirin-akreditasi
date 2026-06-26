<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-clipboard-check"></i> Detail Program Kerja</h2>
        <a href="<?= base_url('osis/program-kerja') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><?= esc($program['nama_program']) ?></h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Seksi Penanggung Jawab:</strong></div>
                        <div class="col-md-8"><?= $program['seksi'] ?? '-' ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Periode:</strong></div>
                        <div class="col-md-8">
                            <span class="badge bg-info"><?= esc($program['periode']) ?></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Tanggal Pelaksanaan:</strong></div>
                        <div class="col-md-8">
                            <?= date('d F Y', strtotime($program['tanggal_mulai'])) ?>
                            <?php if ($program['tanggal_selesai']): ?>
                                s/d <?= date('d F Y', strtotime($program['tanggal_selesai'])) ?>
                            <?php endif; ?>
                        </div>
                    </div>


                    <?php if ($program['deskripsi']): ?>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Deskripsi:</strong></div>
                        <div class="col-md-8">
                            <?= nl2br(esc($program['deskripsi'])) ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Dibuat Oleh:</strong></div>
                        <div class="col-md-8"><?= $program['nama_creator'] ?? '-' ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Tanggal Dibuat:</strong></div>
                        <div class="col-md-8"><?= date('d F Y H:i', strtotime($program['created_at'])) ?> WIB</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Status Verifikasi:</strong></div>
                        <div class="col-md-8">
                            <?php 
                            $vStatus = $program['status_verifikasi'] ?? 'menunggu';
                            if ($vStatus == 'disetujui'): ?>
                                <span class="badge bg-success fs-6">Disetujui</span>
                            <?php elseif ($vStatus == 'ditolak'): ?>
                                <span class="badge bg-danger fs-6">Ditolak</span>
                                <?php if (!empty($program['alasan_penolakan'])): ?>
                                    <div class="text-danger mt-1 small"><i class="bi bi-info-circle"></i> <strong>Alasan:</strong> <?= esc($program['alasan_penolakan']) ?></div>
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
                <?php if (in_array(session()->get('role'), ['waka_kesiswaan'])): ?>
                <a href="<?= base_url('osis/edit_program/' . $program['id_program']) ?>" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-4">
            <!-- File Proposal -->
            <?php if (!empty($program['file_proposal'])): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="bi bi-file-text"></i> File Proposal</h6>
                </div>
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 4rem;"></i>
                    <p class="mt-2 mb-0"><strong><?= basename($program['file_proposal']) ?></strong></p>
                    <div class="mt-3">
                        <a href="<?= base_url('file/view/uploads/osis/' . basename($program['file_proposal'])) ?>" 
                           target="_blank" 
                           class="btn btn-primary btn-sm">
                            <i class="bi bi-eye"></i> Lihat Proposal
                        </a>
                        <a href="<?= base_url('writable/' . $program['file_proposal']) ?>" 
                           download 
                           class="btn btn-success btn-sm">
                            <i class="bi bi-download"></i> Download
                        </a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center text-muted">
                    <i class="bi bi-file-earmark-x fs-1"></i>
                    <p class="mt-2 mb-0">Belum ada file proposal</p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Informasi Tambahan -->
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="bi bi-info-circle"></i> Informasi</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">ID Program:</span>
                        <strong>#<?= $program['id_program'] ?></strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Periode:</span>
                        <strong><?= $program['periode'] ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>