<div class="container-fluid">
    <!-- Breadcrumb dihilangkan sesuai permintaan -->

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-people text-dark"></i> 
            Laporan OSIS
        </h2>
        <a href="<?= base_url('laporan') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Statistik Ringkas OSIS -->
    <div class="row g-3 mb-4">


        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded p-3" style="background-color: rgba(91, 127, 255, 0.1);">
                                <i class="bi bi-clipboard-check fs-2 text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0"><?= $total_program ?></h3>
                            <p class="mb-0 text-muted small">Total Program Kerja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded p-3" style="background-color: rgba(255, 193, 7, 0.1);">
                                <i class="bi bi-file-earmark-text fs-2 text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0"><?= $total_dokumen ?></h3>
                            <p class="mb-0 text-muted small">Dokumen Lengkap</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="<?= base_url('osis/laporan') ?>">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tahun Ajaran</label>
                    <select name="tahun_ajaran" class="form-select">
                        <option value="">Semua Tahun Ajaran</option> <!-- OPSI BARU INI -->
                        <?php 
                        for($y = 2029; $y >= 2024; $y--): 
                            $year = $y . '/' . ($y + 1);
                        ?>
                            <option value="<?= $year ?>" <?= ($tahun_ajaran == $year) ? 'selected' : '' ?>>
                                <?= $year ?>
                            </option>
                        <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status Program Kerja</label>
                        <select name="status_program" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="selesai" <?= (isset($status_program) && $status_program == 'selesai') ? 'selected' : '' ?>>Terlaksana</option>
                            <option value="berlangsung" <?= (isset($status_program) && $status_program == 'berlangsung') ? 'selected' : '' ?>>Sedang Berlangsung</option>
                            <option value="perencanaan" <?= (isset($status_program) && $status_program == 'perencanaan') ? 'selected' : '' ?>>Direncanakan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Divisi</label>
                        <select name="divisi" class="form-select">
                            <option value="">Semua Divisi</option>
                            <option value="Ketua & Wakil" <?= (isset($divisi) && $divisi == 'Ketua & Wakil') ? 'selected' : '' ?>>Ketua & Wakil</option>
                            <option value="Sekretaris" <?= (isset($divisi) && $divisi == 'Sekretaris') ? 'selected' : '' ?>>Sekretaris</option>
                            <option value="Bendahara" <?= (isset($divisi) && $divisi == 'Bendahara') ? 'selected' : '' ?>>Bendahara</option>
                            <option value="Humas" <?= (isset($divisi) && $divisi == 'Humas') ? 'selected' : '' ?>>Humas</option>
                            <option value="Keagamaan" <?= (isset($divisi) && $divisi == 'Keagamaan') ? 'selected' : '' ?>>Keagamaan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <!-- Program Kerja OSIS -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-clipboard-check"></i> Program Kerja OSIS</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="programKerjaTable">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Nama Program</th>
                            <th width="15%">Divisi</th>
                            <th width="15%">Tanggal Mulai</th>
                            <th width="15%">Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($program_kerja)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada data program kerja</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($program_kerja as $index => $prog): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($prog['nama_program']) ?></td>
                                    <td><?= esc($prog['seksi']) ?></td>
                                    <td><?= date('d M Y', strtotime($prog['tanggal_mulai'])) ?></td>
                                    <td><?= date('d M Y', strtotime($prog['tanggal_selesai'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Dokumen OSIS -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-file-earmark-text"></i> Dokumen OSIS</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="dokumenTable">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Nama Dokumen</th>
                            <th width="15%">Jenis Dokumen</th>
                            <th width="15%">Periode</th>
                            <th width="20%">Tanggal Upload</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($dokumen)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada dokumen</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($dokumen as $index => $dok): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($dok['nama_dokumen']) ?></td>
                                    <td>
                                        <?php
                                        $badgeClass = 'bg-secondary';
                                        
                                        switch($dok['jenis_dokumen']) {
                                            case 'Administrasi':
                                                $badgeClass = 'bg-info';
                                                break;
                                            case 'Proposal':
                                                $badgeClass = 'bg-warning text-dark';
                                                break;
                                            case 'LPJ':
                                                $badgeClass = 'bg-success';
                                                break;
                                            case 'Dokumentasi':
                                                $badgeClass = 'bg-primary';
                                                break;
                                            case 'Notulensi':
                                                $badgeClass = 'bg-secondary';
                                                break;
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= esc($dok['jenis_dokumen']) ?></span>
                                    </td>
                                    <td><?= esc($dok['periode']) ?></td>
                                    <td><?= date('d M Y H:i', strtotime($dok['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tombol Export Excel di bagian bawah -->
    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-success" id="exportExcelBtn">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </button>
    </div>
</div>

<!-- Include jQuery jika belum ada di footer -->
<?php if(!isset($jquery_loaded)): ?>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<?php endif; ?>

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<!-- SheetJS (XLSX) untuk export Excel -->
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>

<script>
$(document).ready(function() {
    // Inisialisasi DataTable dengan opsi lebih lengkap


    <?php if(!empty($program_kerja)): ?>
    $('#programKerjaTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
            emptyTable: "Tidak ada data program kerja"
        },
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
        order: [[3, 'desc']] // Sort by tanggal mulai
    });
    <?php endif; ?>

    <?php if(!empty($dokumen)): ?>
    $('#dokumenTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
            emptyTable: "Tidak ada dokumen"
        },
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
        order: [[4, 'desc']] // Sort by tanggal upload
    });
    <?php endif; ?>
    
    // Auto-submit form saat ada perubahan pada dropdown filter
    $('select[name="tahun_ajaran"], select[name="status_program"], select[name="divisi"]').on('change', function() {
        $(this).closest('form').submit();
    });

    // Export Excel: gabungkan tiga sheet dengan DETAIL, tidak bergantung kolom tampilan
    $('#exportExcelBtn').on('click', function () {
        try {
            var wb = XLSX.utils.book_new();
            
            // Data dari PHP ke JS

            
            var dataProgram = <?=
                json_encode(array_map(function($pr){
                    return [
                        'Nama Program' => $pr['nama_program'] ?? '',
                        'Deskripsi' => $pr['deskripsi'] ?? '',
                        'Divisi/Seksi' => $pr['seksi'] ?? '',
                        'Periode' => $pr['periode'] ?? '',
                        'Tanggal Mulai' => isset($pr['tanggal_mulai']) ? date('d/m/Y', strtotime($pr['tanggal_mulai'])) : '',
                        'Tanggal Selesai' => isset($pr['tanggal_selesai']) ? date('d/m/Y', strtotime($pr['tanggal_selesai'])) : '',
                        'Status' => $pr['status'] ?? '',
                        'Link Proposal' => !empty($pr['file_proposal']) ? base_url('view/osis/' . basename($pr['file_proposal'])) : ''
                    ];
                }, $program_kerja ?? []), JSON_UNESCAPED_UNICODE);
            ?>;
            
            var dataDokumen = <?=
                json_encode(array_map(function($d){
                    return [
                        'Nama Dokumen' => $d['nama_dokumen'] ?? '',
                        'Jenis Dokumen' => $d['jenis_dokumen'] ?? '',
                        'Periode' => $d['periode'] ?? '',
                        'Tanggal Upload' => isset($d['created_at']) ? date('d/m/Y H:i', strtotime($d['created_at'])) : '',
                        'Diunggah Oleh' => $d['uploader_name'] ?? '',
                        'Link File' => !empty($d['file_path']) ? base_url('view/osis/' . basename($d['file_path'])) : ''
                    ];
                }, $dokumen ?? []), JSON_UNESCAPED_UNICODE);
            ?>;
            
            function aoa(data) {
                if (!data || data.length === 0) return null;
                var headers = Object.keys(data[0]);
                var rows = data.map(obj => headers.map(h => obj[h] ?? ''));
                rows.unshift(headers);
                return rows;
            }
            

            var aoaProgram = aoa(dataProgram);
            var aoaDokumen = aoa(dataDokumen);
            

            if (aoaProgram) {
                var ws2 = XLSX.utils.aoa_to_sheet(aoaProgram);
                XLSX.utils.book_append_sheet(wb, ws2, 'Program Kerja');
            }
            if (aoaDokumen) {
                var ws3 = XLSX.utils.aoa_to_sheet(aoaDokumen);
                XLSX.utils.book_append_sheet(wb, ws3, 'Dokumen OSIS');
            }

            XLSX.writeFile(wb, 'laporan_osis.xlsx');
        } catch (e) {
            alert('Gagal mengekspor Excel: ' + (e.message || e));
        }
    });
});
</script>

<style>
@media print {
    .btn, .breadcrumb, .card-header .btn, nav {
        display: none !important;
    }
    
    .card {
        page-break-inside: avoid;
    }
}

/* Custom styling untuk badge */
.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
}
</style>
