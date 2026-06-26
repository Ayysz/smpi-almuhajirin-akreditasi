<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Cek role - hanya admin yang bisa akses
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak! Hanya admin yang bisa mengakses halaman ini.');
        }

        $data['users'] = $this->userModel->orderBy('created_at', 'DESC')->findAll();
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('user/index', $data)
             . view('template/footer');
    }

    public function tambah()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $data = [];
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('user/tambah')
             . view('template/footer');
    }

    public function simpan()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'username' => 'required|min_length[4]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'nama_lengkap' => 'required',
            'role' => 'required|in_list[admin,waka_kesiswaan,guru,kepala_sekolah]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => md5($this->request->getPost('password')),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'role' => $this->request->getPost('role'),
            'nip_nis' => $this->request->getPost('nip_nis'),
            'email' => $this->request->getPost('email'),
            'is_active' => 1
        ];

        if ($this->userModel->insert($data)) {
            return redirect()->to('/user')->with('success', 'User berhasil ditambahkan!');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan user!');
        }
    }

    public function edit($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $data['user'] = $this->userModel->find($id);

        if (!$data['user']) {
            return redirect()->to('/user')->with('error', 'User tidak ditemukan!');
        }
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('user/edit', $data)
             . view('template/footer');
    }

    public function update()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $id = $this->request->getPost('id_user');
        
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'role' => $this->request->getPost('role'),
            'nip_nis' => $this->request->getPost('nip_nis'),
            'email' => $this->request->getPost('email'),
            'is_active' => $this->request->getPost('is_active')
        ];

        // Update password jika diisi
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = md5($password);
        }

        if ($this->userModel->update($id, $data)) {
            return redirect()->to('/user')->with('success', 'User berhasil diupdate!');
        } else {
            return redirect()->back()->with('error', 'Gagal update user!');
        }
    }

    public function hapus($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $user = $this->userModel->find($id);

        // Jangan hapus user admin default
        if ($user && $user['username'] == 'admin') {
            return redirect()->to('/user')->with('error', 'User admin default tidak bisa dihapus!');
        }

        // Jangan hapus user sendiri
        if ($user && $user['id_user'] == session()->get('id_user')) {
            return redirect()->to('/user')->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('/user')->with('success', 'User berhasil dihapus!');
        } else {
            return redirect()->to('/user')->with('error', 'Gagal hapus user!');
        }
    }

    public function reset_password($id)
    {
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Akses ditolak!'
            ]);
        }

        $new_password = 'password123';
        
        $data = ['password' => md5($new_password)];

        if ($this->userModel->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Password berhasil direset menjadi: password123'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Reset password gagal!'
            ]);
        }
    }
}
