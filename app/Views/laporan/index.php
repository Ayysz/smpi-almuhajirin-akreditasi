<div class="container-fluid">
    <h2 class="mb-4"><i class="bi bi-file-bar-graph"></i> Laporan</h2>

    <div class="row g-3">
        <!-- Laporan Kegiatan -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-calendar-event text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="mb-3">Laporan Kegiatan Kesiswaan</h5>
                    <a href="<?= base_url('laporan/kegiatan') ?>" class="btn btn-primary">
                        <i class="bi bi-eye"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Laporan Prestasi -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-trophy text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="mb-3">Laporan Prestasi Siswa</h5>
                    <a href="<?= base_url('laporan/prestasi') ?>" class="btn btn-success">
                        <i class="bi bi-eye"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Laporan OSIS -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-clipboard-check text-info" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="mb-3">Laporan Program Kerja OSIS</h5>
                    <a href="<?= base_url('laporan/osis') ?>" class="btn btn-info text-white">
                        <i class="bi bi-eye"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Laporan Komprehensif (Di Bawah) -->
    <div class="row mt-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="mb-3">Laporan Komprehensif</h5>
                    <p class="text-muted mb-4">Mencetak rekapitulasi data penting (Kegiatan, Prestasi, dan Program OSIS) yang sudah disetujui.</p>
                    <form action="<?= base_url('laporan/komprehensif') ?>" method="get" class="d-flex justify-content-center align-items-center gap-2">
                        <select name="tahun" class="form-select w-auto">
                            <option value="">Semua Tahun Ajaran</option>
                            <option value="2026/2027">2026/2027</option>
                            <option value="2025/2026">2025/2026</option>
                            <option value="2024/2025">2024/2025</option>
                            <option value="2023/2024">2023/2024</option>
                            <option value="2022/2023">2022/2023</option>
                        </select>
                        <button type="submit" class="btn btn-danger text-white px-4 py-2">
                            <i class="bi bi-file-earmark-text"></i> Buka Laporan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Ringkas REAL dari Database -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-graph-up"></i> Statistik Ringkas</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="p-3">
                                <h2 class="text-primary mb-0"><?= $total_kegiatan ?? 0 ?></h2>
                                <p class="text-muted mb-0">Total Kegiatan</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3">
                                <h2 class="text-success mb-0"><?= $total_prestasi ?? 0 ?></h2>
                                <p class="text-muted mb-0">Total Prestasi</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3">
                                <h2 style="color: #7C3AED;" class="mb-0"><?= $total_program_osis ?? 0 ?></h2> <!-- UBAH INI -->
                                <p class="text-muted mb-0">Total Program Kerja OSIS</p> <!-- UBAH INI -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-purple {
        background-color: #7C3AED;
        color: white;
        border: none;
    }
    
    .btn-purple:hover {
        background-color: #6d28d9;
        color: white;
    }
</style>