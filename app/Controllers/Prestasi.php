<?php

namespace App\Controllers;

use App\Models\PrestasiModel;

class Prestasi extends BaseController
{
    protected $prestasiModel;

    public function __construct()
    {
        $this->prestasiModel = new PrestasiModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $role = session()->get('role');
        
        if (!in_array($role, ['admin', 'waka_kesiswaan', 'guru'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        // Admin, Waka, Guru lihat semua
        $data['prestasi'] = $this->prestasiModel->getAllPrestasi();
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('prestasi/index', $data)
             . view('template/footer');
    }

    public function tambah()
    {
        $role = session()->get('role');
        if (!in_array($role, ['waka_kesiswaan', 'guru'])) {
            return redirect()->to('/prestasi')->with('error', 'Akses ditolak!');
        }

        $data = [];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('prestasi/tambah', $data)
             . view('template/footer', $data);
    }

    public function simpan()
    {
        $role = session()->get('role');
        if (!in_array($role, ['waka_kesiswaan', 'guru'])) {
            return redirect()->to('/prestasi')->with('error', 'Akses ditolak!');
        }

        $rules = [
            'nama_siswa' => 'required',
            'nama_prestasi' => 'required',
            'tingkat' => 'required',
            'peringkat' => 'required',
            'tahun_perolehan' => 'required|integer',
            'penyelenggara' => 'required',
            'tanggal_pelaksanaan' => 'required|valid_date',
            'lokasi_lomba' => 'required',
            'file_sertifikat' => 'uploaded[file_sertifikat]|max_size[file_sertifikat,5120]|ext_in[file_sertifikat,pdf]',
            'surat_tugas.*' => 'max_size[surat_tugas,5120]|ext_in[surat_tugas,pdf,jpg,jpeg,png]',
            'dokumen_pendukung.*' => 'max_size[dokumen_pendukung,5120]|ext_in[dokumen_pendukung,pdf,jpg,jpeg,png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle upload sertifikat
        $fileSertifikat = $this->request->getFile('file_sertifikat');
        $newNameSertifikat = $fileSertifikat->getRandomName();
        $fileSertifikat->move(FCPATH . 'uploads/prestasi', $newNameSertifikat);
        $file_sertifikat = 'uploads/prestasi/' . $newNameSertifikat;

        // Handle upload surat tugas
        $surat_tugas = [];
        $filesTugas = $this->request->getFileMultiple('surat_tugas');
        if ($filesTugas) {
            foreach ($filesTugas as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads/prestasi', $newName);
                    $surat_tugas[] = 'uploads/prestasi/' . $newName;
                }
            }
        }

        // Handle upload dokumen pendukung
        $dokumen_pendukung = [];
        $filesPendukung = $this->request->getFileMultiple('dokumen_pendukung');
        if ($filesPendukung) {
            foreach ($filesPendukung as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads/prestasi', $newName);
                    $dokumen_pendukung[] = 'uploads/prestasi/' . $newName;
                }
            }
        }

        $data = [
            'nama_siswa' => trim((string) $this->request->getPost('nama_siswa')),
            'nama_prestasi' => $this->request->getPost('nama_prestasi'),
            'tingkat' => $this->request->getPost('tingkat'),
            'peringkat' => $this->request->getPost('peringkat'),
            'tahun_perolehan' => $this->request->getPost('tahun_perolehan'),
            'penyelenggara' => $this->request->getPost('penyelenggara'),
            'tanggal_pelaksanaan' => $this->request->getPost('tanggal_pelaksanaan'),
            'lokasi_lomba' => $this->request->getPost('lokasi_lomba'),
            'file_sertifikat' => $file_sertifikat,
            'surat_tugas' => !empty($surat_tugas) ? json_encode($surat_tugas) : null,
            'dokumen_pendukung' => !empty($dokumen_pendukung) ? json_encode($dokumen_pendukung) : null
        ];

        if ($this->prestasiModel->insert($data)) {
            return redirect()->to('/prestasi')->with('success', 'Prestasi berhasil ditambahkan!');
        }

        $dbError = '';
        try {
            $err = $this->prestasiModel->db->error();
            $dbError = !empty($err['message']) ? (string) $err['message'] : '';
        } catch (\Throwable $e) {
            $dbError = '';
        }
        if ($dbError !== '') {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan prestasi: ' . $dbError);
        }
        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan prestasi!');
    }

    public function edit($id)
    {
        $role = session()->get('role');
        if (!in_array($role, ['waka_kesiswaan', 'guru'])) {
            return redirect()->to('/prestasi')->with('error', 'Akses ditolak!');
        }

        $data['prestasi'] = $this->prestasiModel->find($id);
        
        if (!$data['prestasi']) {
            return redirect()->to('/prestasi')->with('error', 'Prestasi tidak ditemukan!');
        }
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('prestasi/edit', $data)
             . view('template/footer', $data);
    }

    public function update()
    {
        $role = session()->get('role');
        if (!in_array($role, ['waka_kesiswaan', 'guru'])) {
            return redirect()->to('/prestasi')->with('error', 'Akses ditolak!');
        }

        $id = $this->request->getPost('id_prestasi');
        
        $rules = [
            'id_prestasi' => 'required|is_not_unique[prestasi.id_prestasi]',
            'nama_siswa' => 'required',
            'nama_prestasi' => 'required',
            'tingkat' => 'required',
            'peringkat' => 'required',
            'tahun_perolehan' => 'required|integer',
            'penyelenggara' => 'required',
            'tanggal_pelaksanaan' => 'required|valid_date',
            'lokasi_lomba' => 'required',
            'file_sertifikat' => 'max_size[file_sertifikat,5120]|ext_in[file_sertifikat,pdf]',
            'surat_tugas.*' => 'max_size[surat_tugas,5120]|ext_in[surat_tugas,pdf,jpg,jpeg,png]',
            'dokumen_pendukung.*' => 'max_size[dokumen_pendukung,5120]|ext_in[dokumen_pendukung,pdf,jpg,jpeg,png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $current = $this->prestasiModel->find($id);
        if (!$current) {
            return redirect()->to('/prestasi')->with('error', 'Prestasi tidak ditemukan!');
        }
        
        $data = [
            'nama_siswa' => trim((string) $this->request->getPost('nama_siswa')),
            'nama_prestasi' => $this->request->getPost('nama_prestasi'),
            'tingkat' => $this->request->getPost('tingkat'),
            'peringkat' => $this->request->getPost('peringkat'),
            'tahun_perolehan' => $this->request->getPost('tahun_perolehan'),
            'penyelenggara' => $this->request->getPost('penyelenggara'),
            'tanggal_pelaksanaan' => $this->request->getPost('tanggal_pelaksanaan'),
            'lokasi_lomba' => $this->request->getPost('lokasi_lomba'),
            'status_verifikasi' => 'menunggu' // Reset status setelah update
        ];
        
        // Update sertifikat jika ada file baru
        $file = $this->request->getFile('file_sertifikat');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/prestasi', $newName);
            $data['file_sertifikat'] = 'uploads/prestasi/' . $newName;
        }
        
        // Tambah surat tugas jika ada file baru (append)
        $newTugas = [];
        $filesTugas = $this->request->getFileMultiple('surat_tugas');
        if ($filesTugas) {
            foreach ($filesTugas as $ft) {
                if ($ft && $ft->isValid() && !$ft->hasMoved()) {
                    $newName = $ft->getRandomName();
                    $ft->move(FCPATH . 'uploads/prestasi', $newName);
                    $newTugas[] = 'uploads/prestasi/' . $newName;
                }
            }
        }
        if (!empty($newTugas)) {
            $existing = [];
            if (!empty($current['surat_tugas'])) {
                $decoded = json_decode($current['surat_tugas'], true);
                if (is_array($decoded)) {
                    $existing = $decoded;
                }
            }
            $merged = array_merge($existing, $newTugas);
            $data['surat_tugas'] = json_encode($merged);
        }
        
        // Tambah dokumen pendukung jika ada file baru (append)
        $newDocs = [];
        $files = $this->request->getFileMultiple('dokumen_pendukung');
        if ($files) {
            foreach ($files as $f) {
                if ($f && $f->isValid() && !$f->hasMoved()) {
                    $newName = $f->getRandomName();
                    $f->move(FCPATH . 'uploads/prestasi', $newName);
                    $newDocs[] = 'uploads/prestasi/' . $newName;
                }
            }
        }
        if (!empty($newDocs)) {
            $existing = [];
            if (!empty($current['dokumen_pendukung'])) {
                $decoded = json_decode($current['dokumen_pendukung'], true);
                if (is_array($decoded)) {
                    $existing = $decoded;
                }
            }
            $merged = array_merge($existing, $newDocs);
            $data['dokumen_pendukung'] = json_encode($merged);
        }
        
        if ($this->prestasiModel->update($id, $data)) {
            return redirect()->to('/prestasi')->with('success', 'Prestasi berhasil diupdate!');
        }
        
        $dbError = '';
        try {
            $err = $this->prestasiModel->db->error();
            $dbError = !empty($err['message']) ? (string) $err['message'] : '';
        } catch (\Throwable $e) {
            $dbError = '';
        }
        if ($dbError !== '') {
            return redirect()->back()->withInput()->with('error', 'Gagal update prestasi: ' . $dbError);
        }
        return redirect()->back()->withInput()->with('error', 'Gagal update prestasi!');
    }

    public function hapus($id)
    {
        $role = session()->get('role');
        if (!in_array($role, ['waka_kesiswaan', 'guru'])) {
            return redirect()->to('/prestasi')->with('error', 'Akses ditolak!');
        }
        
        if ($this->prestasiModel->delete($id)) {
            return redirect()->to('/prestasi')->with('success', 'Prestasi berhasil dihapus!');
        }
        
        return redirect()->to('/prestasi')->with('error', 'Gagal hapus prestasi!');
    }

    public function verifikasi($id)
    {
        $role = session()->get('role');
        if (!in_array($role, ['waka_kesiswaan'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak punya akses!'
            ]);
        }
        
        $status = $this->request->getPost('status');
        $alasan = $this->request->getPost('alasan');
        $dataUpdate = ['status_verifikasi' => $status];
        try {
            $fields = $this->prestasiModel->db->getFieldData('prestasi');
            $hasAlasan = false;
            foreach ($fields as $f) { if ($f->name === 'alasan_penolakan') { $hasAlasan = true; break; } }
            if ($status === 'ditolak' && $hasAlasan && !empty($alasan)) {
                $dataUpdate['alasan_penolakan'] = $alasan;
            }
        } catch (\Throwable $e) { /* ignore */ }
        
        if ($this->prestasiModel->update($id, $dataUpdate)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Verifikasi berhasil!'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Verifikasi gagal!'
        ]);
    }

    // DETAIL untuk MODAL (return HTML string)
    public function detail($id)
    {
        $prestasi = $this->prestasiModel->find($id);
        
        if (!$prestasi) {
            return '<div class="alert alert-danger">Data tidak ditemukan</div>';
        }
        
        $nama_siswa = !empty($prestasi['nama_siswa']) ? $prestasi['nama_siswa'] : '-';
        
        // Badge untuk tingkat
        $badges = [
            'sekolah' => 'secondary',
            'kecamatan' => 'info',
            'kabupaten' => 'primary',
            'provinsi' => 'warning',
            'nasional' => 'success',
            'internasional' => 'danger'
        ];
        $badge = $badges[$prestasi['tingkat']] ?? 'secondary';
        
        // Render HTML
        $html = '
        <table class="table table-bordered">
            <tr>
                <th width="200">Nama Siswa</th>
                <td><strong>' . esc($nama_siswa) . '</strong></td>
            </tr>
            <tr>
                <th>Nama Prestasi</th>
                <td><strong>' . esc($prestasi['nama_prestasi']) . '</strong></td>
            </tr>
            <tr>
                <th>Tingkat</th>
                <td><span class="badge bg-' . $badge . '">' . ucfirst($prestasi['tingkat']) . '</span></td>
            </tr>
            <tr>
                <th>Peringkat</th>
                <td><span class="badge bg-warning text-dark">' . esc($prestasi['peringkat']) . '</span></td>
            </tr>
            <tr>
                <th>Tahun Perolehan</th>
                <td>' . esc($prestasi['tahun_perolehan']) . '</td>
            </tr>
            <tr>
                <th>Penyelenggara</th>
                <td>' . esc($prestasi['penyelenggara']) . '</td>
            </tr>
            <tr><td colspan="2" class="bg-light text-center"><strong>Detail Lomba</strong></td></tr>
            <tr><th>Tanggal Pelaksanaan</th><td>' . (!empty($prestasi['tanggal_pelaksanaan']) ? date('d F Y', strtotime($prestasi['tanggal_pelaksanaan'])) : '-') . '</td></tr>
            <tr><th>Lokasi Lomba</th><td>' . esc($prestasi['lokasi_lomba'] ?? '-') . '</td></tr>
            <tr><td colspan="2" class="bg-light text-center"><strong>Dokumentasi</strong></td></tr>';
        
        // Sertifikat
        $html .= $this->renderFileRow('Sertifikat', $prestasi['file_sertifikat'] ?? '', 'prestasi');

        // Surat Undangan / Tugas (Multiple)
        $html .= '<tr><th>Surat Undangan / Tugas</th><td>';
        if (!empty($prestasi['surat_tugas'])) {
            $tugas = json_decode($prestasi['surat_tugas'], true);
            if ($tugas && count($tugas) > 0) {
                foreach ($tugas as $idx => $tg) {
                    $html .= $this->renderFileRowInner('Surat ' . ($idx + 1), $tg, 'prestasi');
                }
            } else {
                $html .= '<em class="text-muted">Tidak ada surat undangan/tugas</em>';
            }
        } else {
            $html .= '<em class="text-muted">Tidak ada surat undangan/tugas</em>';
        }
        $html .= '</td></tr>';

        // Dokumentasi Kegiatan (Multiple)
        $html .= '<tr><th>Dokumentasi Kegiatan</th><td>';
        if (!empty($prestasi['dokumen_pendukung'])) {
            $docs = json_decode($prestasi['dokumen_pendukung'], true);
            if ($docs && count($docs) > 0) {
                foreach ($docs as $idx => $doc) {
                    $html .= $this->renderFileRowInner('Dokumen ' . ($idx + 1), $doc, 'prestasi');
                }
            } else {
                $html .= '<em class="text-muted">Tidak ada dokumen pendukung</em>';
            }
        } else {
            $html .= '<em class="text-muted">Tidak ada dokumen pendukung</em>';
        }
        $html .= '</td></tr>';
        
        $html .= '
            <tr>
                <th>Status Verifikasi</th>
                <td>';
        
        if ($prestasi['status_verifikasi'] == 'disetujui') {
            $html .= '<span class="badge bg-success">Disetujui</span>';
        } elseif ($prestasi['status_verifikasi'] == 'ditolak') {
            $html .= '<span class="badge bg-danger">Ditolak</span>';
        } else {
            $html .= '<span class="badge bg-warning">Menunggu Verifikasi</span>';
        }
        
        $html .= '</td>
            </tr>';
        
        // Alasan Penolakan (jika ada)
        if (($prestasi['status_verifikasi'] ?? '') === 'ditolak') {
            $alasan = isset($prestasi['alasan_penolakan']) ? trim((string)$prestasi['alasan_penolakan']) : '';
            if ($alasan !== '') {
                $html .= '
            <tr>
                <th>Alasan Penolakan</th>
                <td>' . nl2br(esc($alasan)) . '</td>
            </tr>';
            }
        }
        
        $html .= '
            <tr>
                <th>Tanggal Input</th>
                <td>' . date('d F Y H:i:s', strtotime($prestasi['created_at'])) . ' WIB</td>
            </tr>
        </table>';
        
        return $html;
    }

    private function renderFileRow($label, $filePath, $folder)
    {
        if (empty($filePath)) {
            return '<tr><th>' . $label . '</th><td><em class="text-muted">Tidak ada file</em></td></tr>';
        }
        return '<tr><th>' . $label . '</th><td>' . $this->renderFileRowInner($label, $filePath, $folder) . '</td></tr>';
    }

    private function renderFileRowInner($label, $filePath, $folder)
    {
        if (empty($filePath)) return '';

        $filename = basename($filePath);
        $url = base_url('view/' . $folder . '/' . $filename);
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        $icon = 'bi-file-earmark';
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) $icon = 'bi-image';
        elseif ($ext === 'pdf') $icon = 'bi-file-earmark-pdf';
        elseif (in_array($ext, ['xls', 'xlsx'])) $icon = 'bi-file-earmark-excel';

        $html = '<div class="card mb-2 border-0 shadow-sm bg-light">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <a href="' . $url . '" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi ' . $icon . '"></i> ' . $label . '
                            </a>
                            <a href="' . base_url('download/' . $folder . '/' . $filename) . '" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-download"></i> Download
                            </a>
                        </div>';

        // Preview jika Gambar
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $html .= '<div class="mt-2">
                        <img src="' . $url . '" alt="' . $label . '" class="img-thumbnail" style="max-height: 200px; cursor: pointer;" onclick="window.open(\'' . $url . '\', \'_blank\')">
                      </div>';
        } 
        // Preview jika PDF
        elseif ($ext === 'pdf') {
            $html .= '<div class="mt-2">
                        <iframe src="' . $url . '" width="100%" height="300px" style="border: none; border-radius: 4px;"></iframe>
                      </div>';
        }

        $html .= '</div></div>';
        return $html;
    }
}
