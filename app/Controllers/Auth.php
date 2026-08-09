<?php
namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()

    {
        // Cek jika sudah login
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        
        // Tampilkan halaman login
        return view('Auth/login');
    }

    public function login()
    {
        // Ambil input dari form
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        // Cari user di database berdasarkan username
        $userModel = new UserModel();
        $user = $userModel->where('username', $username)
                          ->where('is_active', 1)
                          ->first();
        
        $is_password_valid = false;
        
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $is_password_valid = true;
            } elseif (md5($password) === $user['password']) {
                $is_password_valid = true;
                $userModel->update($user['id_user'], [
                    'password' => password_hash($password, PASSWORD_DEFAULT)
                ]);
            }
        }
        
        if ($is_password_valid) {
            // Login berhasil - Set session
            $session_data = [
                'id_user' => $user['id_user'],
                'username' => $user['username'],
                'nama_lengkap' => $user['nama_lengkap'],
                'role' => $user['role'],
                'logged_in' => true
            ];
            
            session()->set($session_data);
            
            // Debug - Cek session
            log_message('debug', 'Session: ' . print_r(session()->get(), true));
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Login berhasil!'
            ]);
        } else {
            // Login gagal
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Username atau password salah!'
            ]);
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
}