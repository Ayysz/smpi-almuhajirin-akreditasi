<!-- File: app/Views/osis/detail_dokumen.php -->
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-file-earmark-text"></i> Detail Dokumen OSIS</h2>
        <a href="<?= base_url('osis/dokumen') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><?= esc($dokumen['nama_dokumen']) ?></h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Jenis Dokumen:</strong></div>
                        <div class="col-md-8">
                            <span class="badge bg-primary"><?= esc($dokumen['jenis_dokumen']) ?></span>
                        </div>
                    </div>

                    <?php if (isset($dokumen['nomor_dokumen']) && $dokumen['nomor_dokumen']): ?>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Nomor Dokumen:</strong></div>
                        <div class="col-md-8"><?= esc($dokumen['nomor_dokumen']) ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($dokumen['tanggal_dokumen']) && $dokumen['tanggal_dokumen']): ?>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Tanggal Dokumen:</strong></div>
                        <div class="col-md-8"><?= date('d F Y', strtotime($dokumen['tanggal_dokumen'])) ?></div>
                    </div>
                    <?php endif; ?>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Periode:</strong></div>
                        <div class="col-md-8">
                            <span class="badge bg-info"><?= esc($dokumen['periode']) ?></span>
                        </div>
                    </div>

                    <?php if (isset($dokumen['keterangan']) && $dokumen['keterangan']): ?>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Keterangan:</strong></div>
                        <div class="col-md-8">
                            <?= nl2br(esc($dokumen['keterangan'])) ?>
                        </div>
                    </div>
                    <?php endif; ?>


                    <?php if (isset($dokumen['status_verifikasi']) && $dokumen['status_verifikasi']): ?>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Status Verifikasi:</strong></div>
                        <div class="col-md-8">
                            <?php
                            $verif_badges = [
                                'terverifikasi' => 'success',
                                'belum_verifikasi' => 'warning',
                                'ditolak' => 'danger'
                            ];
                            $verif_badge = $verif_badges[$dokumen['status_verifikasi']] ?? 'secondary';
                            ?>
                            <span class="badge bg-<?= $verif_badge ?> fs-6"><?= ucfirst(str_replace('_', ' ', $dokumen['status_verifikasi'])) ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Diunggah Oleh:</strong></div>
                        <div class="col-md-8"><?= isset($dokumen['uploader']) ? esc($dokumen['uploader']) : '-' ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Tanggal Diunggah:</strong></div>
                        <div class="col-md-8"><?= date('d F Y H:i', strtotime($dokumen['created_at'])) ?> WIB</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Terakhir Diperbarui:</strong></div>
                        <div class="col-md-8"><?= !empty($dokumen['updated_at']) ? date('d F Y H:i', strtotime($dokumen['updated_at'])) . ' WIB' : '-' ?></div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-3">
                <?php if (in_array(session()->get('role'), ['waka_kesiswaan'])): ?>
                <a href="<?= base_url('osis/edit_dokumen/' . $dokumen['id_dokumen']) ?>" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-4">
            <!-- File Dokumen -->
            <?php if (!empty($dokumen['file_path'])): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="bi bi-file-text"></i> File Dokumen</h6>
                </div>
                <div class="card-body text-center">
                    <?php
                    // Tentukan icon berdasarkan ekstensi file
                    $file_ext = pathinfo($dokumen['file_path'], PATHINFO_EXTENSION);
                    $icon_class = 'bi-file-earmark-text'; // default
                    $text_color = 'text-primary';
                    
                    if (in_array(strtolower($file_ext), ['pdf'])) {
                        $icon_class = 'bi-file-earmark-pdf';
                        $text_color = 'text-danger';
                    } elseif (in_array(strtolower($file_ext), ['doc', 'docx'])) {
                        $icon_class = 'bi-file-earmark-word';
                        $text_color = 'text-primary';
                    } elseif (in_array(strtolower($file_ext), ['xls', 'xlsx'])) {
                        $icon_class = 'bi-file-earmark-excel';
                        $text_color = 'text-success';
                    } elseif (in_array(strtolower($file_ext), ['jpg', 'jpeg', 'png', 'gif'])) {
                        $icon_class = 'bi-file-earmark-image';
                        $text_color = 'text-info';
                    }
                    ?>
                    <i class="bi <?= $icon_class ?> <?= $text_color ?>" style="font-size: 4rem;"></i>
                    <p class="mt-2 mb-0"><strong><?= basename($dokumen['file_path']) ?></strong></p>
                    <small class="text-muted">(<?= strtoupper($file_ext) ?>)</small>
                   <!-- GANTI bagian tombol lihat dan download: -->
                <div class="mt-3">
                    <?php 
                    // Extract filename dari path
                    $filePath = $dokumen['file_path']; // contoh: "uploads/osis/1769789321_b2b07b8337bd4297008e.pdf"
                    $pathParts = explode('/', $filePath);
                    $folder = $pathParts[0]; // "uploads"
                    $subfolder = $pathParts[1]; // "osis"
                    $filename = $pathParts[2]; // "1769789321_b2b07b8337bd4297008e.pdf"
                    ?>
                    
                    <a href="<?= base_url('file/view/' . $folder . '/' . $subfolder . '/' . $filename) ?>" 
                    target="_blank" 
                    class="btn btn-primary btn-sm">
                        <i class="bi bi-eye"></i> Lihat Dokumen
                    </a>
                    <a href="<?= base_url('file/download/' . $folder . '/' . $subfolder . '/' . $filename) ?>" 
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
                    <p class="mt-2 mb-0">Belum ada file dokumen</p>
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
                        <span class="text-muted">ID Dokumen:</span>
                        <strong>#<?= $dokumen['id_dokumen'] ?></strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Ukuran File:</span>
                        <strong>
                            <?php
                            $file_path = WRITEPATH . $dokumen['file_path'];
                            if (!empty($dokumen['file_path']) && file_exists($file_path)) {
                                $size = filesize($file_path);
                                if ($size < 1024) {
                                    echo $size . ' B';
                                } elseif ($size < 1048576) {
                                    echo round($size / 1024, 2) . ' KB';
                                } else {
                                    echo round($size / 1048576, 2) . ' MB';
                                }
                            } else {
                                echo '-';
                            }
                            ?>
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>