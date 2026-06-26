<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-file-earmark-pdf text-danger"></i> Laporan Komprehensif</h2>
        <div>
            <a href="<?= base_url('laporan') ?>" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="<?= base_url('laporan/komprehensif_cetak') ?>?tahun=<?= $tahun_filter ?>" class="btn btn-danger" target="_blank">
                <i class="bi bi-download"></i> Download Laporan (PDF)
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary">1. Ringkasan Kegiatan Kesiswaan</h5>
        </div>
        <div class="card-body">
            <?php if(empty($kegiatan)): ?>
                <p class="text-muted">Tidak ada data kegiatan yang disetujui.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Kegiatan</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Tempat</th>
                                <th>Akses Data (File)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($kegiatan as $k): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-bold"><?= esc($k['nama_kegiatan']) ?></td>
                                <td><?= esc($k['jenis_kegiatan']) ?></td>
                                <td><?= date('d/m/Y', strtotime($k['tanggal_mulai'])) ?></td>
                                <td><?= esc($k['tempat'] ?? '-') ?></td>
                                <td>
                                    <?php if($k['proposal_laporan']): ?>
                                        <a href="<?= base_url($k['proposal_laporan']) ?>" target="_blank" class="btn btn-sm btn-outline-primary mb-1">Proposal/Laporan</a><br>
                                    <?php endif; ?>
                                    <?php if($k['file_absensi']): ?>
                                        <a href="<?= base_url($k['file_absensi']) ?>" target="_blank" class="btn btn-sm btn-outline-info mb-1">Absensi</a><br>
                                    <?php endif; ?>
                                    <?php if($k['foto_kegiatan']): ?>
                                        <a href="<?= base_url($k['foto_kegiatan']) ?>" target="_blank" class="btn btn-sm btn-outline-warning mb-1">Foto Kegiatan</a><br>
                                    <?php endif; ?>
                                    <?php if($k['rundown_kegiatan']): ?>
                                        <a href="<?= base_url($k['rundown_kegiatan']) ?>" target="_blank" class="btn btn-sm btn-outline-danger mb-1">Rundown</a><br>
                                    <?php endif; ?>
                                    <?php if($k['surat_keterangan']): ?>
                                        <a href="<?= base_url($k['surat_keterangan']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary mb-1">SK/Surat Tugas</a>
                                    <?php endif; ?>
                                    <?php if(!$k['proposal_laporan'] && !$k['file_absensi'] && !$k['foto_kegiatan'] && !$k['rundown_kegiatan'] && !$k['surat_keterangan']) echo '-'; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary">2. Ringkasan Prestasi Siswa</h5>
        </div>
        <div class="card-body">
            <?php if(empty($prestasi)): ?>
                <p class="text-muted">Tidak ada data prestasi yang disetujui.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Nama Prestasi</th>
                                <th>Tingkat</th>
                                <th>Peringkat</th>
                                <th>Akses Data (File)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($prestasi as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-bold"><?= esc($p['nama_siswa']) ?></td>
                                <td><?= esc($p['nama_prestasi']) ?></td>
                                <td><?= esc($p['tingkat']) ?></td>
                                <td><?= esc($p['peringkat']) ?></td>
                                <td>
                                    <?php if($p['file_sertifikat']): ?>
                                        <a href="<?= base_url('view/prestasi/'.basename($p['file_sertifikat'])) ?>" target="_blank" class="btn btn-sm btn-outline-success mb-1">Sertifikat</a><br>
                                    <?php endif; ?>
                                    <?php 
                                    if(!empty($p['surat_tugas'])): 
                                        $tugas = json_decode($p['surat_tugas'], true);
                                        if(is_array($tugas) && !empty($tugas)):
                                            foreach($tugas as $i => $file):
                                    ?>
                                        <a href="<?= base_url('view/prestasi/'.basename($file)) ?>" target="_blank" class="btn btn-sm btn-outline-secondary mb-1">Surat Tugas <?= $i+1 ?></a><br>
                                    <?php 
                                            endforeach;
                                        endif;
                                    endif; 
                                    if(!$p['file_sertifikat'] && empty($p['surat_tugas'])) echo '-';
                                    ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary">3. Ringkasan Program Kerja OSIS</h5>
        </div>
        <div class="card-body">
            <?php if(empty($osis)): ?>
                <p class="text-muted">Tidak ada data program OSIS.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Program</th>
                                <th>Seksi</th>
                                <th>Periode</th>
                                <th>Akses Data (File)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($osis as $o): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-bold"><?= esc($o['nama_program']) ?></td>
                                <td><?= esc($o['seksi']) ?></td>
                                <td><?= esc($o['periode']) ?></td>
                                <td>
                                    <?php if(!empty($o['file_proposal'])): ?>
                                        <a href="<?= base_url($o['file_proposal']) ?>" target="_blank" class="btn btn-sm btn-outline-primary mb-1">Proposal</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary">4. Ringkasan Laporan Kegiatan OSIS</h5>
        </div>
        <div class="card-body">
            <?php if(empty($laporan_osis)): ?>
                <p class="text-muted">Tidak ada data laporan kegiatan OSIS.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Peserta</th>
                                <th>Akses Data (File)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($laporan_osis as $lo): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-bold"><?= esc($lo['nama_kegiatan']) ?></td>
                                <td><?= $lo['tanggal_pelaksanaan'] ? date('d/m/Y', strtotime($lo['tanggal_pelaksanaan'])) : '-' ?></td>
                                <td><?= esc($lo['jumlah_peserta']) ?></td>
                                <td>
                                    <?php if(!empty($lo['file_laporan'])): ?>
                                        <a href="<?= base_url($lo['file_laporan']) ?>" target="_blank" class="btn btn-sm btn-outline-danger mb-1">Laporan</a><br>
                                    <?php endif; ?>
                                    <?php if(!empty($lo['dokumentasi'])): ?>
                                        <a href="<?= base_url($lo['dokumentasi']) ?>" target="_blank" class="btn btn-sm btn-outline-info mb-1">Dokumentasi</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary">5. Ringkasan Dokumen OSIS</h5>
        </div>
        <div class="card-body">
            <?php if(empty($dokumen_osis)): ?>
                <p class="text-muted">Tidak ada data dokumen OSIS.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Dokumen</th>
                                <th>Jenis</th>
                                <th>Periode</th>
                                <th>Akses Data (File)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($dokumen_osis as $do): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-bold"><?= esc($do['nama_dokumen']) ?></td>
                                <td><?= esc($do['jenis_dokumen']) ?></td>
                                <td><?= esc($do['periode']) ?></td>
                                <td>
                                    <?php if(!empty($do['file_path'])): ?>
                                        <a href="<?= base_url($do['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">Buka Dokumen</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
