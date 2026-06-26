<?php

namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\PrestasiModel;
use App\Models\ProgramOsisModel;
use App\Models\DokumenOsisModel;

class Laporan extends BaseController
{
    protected $kegiatanModel;
    protected $prestasiModel;
    protected $programOsisModel;
    protected $dokumenOsisModel;

    public function __construct()
    {
        $this->kegiatanModel = new KegiatanModel();
        $this->prestasiModel = new PrestasiModel();
        $this->programOsisModel = new ProgramOsisModel();
        $this->dokumenOsisModel = new DokumenOsisModel();
    }

    public function index()
    {
        // Cek role
        $role = session()->get('role');
        if (!in_array($role, ['admin', 'waka_kesiswaan', 'kepala_sekolah'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        // Statistik REAL dari database
        $data = [
            'title' => 'Laporan',
            'total_kegiatan' => $this->kegiatanModel->countAll(),
            'total_prestasi' => $this->prestasiModel->countAll(),
            'total_program_osis' => $this->programOsisModel->countAll() // GANTI DENGAN PROGRAM OSIS
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('laporan/index', $data)
             . view('template/footer');
    }

    public function komprehensif()
    {
        // Cek role
        $role = session()->get('role');
        if (!in_array($role, ['admin', 'waka_kesiswaan', 'kepala_sekolah'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $tahun = $this->request->getGet('tahun');

        $db = \Config\Database::connect();

        // Ambil Kegiatan Disetujui
        $builderKegiatan = $db->table('kegiatan');
        $builderKegiatan->where('status_verifikasi', 'disetujui');
        if (!empty($tahun)) {
            $builderKegiatan->like('tahun_ajaran', $tahun);
        }
        $builderKegiatan->orderBy('tanggal_mulai', 'DESC');
        $kegiatan = $builderKegiatan->get()->getResultArray();

        // Ambil Prestasi Disetujui
        $builderPrestasi = $db->table('prestasi');
        $builderPrestasi->where('status_verifikasi', 'disetujui');
        if (!empty($tahun)) {
            $builderPrestasi->where('tahun_perolehan', $tahun);
        }
        $builderPrestasi->orderBy('tahun_perolehan', 'DESC');
        $prestasi = $builderPrestasi->get()->getResultArray();

        // Ambil Program OSIS (Tidak ada status_verifikasi)
        $builderOsis = $db->table('program_osis');
        if (!empty($tahun)) {
            $builderOsis->like('periode', $tahun);
        }
        $builderOsis->orderBy('tanggal_mulai', 'DESC');
        $osis = $builderOsis->get()->getResultArray();

        // Ambil Laporan Kegiatan OSIS
        $builderLaporanOsis = $db->table('laporan_kegiatan_osis');
        if (!empty($tahun)) {
            $builderLaporanOsis->like('tanggal_pelaksanaan', $tahun);
        }
        $builderLaporanOsis->orderBy('tanggal_pelaksanaan', 'DESC');
        $laporan_osis = $builderLaporanOsis->get()->getResultArray();

        // Ambil Dokumen OSIS
        $builderDokumenOsis = $db->table('dokumen_osis');
        if (!empty($tahun)) {
            $builderDokumenOsis->like('periode', $tahun);
        }
        $builderDokumenOsis->orderBy('created_at', 'DESC');
        $dokumen_osis = $builderDokumenOsis->get()->getResultArray();

        $data = [
            'title' => 'Laporan Matang (Komprehensif)',
            'kegiatan' => $kegiatan,
            'prestasi' => $prestasi,
            'osis' => $osis,
            'laporan_osis' => $laporan_osis,
            'dokumen_osis' => $dokumen_osis,
            'tahun_filter' => $tahun
        ];
        
                return view('template/header', $data)
             . view('template/sidebar')
             . view('laporan/komprehensif_view', $data)
             . view('template/footer');
    }

    public function komprehensif_cetak()
    {
        // Cek role
        $role = session()->get('role');
        if (!in_array($role, ['admin', 'waka_kesiswaan', 'kepala_sekolah'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $tahun = $this->request->getGet('tahun');
        $db = \Config\Database::connect();

        // Ambil Kegiatan Disetujui
        $builderKegiatan = $db->table('kegiatan');
        $builderKegiatan->where('status_verifikasi', 'disetujui');
        if (!empty($tahun)) {
            $builderKegiatan->like('tahun_ajaran', $tahun);
        }
        $builderKegiatan->orderBy('tanggal_mulai', 'DESC');
        $kegiatan = $builderKegiatan->get()->getResultArray();

        // Ambil Prestasi Disetujui
        $builderPrestasi = $db->table('prestasi');
        $builderPrestasi->where('status_verifikasi', 'disetujui');
        if (!empty($tahun)) {
            $builderPrestasi->where('tahun_perolehan', $tahun);
        }
        $builderPrestasi->orderBy('tahun_perolehan', 'DESC');
        $prestasi = $builderPrestasi->get()->getResultArray();

        // Ambil Program OSIS
        $builderOsis = $db->table('program_osis');
        if (!empty($tahun)) {
            $builderOsis->like('periode', $tahun);
        }
        $builderOsis->orderBy('tanggal_mulai', 'DESC');
        $osis = $builderOsis->get()->getResultArray();

        // Ambil Laporan Kegiatan OSIS
        $builderLaporanOsis = $db->table('laporan_kegiatan_osis');
        if (!empty($tahun)) {
            $builderLaporanOsis->like('tanggal_pelaksanaan', $tahun);
        }
        $builderLaporanOsis->orderBy('tanggal_pelaksanaan', 'DESC');
        $laporan_osis = $builderLaporanOsis->get()->getResultArray();

        // Ambil Dokumen OSIS
        $builderDokumenOsis = $db->table('dokumen_osis');
        if (!empty($tahun)) {
            $builderDokumenOsis->like('periode', $tahun);
        }
        $builderDokumenOsis->orderBy('created_at', 'DESC');
        $dokumen_osis = $builderDokumenOsis->get()->getResultArray();

        $data = [
            'title' => 'Cetak Laporan Komprehensif',
            'kegiatan' => $kegiatan,
            'prestasi' => $prestasi,
            'osis' => $osis,
            'laporan_osis' => $laporan_osis,
            'dokumen_osis' => $dokumen_osis,
            'tahun_filter' => $tahun
        ];
        
        return view('laporan/komprehensif_pdf', $data);
    }

    public function kegiatan()
    {
        $tahun_ajaran = $this->request->getGet('tahun_ajaran') ?? '';
        $jenis_kegiatan = $this->request->getGet('jenis_kegiatan') ?? '';

        $db = \Config\Database::connect();
        $builder = $db->table('kegiatan');
        $builder->select('kegiatan.*');

        // Filter hanya jika ada nilai
        if ($tahun_ajaran) {
            $builder->where('kegiatan.tahun_ajaran', $tahun_ajaran);
        }

        if ($jenis_kegiatan) {
            $builder->where('kegiatan.jenis_kegiatan', $jenis_kegiatan);
        }

        $builder->orderBy('kegiatan.tanggal_mulai', 'DESC');
        $kegiatan = $builder->get()->getResultArray();

        $data = [
            'title' => 'Laporan Kegiatan',
            'kegiatan' => $kegiatan,
            'tahun_ajaran' => $tahun_ajaran,
            'jenis_kegiatan' => $jenis_kegiatan
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('laporan/kegiatan', $data)
             . view('template/footer');
    }

    public function prestasi()
    {
        $tahun = $this->request->getGet('tahun') ?? '';
        $tingkat = $this->request->getGet('tingkat') ?? '';

        $db = \Config\Database::connect();
        $builder = $db->table('prestasi');
        $builder->select('prestasi.*');

        // Filter hanya jika ada nilai
        if ($tahun) {
            $builder->where('prestasi.tahun_perolehan', $tahun);
        }

        if ($tingkat) {
            $builder->where('prestasi.tingkat', $tingkat);
        }

        $builder->orderBy('prestasi.tahun_perolehan', 'DESC');
        $prestasi = $builder->get()->getResultArray();

        $data = [
            'title' => 'Laporan Prestasi',
            'prestasi' => $prestasi,
            'tahun' => $tahun,
            'tingkat' => $tingkat
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('laporan/prestasi', $data)
             . view('template/footer');
    }

    public function osis()
    {
        $db = \Config\Database::connect();
        
        // 1. Data Program Kerja
        $builderProker = $db->table('program_osis');
        $builderProker->select('program_osis.*, users.nama_lengkap as nama_creator');
        $builderProker->join('users', 'users.id_user = program_osis.created_by', 'left');
        $builderProker->orderBy('program_osis.tanggal_mulai', 'DESC');
        $program = $builderProker->get()->getResultArray();

        // 2. Data Laporan Kegiatan
        $laporan = [];
        try {
            $builderLaporan = $db->table('laporan_kegiatan_osis');
            $builderLaporan->select('laporan_kegiatan_osis.*, users.nama_lengkap as uploader');
            $builderLaporan->join('users', 'users.id_user = laporan_kegiatan_osis.created_by', 'left');
            $builderLaporan->orderBy('laporan_kegiatan_osis.tanggal_pelaksanaan', 'DESC');
            $laporan = $builderLaporan->get()->getResultArray();
        } catch (\Exception $e) {
            $laporan = [];
        }

        // 3. Data Dokumen
        $builderDokumen = $db->table('dokumen_osis');
        $builderDokumen->select('dokumen_osis.*, users.nama_lengkap as uploader_name');
        $builderDokumen->join('users', 'users.id_user = dokumen_osis.uploaded_by', 'left');
        $builderDokumen->orderBy('dokumen_osis.created_at', 'DESC');
        $dokumen = $builderDokumen->get()->getResultArray();

        $data = [
            'title' => 'Laporan OSIS',
            'program' => $program,
            'laporan' => $laporan,
            'dokumen' => $dokumen,
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('laporan/osis', $data)
             . view('template/footer');
    }

    public function detail_osis($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('program_osis');
        $builder->select('program_osis.*, users.nama_lengkap as nama_creator');
        $builder->join('users', 'users.id_user = program_osis.created_by', 'left');
        $builder->where('program_osis.id_program', $id);
        $program = $builder->get()->getRowArray();

        if (!$program) {
            return '<div class="alert alert-danger">Data tidak ditemukan</div>';
        }

        $html = '
        <table class="table table-bordered">
            <tr>
                <th width="200">Nama Program</th>
                <td><strong>' . esc($program['nama_program']) . '</strong></td>
            </tr>
            <tr>
                <th>Seksi/Divisi</th>
                <td>' . esc($program['seksi']) . '</td>
            </tr>
            <tr>
                <th>Periode</th>
                <td>' . esc($program['periode']) . '</td>
            </tr>
            <tr>
                <th>Tanggal Mulai</th>
                <td>' . ($program['tanggal_mulai'] ? date('d F Y', strtotime($program['tanggal_mulai'])) : '-') . '</td>
            </tr>
            <tr>
                <th>Tanggal Selesai</th>
                <td>' . ($program['tanggal_selesai'] ? date('d F Y', strtotime($program['tanggal_selesai'])) : '-') . '</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>' . nl2br(esc($program['deskripsi'])) . '</td>
            </tr>';

        if (!empty($program['file_proposal'])) {
            $filename = basename($program['file_proposal']);
            $url = base_url('view/osis/' . $filename);
            $html .= '
            <tr>
                <th>Proposal</th>
                <td>
                    <a href="' . $url . '" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-file-earmark-pdf"></i> Lihat Proposal
                    </a>
                </td>
            </tr>';
        }

        $html .= '
            <tr>
                <th>Dibuat Oleh</th>
                <td>' . esc($program['nama_creator'] ?? '-') . '</td>
            </tr>
            <tr>
                <th>Tanggal Input</th>
                <td>' . (!empty($program['created_at']) ? date('d F Y H:i:s', strtotime($program['created_at'])) : '-') . '</td>
            </tr>
        </table>';

        return $html;
    }

    public function detail_dokumen($id)
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('dokumen_osis');
            $builder->select('dokumen_osis.*, users.nama_lengkap as uploader');
            $builder->join('users', 'users.id_user = dokumen_osis.uploaded_by', 'left');
            $builder->where('dokumen_osis.id_dokumen', $id);
            $dokumen = $builder->get()->getRowArray();

            if (!$dokumen) {
                return '<div class="alert alert-danger">Dokumen tidak ditemukan</div>';
            }

            $html = '
            <table class="table table-bordered">
                <tr>
                    <th width="200">Nama Dokumen</th>
                    <td><strong>' . esc($dokumen['nama_dokumen']) . '</strong></td>
                </tr>
                <tr>
                    <th>Jenis Dokumen</th>
                    <td>' . esc($dokumen['jenis_dokumen']) . '</td>
                </tr>
                <tr>
                    <th>Periode</th>
                    <td>' . esc($dokumen['periode']) . '</td>
                </tr>';

            if (!empty($dokumen['file_path'])) {
                $filename = basename($dokumen['file_path']);
                $url = base_url('view/osis/' . $filename);
                $html .= '
                <tr>
                    <th>File</th>
                    <td>
                        <a href="' . $url . '" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-file-earmark-pdf"></i> Lihat File
                        </a>
                    </td>
                </tr>';
            }

            $html .= '
                <tr>
                    <th>Diupload Oleh</th>
                    <td>' . esc($dokumen['uploader'] ?? '-') . '</td>
                </tr>
                <tr>
                    <th>Tanggal Upload</th>
                    <td>' . (!empty($dokumen['created_at']) ? date('d F Y H:i:s', strtotime($dokumen['created_at'])) : '-') . '</td>
                </tr>
            </table>';

            return $html;
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        }
    }

    public function detail_laporan($id)
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('laporan_kegiatan_osis');
            $builder->select('laporan_kegiatan_osis.*, users.nama_lengkap as uploader');
            $builder->join('users', 'users.id_user = laporan_kegiatan_osis.created_by', 'left');
            $builder->where('laporan_kegiatan_osis.id_laporan', $id);
            $laporan = $builder->get()->getRowArray();

            if (!$laporan) {
                return '<div class="alert alert-danger">Laporan tidak ditemukan</div>';
            }

            $vStatus = $laporan['status_verifikasi'] ?? 'menunggu';
            $statusBadge = '';
            if ($vStatus == 'disetujui') {
                $statusBadge = '<span class="badge bg-success">Disetujui</span>';
            } elseif ($vStatus == 'ditolak') {
                $statusBadge = '<span class="badge bg-danger" title="Alasan: ' . esc($laporan['alasan_penolakan'] ?? '-') . '">Ditolak</span>';
            } else {
                $statusBadge = '<span class="badge bg-warning text-dark">Menunggu</span>';
            }

            $html = '
            <table class="table table-bordered">
                <tr>
                    <th width="200">Nama Kegiatan</th>
                    <td><strong>' . esc($laporan['nama_kegiatan']) . '</strong></td>
                </tr>
                <tr>
                    <th>Tanggal Pelaksanaan</th>
                    <td>' . ($laporan['tanggal_pelaksanaan'] ? date('d F Y', strtotime($laporan['tanggal_pelaksanaan'])) : '-') . '</td>
                </tr>
                <tr>
                    <th>Jumlah Peserta</th>
                    <td>' . esc($laporan['jumlah_peserta']) . '</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>' . $statusBadge . '</td>
                </tr>';

            if (!empty($laporan['alasan_penolakan'])) {
                $html .= '
                <tr>
                    <th>Alasan Penolakan</th>
                    <td class="text-danger">' . esc($laporan['alasan_penolakan']) . '</td>
                </tr>';
            }

            if (!empty($laporan['dokumentasi'])) {
                $url = base_url('file/view/' . $laporan['dokumentasi']);
                $html .= '
                <tr>
                    <th>Dokumentasi</th>
                    <td>
                        <a href="' . $url . '" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> Lihat Dokumentasi
                        </a>
                    </td>
                </tr>';
            }

            if (!empty($laporan['file_laporan'])) {
                $url = base_url('file/view/' . $laporan['file_laporan']);
                $html .= '
                <tr>
                    <th>File Laporan</th>
                    <td>
                        <a href="' . $url . '" target="_blank" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-download"></i> Unduh Laporan
                        </a>
                    </td>
                </tr>';
            }

            $html .= '
                <tr>
                    <th>Diupload Oleh</th>
                    <td>' . esc($laporan['uploader'] ?? '-') . '</td>
                </tr>
                <tr>
                    <th>Tanggal Upload</th>
                    <td>' . (!empty($laporan['created_at']) ? date('d F Y H:i:s', strtotime($laporan['created_at'])) : '-') . '</td>
                </tr>
            </table>';

            return $html;
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        }
    }

    public function dokumen()
    {
        $kategori = $this->request->getGet('kategori');

        $db = \Config\Database::connect();
        $builder = $db->table('dokumen_akreditasi');
        $builder->select('dokumen_akreditasi.*, users.nama_lengkap as uploader');
        $builder->join('users', 'users.id_user = dokumen_akreditasi.uploaded_by', 'left');

        if ($kategori) {
            $builder->where('dokumen_akreditasi.kategori', $kategori);
        }

        $builder->orderBy('dokumen_akreditasi.uploaded_at', 'DESC');
        $dokumen = $builder->get()->getResultArray();

        $data = [
            'title' => 'Laporan Kelengkapan Dokumen',
            'dokumen' => $dokumen,
            'kategori' => $kategori
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('laporan/dokumen', $data)
             . view('template/footer');
    }

    // Export Excel Kegiatan (detail)
    public function export_kegiatan()
    {
        $tahun_ajaran = $this->request->getGet('tahun_ajaran');
        $jenis_kegiatan = $this->request->getGet('jenis_kegiatan');

        $db = \Config\Database::connect();
        $builder = $db->table('kegiatan');
        $builder->select('kegiatan.*');
        $builder->where("(kegiatan.status_verifikasi != 'ditolak' OR kegiatan.status_verifikasi IS NULL)");

        if ($tahun_ajaran) {
            $builder->where('kegiatan.tahun_ajaran', $tahun_ajaran);
        }

        if ($jenis_kegiatan) {
            $builder->where('kegiatan.jenis_kegiatan', $jenis_kegiatan);
        }

        $builder->orderBy('kegiatan.tanggal_mulai', 'DESC');
        $kegiatan = $builder->get()->getResultArray();

        $filename = 'Laporan_Kegiatan_Detail_' . date('Y-m-d') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head><meta charset="UTF-8"></head><body>';
        echo '<table border="1" cellpadding="5">';
        echo '<tr>';
        $headers = [
            'No',
            'Nama Kegiatan',
            'Jenis',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Tempat',
            'Tahun Ajaran',
            'Status',
            'File Absensi',
            'Foto Kegiatan',
            'Rundown Kegiatan',
            'Surat Keputusan / SK',
            'Laporan Kegiatan'
        ];
        foreach($headers as $h) echo '<th style="background-color:#4CAF50;color:white;font-weight:bold;">'.$h.'</th>';
        echo '</tr>';
        
        $no = 1;
        foreach ($kegiatan as $k) {
            echo '<tr>';
            $row = [
                $no++,
                $k['nama_kegiatan'],
                $k['jenis_kegiatan'],
                date('d/m/Y', strtotime($k['tanggal_mulai'])),
                $k['tanggal_selesai'] ? date('d/m/Y', strtotime($k['tanggal_selesai'])) : '-',
                    $k['tempat'],
                    $k['tahun_ajaran'],
                    ucfirst($k['status_verifikasi']),
                $k['file_absensi'] ? base_url($k['file_absensi']) : '-',
                $k['foto_kegiatan'] ? base_url($k['foto_kegiatan']) : '-',
                $k['rundown_kegiatan'] ? base_url($k['rundown_kegiatan']) : '-',
                $k['surat_keterangan'] ? base_url($k['surat_keterangan']) : '-',
                $k['proposal_laporan'] ? base_url($k['proposal_laporan']) : '-'
            ];
            foreach($row as $cell) echo '<td style="vertical-align:top;">'.$cell.'</td>';
            echo '</tr>';
        }
        
        echo '</table></body></html>';
        exit;
    }

    // Export Excel Prestasi (detail)
    public function export_prestasi()
    {
        $tahun = $this->request->getGet('tahun');
        $tingkat = $this->request->getGet('tingkat');

        $db = \Config\Database::connect();
        $builder = $db->table('prestasi');
        $builder->select('prestasi.*');
        $builder->where("(prestasi.status_verifikasi != 'ditolak' OR prestasi.status_verifikasi IS NULL)");

        if ($tahun) {
            $builder->where('prestasi.tahun_perolehan', $tahun);
        }

        if ($tingkat) {
            $builder->where('prestasi.tingkat', $tingkat);
        }

        $builder->orderBy('prestasi.created_at', 'DESC');
        $prestasi = $builder->get()->getResultArray();

        $filename = 'Laporan_Prestasi_Detail_' . date('Y-m-d') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head><meta charset="UTF-8"></head><body>';
        echo '<table border="1" cellpadding="5">';
        echo '<tr>';
        $headers = [
            'No',
            'Nama Siswa',
            'Nama Prestasi',
            'Tingkat',
            'Kategori',
            'Peringkat',
            'Tahun',
            'Penyelenggara',
            'Status',
            'File Sertifikat',
            'Surat Undangan/Tugas'
        ];
        foreach($headers as $h) echo '<th style="background-color:#4CAF50;color:white;font-weight:bold;">'.$h.'</th>';
        echo '</tr>';
        
        $no = 1;
        foreach ($prestasi as $p) {
            // Get links for multiple files
            $suratLinks = '-';
            if (!empty($p['surat_tugas'])) {
                $tugas = json_decode($p['surat_tugas'], true);
                if (is_array($tugas) && !empty($tugas)) {
                    $links = array_map(fn($f) => base_url('view/prestasi/' . basename($f)), $tugas);
                    $suratLinks = implode(" | ", $links);
                }
            }

            echo '<tr>';
            $row = [
                $no++,
                $p['nama_siswa'],
                $p['nama_prestasi'],
                ucfirst($p['tingkat']),
                $p['kategori'],
                $p['peringkat'],
                $p['tahun_perolehan'],
                $p['penyelenggara'],
                ucfirst($p['status_verifikasi']),
                $p['file_sertifikat'] ? base_url('view/prestasi/' . basename($p['file_sertifikat'])) : '-',
                $suratLinks
            ];
            foreach($row as $cell) echo '<td style="vertical-align:top;">'.$cell.'</td>';
            echo '</tr>';
        }
        
        echo '</table></body></html>';
        exit;
    }

        public function export_osis_proker()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('program_osis');
        
        $periode = $this->request->getGet('periode');
        if ($periode) {
            $builder->where('program_osis.periode', $periode);
        }
        
        $builder->orderBy('program_osis.tanggal_mulai', 'DESC');
        $program = $builder->get()->getResultArray();

        $filename = 'Laporan_Program_OSIS_' . date('Y-m-d') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head><meta charset="UTF-8"></head><body>';
        echo '<table border="1" cellpadding="5">';
        echo '<tr>';
        $headers = [
            'No',
            'Nama Program',
            'Seksi/Divisi',
            'Periode',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Deskripsi',
            'File Proposal'
        ];
        foreach($headers as $h) echo '<th style="background-color:#4CAF50;color:white;font-weight:bold;">'.$h.'</th>';
        echo '</tr>';
        
        $no = 1;
        foreach ($program as $p) {
            $fileUrl = !empty($p['file_proposal']) ? base_url('view/osis/' . basename($p['file_proposal'])) : '-';
            echo '<tr>';
            $row = [
                $no++,
                $p['nama_program'],
                $p['seksi'],
                $p['periode'],
                $p['tanggal_mulai'] ? date('d/m/Y', strtotime($p['tanggal_mulai'])) : '-',
                $p['tanggal_selesai'] ? date('d/m/Y', strtotime($p['tanggal_selesai'])) : '-',
                $p['deskripsi'],
                $fileUrl
            ];
            foreach($row as $cell) echo '<td style="vertical-align:top;">'.$cell.'</td>';
            echo '</tr>';
        }
        
        echo '</table></body></html>';
        exit;
    }

        public function export_osis_laporan()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('laporan_kegiatan_osis');
        $builder->select('laporan_kegiatan_osis.*');
        
        $periode = $this->request->getGet('periode');
        if ($periode) {
            $years = explode('/', $periode);
            if(count($years) == 2) {
                $start = trim($years[0]) . '-07-01';
                $end = trim($years[1]) . '-06-30';
                $builder->where('laporan_kegiatan_osis.tanggal_pelaksanaan >=', $start);
                $builder->where('laporan_kegiatan_osis.tanggal_pelaksanaan <=', $end);
            }
        }
        
        $builder->orderBy('laporan_kegiatan_osis.tanggal_pelaksanaan', 'DESC');
        
        $laporan = [];
        try {
            $laporan = $builder->get()->getResultArray();
        } catch (\Exception $e) {
            $laporan = [];
        }

        $filename = 'Laporan_Kegiatan_OSIS_' . date('Y-m-d') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head><meta charset="UTF-8"></head><body>';
        echo '<table border="1" cellpadding="5">';
        echo '<tr>';
        $headers = [
            'No',
            'Nama Kegiatan',
            'Tanggal Pelaksanaan',
            'Jumlah Peserta',
            'Dokumentasi',
            'File Laporan'
        ];
        foreach($headers as $h) echo '<th style="background-color:#4CAF50;color:white;font-weight:bold;">'.$h.'</th>';
        echo '</tr>';
        
        $no = 1;
        foreach ($laporan as $l) {
            $dokUrl = !empty($l['dokumentasi']) ? base_url($l['dokumentasi']) : '-';
            $lapUrl = !empty($l['file_laporan']) ? base_url($l['file_laporan']) : '-';
            echo '<tr>';
            $row = [
                $no++,
                $l['nama_kegiatan'],
                date('d/m/Y', strtotime($l['tanggal_pelaksanaan'])),
                $l['jumlah_peserta'],
                $dokUrl,
                $lapUrl
            ];
            foreach($row as $cell) echo '<td style="vertical-align:top;">'.$cell.'</td>';
            echo '</tr>';
        }
        
        echo '</table></body></html>';
        exit;
    }

        public function export_osis_dokumen()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dokumen_osis');
        $builder->select('dokumen_osis.*');
        
        $periode = $this->request->getGet('periode');
        if ($periode) {
            $builder->where('dokumen_osis.periode', $periode);
        }
        
        $builder->orderBy('dokumen_osis.created_at', 'DESC');
        $dokumen = $builder->get()->getResultArray();

        $filename = 'Laporan_Dokumen_OSIS_' . date('Y-m-d') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head><meta charset="UTF-8"></head><body>';
        echo '<table border="1" cellpadding="5">';
        echo '<tr>';
        $headers = [
            'No',
            'Nama Dokumen',
            'Jenis Dokumen',
            'Periode',
            'Tanggal Upload',
            'File'
        ];
        foreach($headers as $h) echo '<th style="background-color:#4CAF50;color:white;font-weight:bold;">'.$h.'</th>';
        echo '</tr>';
        
        $no = 1;
        foreach ($dokumen as $d) {
            $fileUrl = !empty($d['file_path']) ? base_url('view/osis/' . basename($d['file_path'])) : '-';
            echo '<tr>';
            $row = [
                $no++,
                $d['nama_dokumen'],
                $d['jenis_dokumen'],
                $d['periode'],
                date('d/m/Y H:i', strtotime($d['created_at'])),
                $fileUrl
            ];
            foreach($row as $cell) echo '<td style="vertical-align:top;">'.$cell.'</td>';
            echo '</tr>';
        }
        
        echo '</table></body></html>';
        exit;
    }

    // Export Excel Dokumen Akreditasi
    public function export_dokumen()
    {
        $kategori = $this->request->getGet('kategori');

        $db = \Config\Database::connect();
        $builder = $db->table('dokumen_akreditasi');
        $builder->select('dokumen_akreditasi.*, users.nama_lengkap as uploader');
        $builder->join('users', 'users.id_user = dokumen_akreditasi.uploaded_by', 'left');

        if ($kategori) {
            $builder->where('dokumen_akreditasi.kategori', $kategori);
        }

        $builder->orderBy('dokumen_akreditasi.uploaded_at', 'DESC');
        $dokumen = $builder->get()->getResultArray();

        $filename = 'Laporan_Dokumen_Akreditasi_' . date('Y-m-d') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head><meta charset="UTF-8"></head><body>';
        echo '<table border="1" cellpadding="5">';
        echo '<tr>';
        $headers = [
            'No',
            'Nama Dokumen',
            'Kategori',
            'Tahun Dokumen',
            'Diupload Oleh',
            'Status Kelengkapan',
            'Status Verifikasi',
            'Tanggal Upload'
        ];
        foreach($headers as $h) echo '<th style="background-color:#4CAF50;color:white;font-weight:bold;">'.$h.'</th>';
        echo '</tr>';
        
        $no = 1;
        foreach ($dokumen as $d) {
            echo '<tr>';
            $row = [
                $no++,
                $d['nama_dokumen'],
                ucfirst($d['kategori']),
                $d['tahun_dokumen'],
                $d['uploader'] ?? '-',
                $d['status_kelengkapan'] == 'lengkap' ? 'Lengkap' : 'Belum Lengkap',
                ucfirst($d['status_verifikasi']),
                date('d/m/Y H:i', strtotime($d['uploaded_at']))
            ];
            foreach($row as $cell) echo '<td style="vertical-align:top;">'.$cell.'</td>';
            echo '</tr>';
        }
        
        echo '</table></body></html>';
        exit;
    }
}
