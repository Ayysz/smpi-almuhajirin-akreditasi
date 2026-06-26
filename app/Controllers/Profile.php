<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data['user'] = $this->userModel->find(session()->get('id_user'));
        
        return view('template/header', $data)
             . view('template/sidebar')
             . view('profile/index', $data)
             . view('template/footer');
    }

    public function update()
    {
        $id = session()->get('id_user');
        
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'nip_nis' => $this->request->getPost('nip_nis')
        ];

        // Update password jika diisi
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = md5($password);
        }

        // Upload foto jika ada
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/profile', $newName);
            $data['foto'] = 'uploads/profile/' . $newName;
        }

        if ($this->userModel->update($id, $data)) {
            // Update session nama_lengkap
            session()->set('nama_lengkap', $data['nama_lengkap']);
            
            return redirect()->to('/profile')->with('success', 'Profile berhasil diupdate!');
        } else {
            return redirect()->back()->with('error', 'Gagal update profile!');
        }
    }
}
