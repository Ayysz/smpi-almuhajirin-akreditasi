<?php

namespace App\Controllers;

use App\Models\ProgramOsisModel;
use App\Models\DokumenOsisModel;
use App\Models\LaporanKegiatanOsisModel;

class Osis extends BaseController
{
    protected $programModel;
    protected $dokumenOsisModel;
    protected $laporanModel;

    public function __construct()
    {
        $this->programModel = new ProgramOsisModel();
        $this->dokumenOsisModel = new DokumenOsisModel();
        $this->laporanModel = new LaporanKegiatanOsisModel();
        helper(['form', 'url']);
    }

    // RBAC: admin, waka_kesiswaan, dan guru bisa akses modul OSIS
    protected function guardOsis($action = 'write')
    {
        $role = session()->get('role');
        
        if ($action == 'read') {
            $allowed = ['admin', 'waka_kesiswaan', 'guru'];
            return in_array($role, $allowed);
        }
        
        if ($action == 'write') {
            $allowed = ['waka_kesiswaan', 'guru'];
            return in_array($role, $allowed);
        }
        
        if ($action == 'delete') {
            $allowed = ['waka_kesiswaan'];
            return in_array($role, $allowed);
        }
        
        return false;
    }

    // ==================== LAPORAN KEGIATAN ====================

    public function laporanKegiatan()
    {
        if (!$this->guardOsis('read')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $laporan = [];
        try {
            $laporan = $this->laporanModel->getLaporanWithUploader();
        } catch (\Exception $e) {
            $laporan = [];
        }

        $data = [
            'title' => 'Laporan Kegiatan OSIS',
            'laporan' => $laporan
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('osis/laporan_kegiatan', $data)
             . view('template/footer');
    }

    public function tambahLaporanKegiatan()
    {
        if (!$this->guardOsis('write')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $data = ['title' => 'Tambah Laporan Kegiatan'];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('osis/tambah_laporan', $data)
             . view('template/footer');
    }

    public function simpanLaporanKegiatan()
    {
        if (!$this->guardOsis('write')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }

        $rules = [
            'nama_kegiatan' => 'required|min_length[3]|max_length[255]',
            'tanggal_pelaksanaan' => 'required|valid_date',
            'jumlah_peserta' => 'required|numeric',
            'dokumentasi' => 'uploaded[dokumentasi]|max_size[dokumentasi,2048]|ext_in[dokumentasi,jpg,jpeg,png,pdf]',
            'file_laporan' => 'uploaded[file_laporan]|max_size[file_laporan,5120]|ext_in[file_laporan,pdf]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Cek kembali inputan Anda.');
        }

        $dokumentasiPath = '';
        $fileDok = $this->request->getFile('dokumentasi');
        if ($fileDok && $fileDok->isValid() && !$fileDok->hasMoved()) {
            $newName = $fileDok->getRandomName();
            $fileDok->move(FCPATH . 'uploads/osis', $newName);
            $dokumentasiPath = 'uploads/osis/' . $newName;
        }

        $fileLaporanPath = '';
        $fileLap = $this->request->getFile('file_laporan');
        if ($fileLap && $fileLap->isValid() && !$fileLap->hasMoved()) {
            $newName = $fileLap->getRandomName();
            $fileLap->move(FCPATH . 'uploads/osis', $newName);
            $fileLaporanPath = 'uploads/osis/' . $newName;
        }

        $data = [
            'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
            'tanggal_pelaksanaan' => $this->request->getPost('tanggal_pelaksanaan'),
            'jumlah_peserta' => $this->request->getPost('jumlah_peserta'),
            'dokumentasi' => $dokumentasiPath,
            'file_laporan' => $fileLaporanPath,
            'created_by' => session()->get('id_user')
        ];

        if ($this->laporanModel->insert($data)) {
            return redirect()->to('/osis/laporan-kegiatan')->with('success', 'Laporan kegiatan berhasil disimpan!');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan laporan kegiatan.');
    }

    public function detail_laporan($id)
    {
        if (!$this->guardOsis('read')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $laporan = $this->laporanModel->getLaporanWithUploader($id);
        
        if (!$laporan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Laporan tidak ditemukan');
        }
        
        $data = [
            'title' => 'Detail Laporan - ' . $laporan['nama_kegiatan'],
            'laporan' => $laporan
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('osis/detail_laporan', $data)
             . view('template/footer');
    }

    public function edit_laporan($id)
    {
        if (!$this->guardOsis('write')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $laporan = $this->laporanModel->find($id);
        
        if (!$laporan) {
            return redirect()->to('/osis/laporan-kegiatan')->with('error', 'Laporan tidak ditemukan!');
        }
        
        if ($laporan['created_by'] != session()->get('id_user')) {
            return redirect()->to('/osis/laporan-kegiatan')->with('error', 'Akses ditolak. Anda bukan pengunggah laporan ini.');
        }

        $data = [
            'title' => 'Edit Laporan Kegiatan',
            'laporan' => $laporan
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('osis/tambah_laporan', $data) // reuse create view with populated values or create edit view
             . view('template/footer');
    }

    public function update_laporan()
    {
        if (!$this->guardOsis('write')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }

        $id = $this->request->getPost('id_laporan');
        $laporan = $this->laporanModel->find($id);
        if (!$laporan) {
            return redirect()->to('/osis/laporan-kegiatan')->with('error', 'Laporan tidak ditemukan.');
        }

        if ($laporan['created_by'] != session()->get('id_user')) {
            return redirect()->to('/osis/laporan-kegiatan')->with('error', 'Akses ditolak. Anda bukan pengunggah laporan ini.');
        }

        $rules = [
            'nama_kegiatan' => 'required|min_length[3]|max_length[255]',
            'tanggal_pelaksanaan' => 'required|valid_date',
            'jumlah_peserta' => 'required|numeric',
        ];

        if ($this->request->getFile('dokumentasi')->isValid()) {
            $rules['dokumentasi'] = 'max_size[dokumentasi,2048]|ext_in[dokumentasi,jpg,jpeg,png,pdf]';
        }
        if ($this->request->getFile('file_laporan')->isValid()) {
            $rules['file_laporan'] = 'max_size[file_laporan,5120]|ext_in[file_laporan,pdf]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Cek kembali inputan Anda.');
        }

        $data = [
            'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
            'tanggal_pelaksanaan' => $this->request->getPost('tanggal_pelaksanaan'),
            'jumlah_peserta' => $this->request->getPost('jumlah_peserta'),
            'status_verifikasi' => 'menunggu'
        ];

        $fileDok = $this->request->getFile('dokumentasi');
        if ($fileDok && $fileDok->isValid() && !$fileDok->hasMoved()) {
            $newName = $fileDok->getRandomName();
            $fileDok->move(FCPATH . 'uploads/osis', $newName);
            $data['dokumentasi'] = 'uploads/osis/' . $newName;
        }

        $fileLap = $this->request->getFile('file_laporan');
        if ($fileLap && $fileLap->isValid() && !$fileLap->hasMoved()) {
            $newName = $fileLap->getRandomName();
            $fileLap->move(FCPATH . 'uploads/osis', $newName);
            $data['file_laporan'] = 'uploads/osis/' . $newName;
        }

        if ($this->laporanModel->update($id, $data)) {
            return redirect()->to('/osis/laporan-kegiatan')->with('success', 'Laporan kegiatan berhasil diperbarui!');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal memperbarui laporan kegiatan.');
    }

    public function hapus_laporan($id)
    {
        if (!$this->guardOsis('delete')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        
        $laporan = $this->laporanModel->find($id);
        if ($laporan) {
            $this->laporanModel->delete($id);
            return redirect()->to('/osis/laporan-kegiatan')->with('success', 'Laporan berhasil dihapus!');
        }

        return redirect()->to('/osis/laporan-kegiatan')->with('error', 'Laporan gagal dihapus!');
    }

    // ==================== PROGRAM KERJA ====================
    
    public function programKerja()
    {
        if (!$this->guardOsis('read')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $data = [
            'title' => 'Program Kerja OSIS',
            'program' => $this->programModel->findAll()
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('osis/program_kerja', $data)
             . view('template/footer');
    }
    
    public function tambah_program()
    {
        if (!$this->guardOsis('write')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $data = ['title' => 'Tambah Program Kerja'];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('osis/tambah_program', $data)
             . view('template/footer');
    }

    public function simpan_program()
    {
        if (!$this->guardOsis('write')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $proposal = '';
        $file = $this->request->getFile('file_proposal');
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/osis', $newName);
            $proposal = 'uploads/osis/' . $newName;
        }

        $data = [
            'nama_program' => $this->request->getPost('nama_program'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'seksi' => $this->request->getPost('seksi'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'periode' => $this->request->getPost('periode'),
            'file_proposal' => $proposal,
            'status' => 'perencanaan',
            'created_by' => session()->get('id_user')
        ];

        $this->programModel->insert($data);
        
        return redirect()->to('/osis/program-kerja')->with('success', 'Program kerja berhasil ditambahkan!');
    }

    public function hapus_program($id)
    {
        if (!$this->guardOsis('delete')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $this->programModel->delete($id);
        
        return redirect()->to('/osis/program-kerja')->with('success', 'Program berhasil dihapus!');
    }

    public function detail_program($id)
    {
        if (!$this->guardOsis('read')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $program = $this->programModel->getProgramWithDetails($id);
        
        if (!$program) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Program tidak ditemukan');
        }
        
        $data = [
            'title' => 'Detail Program - ' . $program['nama_program'],
            'program' => $program
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('osis/detail_program', $data)
             . view('template/footer');
    }

    public function edit_program($id)
    {
        if (!$this->guardOsis('write')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $program = $this->programModel->find($id);
        
        if (!$program) {
            return redirect()->to('/osis/program-kerja')->with('error', 'Program tidak ditemukan!');
        }

        if ($program['created_by'] != session()->get('id_user')) {
            return redirect()->to('/osis/program-kerja')->with('error', 'Akses ditolak. Anda bukan pengunggah program ini.');
        }
        
        $data = [
            'title' => 'Edit Program Kerja',
            'program' => $program
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('osis/edit_program', $data)
             . view('template/footer');
    }

    public function update_program()
    {
        if (!$this->guardOsis('write')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $id = $this->request->getPost('id_program');
        $program = $this->programModel->find($id);
        if (!$program) {
            return redirect()->to('/osis/program-kerja')->with('error', 'Program tidak ditemukan!');
        }
        if ($program['created_by'] != session()->get('id_user')) {
            return redirect()->to('/osis/program-kerja')->with('error', 'Akses ditolak. Anda bukan pengunggah program ini.');
        }
        
        $data = [
            'nama_program' => $this->request->getPost('nama_program'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'seksi' => $this->request->getPost('seksi'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'periode' => $this->request->getPost('periode'),
            'status' => 'perencanaan',
            'status_verifikasi' => 'menunggu'
        ];
        
        $file = $this->request->getFile('file_proposal');
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/osis', $newName);
            $data['file_proposal'] = 'uploads/osis/' . $newName;
        }
        
        $this->programModel->update($id, $data);
        return redirect()->to('/osis/program-kerja')->with('success', 'Program berhasil diupdate!');
    }

    // ==================== DOKUMEN ====================
    
    public function dokumen()
    {
        if (!$this->guardOsis('read')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $data = [
            'title' => 'Dokumen OSIS',
            'dokumen' => $this->dokumenOsisModel->getDokumenWithUploader()
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('osis/dokumen', $data)
             . view('template/footer');
    }
    
    public function tambah_dokumen()
    {
        if (!$this->guardOsis('write')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $data = ['title' => 'Tambah Dokumen OSIS'];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('osis/tambah_dokumen', $data)
             . view('template/footer');
    }

    public function simpan_dokumen()
    {
        if (!$this->guardOsis('write')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $filePath = '';
        $file = $this->request->getFile('file_path');
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/osis', $newName);
            $filePath = 'uploads/osis/' . $newName;
        }

        $data = [
            'jenis_dokumen' => $this->request->getPost('jenis_dokumen'),
            'nama_dokumen' => $this->request->getPost('nama_dokumen'),
            'periode' => $this->request->getPost('periode'),
            'file_path' => $filePath,
            'uploaded_by' => session()->get('id_user')
        ];

        $this->dokumenOsisModel->insert($data);
        
        return redirect()->to('/osis/dokumen')->with('success', 'Dokumen berhasil ditambahkan!');
    }

    public function hapus_dokumen($id)
    {
        if (!$this->guardOsis('delete')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi.');
        }
        $this->dokumenOsisModel->delete($id);
        
        return redirect()->to('/osis/dokumen')->with('success', 'Dokumen berhasil dihapus!');
    }

    public function edit_dokumen($id)
    {
        if (!$this->guardOsis('write')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi untuk Admin, Waka, dan Guru.');
        }
        $dokumen = $this->dokumenOsisModel->find($id);
        
        if (!$dokumen) {
            return redirect()->to('/osis/dokumen')->with('error', 'Dokumen tidak ditemukan!');
        }

        if ($dokumen['uploaded_by'] != session()->get('id_user')) {
            return redirect()->to('/osis/dokumen')->with('error', 'Akses ditolak. Anda bukan pengunggah dokumen ini.');
        }

        $data = [
            'title' => 'Edit Dokumen OSIS',
            'dokumen' => $dokumen
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('osis/edit_dokumen', $data)
             . view('template/footer');
    }

    public function update_dokumen()
    {
        if (!$this->guardOsis('write')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi untuk Admin, Waka, dan Guru.');
        }
        $id = $this->request->getPost('id_dokumen');
        $dokumen = $this->dokumenOsisModel->find($id);
        if (!$dokumen) {
            return redirect()->to('/osis/dokumen')->with('error', 'Dokumen tidak ditemukan!');
        }
        if ($dokumen['uploaded_by'] != session()->get('id_user')) {
            return redirect()->to('/osis/dokumen')->with('error', 'Akses ditolak. Anda bukan pengunggah dokumen ini.');
        }
        
        $data = [
            'jenis_dokumen' => $this->request->getPost('jenis_dokumen'),
            'nama_dokumen' => $this->request->getPost('nama_dokumen'),
            'periode' => $this->request->getPost('periode')
        ];
        
        $file = $this->request->getFile('file_path');
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/osis', $newName);
            $data['file_path'] = 'uploads/osis/' . $newName;
        }
        
        $this->dokumenOsisModel->update($id, $data);
        return redirect()->to('/osis/dokumen')->with('success', 'Dokumen berhasil diupdate!');
    }

    public function detail_dokumen($id)
    {
        if (!$this->guardOsis('read')) {
            return redirect()->to('/dashboard')->with('error', 'Akses OSIS dibatasi untuk Admin, Waka, dan Guru.');
        }
        $dokumen = $this->dokumenOsisModel->getDokumenWithUploader($id);
        
        if (!$dokumen) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Dokumen tidak ditemukan');
        }
        
        $data = [
            'title' => 'Detail Dokumen - ' . $dokumen['nama_dokumen'],
            'dokumen' => $dokumen
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('osis/detail_dokumen', $data)
             . view('template/footer');
    }

  // ==================== LAPORAN OSIS ====================

/**
 * Halaman Laporan OSIS - Menampilkan semua data, filter tahun ajaran opsional
 */
public function laporan()
{
    if (!$this->guardOsis('read')) {
        return redirect()->to('/dashboard')->with('error', 'Akses Laporan OSIS ditolak.');
    }
    // Ambil filter dari request (opsional)
    $tahunAjaran = $this->request->getGet('tahun_ajaran');
    $statusProgram = $this->request->getGet('status_program');
    $divisi = $this->request->getGet('divisi');
    
    // **PERBAIKAN: Default value adalah string kosong untuk "Semua Tahun"**
    if ($tahunAjaran === null) {
        $tahunAjaran = ''; // Kosong = Semua Tahun Ajaran
    }
    
    // **PERBAIKAN: Hitung statistik berdasarkan apakah tahun ajaran dipilih atau tidak**
    $totalProgramQuery = $this->programModel;
    $prokerTerlaksanaQuery = $this->programModel;
    $totalDokumenQuery = $this->dokumenOsisModel;
    
    // Jika tahun ajaran tidak kosong (ada pilihan), filter berdasarkan tahun ajaran
    if ($tahunAjaran !== '') {
        $totalProgramQuery = $totalProgramQuery->like('periode', $tahunAjaran);
        $prokerTerlaksanaQuery = $prokerTerlaksanaQuery->like('periode', $tahunAjaran);
        $totalDokumenQuery = $totalDokumenQuery->like('periode', $tahunAjaran);
    }
    
    // Hitung statistik
    $totalProgram = $totalProgramQuery->countAllResults();
    $prokerTerlaksana = $prokerTerlaksanaQuery->where('status', 'selesai')->countAllResults();
    $totalDokumen = $totalDokumenQuery->countAllResults();
    
    // **PERBAIKAN: Ambil program kerja - filter tahun ajaran hanya jika tidak kosong**
    $programQuery = $this->programModel;
    
    // Filter tahun ajaran hanya jika tidak kosong
    if ($tahunAjaran !== '') {
        $programQuery->like('periode', $tahunAjaran);
    }
    
    // Filter status jika dipilih
    if (!empty($statusProgram)) {
        $programQuery->where('status', $statusProgram);
    }
    
    // Filter divisi jika dipilih
    if (!empty($divisi)) {
        $programQuery->where('seksi', $divisi);
    }
    
    $programKerja = $programQuery->orderBy('tanggal_mulai', 'DESC')->findAll();
    
    // **PERBAIKAN: Ambil dokumen - filter tahun ajaran hanya jika tidak kosong**
    $dokumenQuery = $this->dokumenOsisModel
        ->select('dokumen_osis.*, users.nama_lengkap as uploader_name')
        ->join('users', 'users.id_user = dokumen_osis.uploaded_by', 'left');
    
    // Filter tahun ajaran hanya jika tidak kosong
    if ($tahunAjaran !== '') {
        $dokumenQuery->like('dokumen_osis.periode', $tahunAjaran);
    }
    
    $dokumen = $dokumenQuery->orderBy('dokumen_osis.created_at', 'DESC')->findAll();
    
    // Data untuk view
    $data = [
        'title' => 'Laporan OSIS',
        'total_program' => $totalProgram,
        'proker_terlaksana' => $prokerTerlaksana,
        'total_dokumen' => $totalDokumen,
        'program_kerja' => $programKerja,
        'dokumen' => $dokumen,
        'tahun_ajaran' => $tahunAjaran,
        'status_program' => $statusProgram,
        'divisi' => $divisi
    ];
    
    return view('template/header', $data)
         . view('template/sidebar')
         . view('osis/laporan', $data)
         . view('template/footer');
    }

    public function verifikasi_program($id)
    {
        $role = session()->get('role');
        if (!in_array($role, ['admin', 'waka'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak punya akses!'
            ]);
        }
        
        $status = $this->request->getPost('status');
        $alasan = $this->request->getPost('alasan');
        $dataUpdate = ['status_verifikasi' => $status];
        
        if ($status === 'ditolak' && !empty($alasan)) {
            $dataUpdate['alasan_penolakan'] = $alasan;
        }
        
        if ($this->programModel->update($id, $dataUpdate)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Verifikasi program kerja berhasil!'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Verifikasi program kerja gagal!'
        ]);
    }

    public function verifikasi_laporan($id)
    {
        $role = session()->get('role');
        if (!in_array($role, ['admin', 'waka'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak punya akses!'
            ]);
        }
        
        $status = $this->request->getPost('status');
        $alasan = $this->request->getPost('alasan');
        $dataUpdate = ['status_verifikasi' => $status];
        
        if ($status === 'ditolak' && !empty($alasan)) {
            $dataUpdate['alasan_penolakan'] = $alasan;
        }
        
        if ($this->laporanModel->update($id, $dataUpdate)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Verifikasi laporan kegiatan berhasil!'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Verifikasi laporan kegiatan gagal!'
        ]);
    }
}
