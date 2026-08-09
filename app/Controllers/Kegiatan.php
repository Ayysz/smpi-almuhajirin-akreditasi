<?php

namespace App\Controllers;

use App\Models\KegiatanModel;

use App\Models\UserModel;
use Config\Database;

class Kegiatan extends BaseController
{
    protected $kegiatanModel;
    protected $userModel;

    public function __construct()
    {
        $this->kegiatanModel = new KegiatanModel();
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    private function storeUpload(string $field, int $id_kegiatan, ?string $existing = null): ?string
    {
        $file = $this->request->getFile($field);
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $path = 'uploads/kegiatan/' . $id_kegiatan;
            $newName = time() . '_' . $file->getRandomName();
            $file->move(FCPATH . $path, $newName);
            
            // Delete old file if exists and different
            if ($existing && file_exists(FCPATH . $existing)) {
                unlink(FCPATH . $existing);
            }
            
            return $path . '/' . $newName;
        }
        return $existing;
    }

    public function index()
    {
        $role = session()->get('role');
        $user_id = session()->get('id_user');
        
        if (!in_array($role, ['admin', 'waka_kesiswaan', 'guru'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }
        
        $data['kegiatan'] = $this->kegiatanModel->orderBy('created_at', 'DESC')->findAll();
        
        $data['title'] = 'Daftar Kegiatan';
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('kegiatan/index', $data)
             . view('template/footer');
    }

    public function tambah()
    {
        $role = session()->get('role');
        if (!in_array($role, ['waka_kesiswaan', 'guru'])) {
            return redirect()->to('/kegiatan')->with('error', 'Akses ditolak!');
        }
        
        $data = [
            'title' => 'Tambah Kegiatan',
            'users' => $this->userModel->findAll()
        ];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('kegiatan/tambah', $data)
             . view('template/footer');
    }

    public function simpan()
    {
        $role = session()->get('role');
        if (!in_array($role, ['waka_kesiswaan', 'guru'])) {
            return redirect()->to('/kegiatan')->with('error', 'Akses ditolak!');
        }
        
        $jenis = strtoupper($this->request->getPost('jenis_kegiatan'));
        
        $rules = [
            'nama_kegiatan' => 'required',
            'jenis_kegiatan' => 'required',
            'tanggal_mulai' => 'required|valid_date',
            'tempat' => 'required',
            'tahun_ajaran' => 'required',
        ];

        $fileRules = [
            'file_absensi' => 'max_size[file_absensi,5120]|ext_in[file_absensi,pdf,jpg,jpeg,png]',
            'foto_kegiatan' => 'max_size[foto_kegiatan,5120]|ext_in[foto_kegiatan,pdf,jpg,jpeg,png]',
            'rundown_kegiatan' => 'max_size[rundown_kegiatan,5120]|ext_in[rundown_kegiatan,pdf,jpg,jpeg,png]',
            'surat_keterangan' => 'max_size[surat_keterangan,5120]|ext_in[surat_keterangan,pdf,jpg,jpeg,png]',
            'proposal_laporan' => 'max_size[proposal_laporan,5120]|ext_in[proposal_laporan,pdf,jpg,jpeg,png]',
        ];

        if ($jenis === 'KARAKTER') {
            $fileRules['file_absensi'] = 'uploaded[file_absensi]|max_size[file_absensi,5120]|ext_in[file_absensi,pdf,jpg,jpeg,png]';
            $fileRules['foto_kegiatan'] = 'uploaded[foto_kegiatan]|max_size[foto_kegiatan,5120]|ext_in[foto_kegiatan,pdf,jpg,jpeg,png]';
            $fileRules['rundown_kegiatan'] = 'uploaded[rundown_kegiatan]|max_size[rundown_kegiatan,5120]|ext_in[rundown_kegiatan,pdf,jpg,jpeg,png]';
        } elseif ($jenis === 'KEAGAMAAN') {
            $fileRules['file_absensi'] = 'uploaded[file_absensi]|max_size[file_absensi,5120]|ext_in[file_absensi,pdf,jpg,jpeg,png]';
            $fileRules['foto_kegiatan'] = 'uploaded[foto_kegiatan]|max_size[foto_kegiatan,5120]|ext_in[foto_kegiatan,pdf,jpg,jpeg,png]';
            $fileRules['surat_keterangan'] = 'uploaded[surat_keterangan]|max_size[surat_keterangan,5120]|ext_in[surat_keterangan,pdf,jpg,jpeg,png]';
            $fileRules['rundown_kegiatan'] = 'uploaded[rundown_kegiatan]|max_size[rundown_kegiatan,5120]|ext_in[rundown_kegiatan,pdf,jpg,jpeg,png]';
        } elseif ($jenis === 'EKSTRAKURIKULER') {
            $fileRules['file_absensi'] = 'uploaded[file_absensi]|max_size[file_absensi,5120]|ext_in[file_absensi,pdf,jpg,jpeg,png]';
            $fileRules['foto_kegiatan'] = 'uploaded[foto_kegiatan]|max_size[foto_kegiatan,5120]|ext_in[foto_kegiatan,pdf,jpg,jpeg,png]';
        }
        
        $rules = array_merge($rules, $fileRules);
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error_list', $this->validator->getErrors());
        }

        $data = [
            'nama_kegiatan'    => $this->request->getPost('nama_kegiatan'),
            'jenis_kegiatan'   => $jenis,
            'tanggal_mulai'    => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai'  => $this->request->getPost('tanggal_selesai') ?: null,
            'tempat'           => $this->request->getPost('tempat'),
            'tahun_ajaran'     => $this->request->getPost('tahun_ajaran'),
            'created_by'       => session()->get('id_user'),
            'status_verifikasi'=> 'menunggu'
        ];

        $id = $this->kegiatanModel->insert($data);

        if ($id) {
            $updateData = [];
            $updateData['file_absensi'] = $this->storeUpload('file_absensi', $id);
            $updateData['foto_kegiatan'] = $this->storeUpload('foto_kegiatan', $id);
            $updateData['rundown_kegiatan'] = $this->storeUpload('rundown_kegiatan', $id);
            $updateData['surat_keterangan'] = $this->storeUpload('surat_keterangan', $id);
            $updateData['proposal_laporan'] = $this->storeUpload('proposal_laporan', $id);

            $this->kegiatanModel->update($id, $updateData);

            return redirect()->to('/kegiatan')->with('success', 'Kegiatan berhasil ditambahkan.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan kegiatan.');
    }

    public function edit($id)
    {
        $kegiatan = $this->kegiatanModel->find($id);
        if (!$kegiatan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $role = session()->get('role');
        $user_id = session()->get('id_user');
        
        // Cek kepemilikan atau admin
        if ($kegiatan['created_by'] != $user_id) {
            return redirect()->to('/kegiatan')->with('error', 'Akses ditolak!');
        }

        $data = [
            'title' => 'Edit Kegiatan',
            'kegiatan' => $kegiatan,
            'users' => $this->userModel->findAll()
        ];

        return view('template/header', $data)
             . view('template/sidebar')
             . view('kegiatan/edit', $data)
             . view('template/footer');
    }

    public function update($id)
    {
        $kegiatan = $this->kegiatanModel->find($id);
        if (!$kegiatan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $role = session()->get('role');
        $user_id = session()->get('id_user');
        
        if ($kegiatan['created_by'] != $user_id) {
            return redirect()->to('/kegiatan')->with('error', 'Akses ditolak!');
        }

        $jenis = strtoupper($this->request->getPost('jenis_kegiatan'));
        
        $rules = [
            'nama_kegiatan' => 'required',
            'jenis_kegiatan' => 'required',
            'tanggal_mulai' => 'required|valid_date',
            'tempat' => 'required',
            'tahun_ajaran' => 'required',
        ];

        $fileRules = [
            'file_absensi' => 'max_size[file_absensi,5120]|ext_in[file_absensi,pdf,jpg,jpeg,png]',
            'foto_kegiatan' => 'max_size[foto_kegiatan,5120]|ext_in[foto_kegiatan,pdf,jpg,jpeg,png]',
            'rundown_kegiatan' => 'max_size[rundown_kegiatan,5120]|ext_in[rundown_kegiatan,pdf,jpg,jpeg,png]',
            'surat_keterangan' => 'max_size[surat_keterangan,5120]|ext_in[surat_keterangan,pdf,jpg,jpeg,png]',
            'proposal_laporan' => 'max_size[proposal_laporan,5120]|ext_in[proposal_laporan,pdf,jpg,jpeg,png]',
        ];

        // Only require upload if currently empty in DB and is a required field for that type
        if ($jenis === 'KARAKTER') {
            if (empty($kegiatan['file_absensi'])) $fileRules['file_absensi'] = 'uploaded[file_absensi]|' . $fileRules['file_absensi'];
            if (empty($kegiatan['foto_kegiatan'])) $fileRules['foto_kegiatan'] = 'uploaded[foto_kegiatan]|' . $fileRules['foto_kegiatan'];
            if (empty($kegiatan['rundown_kegiatan'])) $fileRules['rundown_kegiatan'] = 'uploaded[rundown_kegiatan]|' . $fileRules['rundown_kegiatan'];
        } elseif ($jenis === 'KEAGAMAAN') {
            if (empty($kegiatan['file_absensi'])) $fileRules['file_absensi'] = 'uploaded[file_absensi]|' . $fileRules['file_absensi'];
            if (empty($kegiatan['foto_kegiatan'])) $fileRules['foto_kegiatan'] = 'uploaded[foto_kegiatan]|' . $fileRules['foto_kegiatan'];
            if (empty($kegiatan['surat_keterangan'])) $fileRules['surat_keterangan'] = 'uploaded[surat_keterangan]|' . $fileRules['surat_keterangan'];
            if (empty($kegiatan['rundown_kegiatan'])) $fileRules['rundown_kegiatan'] = 'uploaded[rundown_kegiatan]|' . $fileRules['rundown_kegiatan'];
        } elseif ($jenis === 'EKSTRAKURIKULER') {
            if (empty($kegiatan['file_absensi'])) $fileRules['file_absensi'] = 'uploaded[file_absensi]|' . $fileRules['file_absensi'];
            if (empty($kegiatan['foto_kegiatan'])) $fileRules['foto_kegiatan'] = 'uploaded[foto_kegiatan]|' . $fileRules['foto_kegiatan'];
        }
        
        $rules = array_merge($rules, $fileRules);

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error_list', $this->validator->getErrors());
        }

        $data = [
            'nama_kegiatan'    => $this->request->getPost('nama_kegiatan'),
            'jenis_kegiatan'   => $jenis,
            'tanggal_mulai'    => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai'  => $this->request->getPost('tanggal_selesai') ?: null,
            'tempat'           => $this->request->getPost('tempat'),
            'tahun_ajaran'     => $this->request->getPost('tahun_ajaran'),
        ];

        $data['file_absensi'] = $this->storeUpload('file_absensi', $id, $kegiatan['file_absensi']);
        $data['foto_kegiatan'] = $this->storeUpload('foto_kegiatan', $id, $kegiatan['foto_kegiatan']);
        $data['rundown_kegiatan'] = $this->storeUpload('rundown_kegiatan', $id, $kegiatan['rundown_kegiatan']);
        $data['surat_keterangan'] = $this->storeUpload('surat_keterangan', $id, $kegiatan['surat_keterangan']);
        $data['proposal_laporan'] = $this->storeUpload('proposal_laporan', $id, $kegiatan['proposal_laporan']);

        $this->kegiatanModel->update($id, $data);

        return redirect()->to('/kegiatan')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $kegiatan = $this->kegiatanModel->find($id);
        if (!$kegiatan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $role = session()->get('role');
        $user_id = session()->get('id_user');
        
        if ($role !== 'waka_kesiswaan') {
            return redirect()->to('/kegiatan')->with('error', 'Akses ditolak!');
        }

        // Delete folder
        $path = FCPATH . 'uploads/kegiatan/' . $id;
        if (is_dir($path)) {
            $files = glob($path . '/*');
            foreach ($files as $file) {
                if (is_file($file)) unlink($file);
            }
            rmdir($path);
        }

        $this->kegiatanModel->delete($id);
        return redirect()->to('/kegiatan')->with('success', 'Kegiatan berhasil dihapus.');
    }

    public function detail($id)
    {
        $kegiatan = $this->kegiatanModel
            ->select('kegiatan.*, creator.nama_lengkap as nama_pembuat')
            ->join('users as creator', 'creator.id_user = kegiatan.created_by', 'left')
            ->find($id);

        if (!$kegiatan) {
            return '<div class="alert alert-danger">Kegiatan tidak ditemukan</div>';
        }

        $data = [
            'kegiatan' => $kegiatan
        ];

        return view('kegiatan/detail', $data);
    }

    public function verifikasi($id)
    {
        $role = session()->get('role');
        if (!in_array($role, ['waka_kesiswaan'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak punya akses untuk verifikasi!'
            ]);
        }
        
        $status = $this->request->getPost('status');
        $alasan = $this->request->getPost('alasan');
        
        $dataUpdate = ['status_verifikasi' => $status];
        if ($status === 'ditolak' && !empty($alasan)) {
            $dataUpdate['alasan_penolakan'] = $alasan;
        }
        
        if ($this->kegiatanModel->update($id, $dataUpdate)) {
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
}
