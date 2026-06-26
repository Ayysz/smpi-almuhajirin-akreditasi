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
        
        // Debug - Tampilkan input (HAPUS SETELAH BERHASIL)
        log_message('debug', 'Username: ' . $username);
        log_message('debug', 'Password: ' . $password);
        log_message('debug', 'Password MD5: ' . md5($password));
        
        // Hash password dengan MD5
        $password_hash = md5($password);
        
        // Cari user di database
        $userModel = new UserModel();
        $user = $userModel->where('username', $username)
                          ->where('password', $password_hash)
                          ->where('is_active', 1)
                          ->first();
        
        // Debug - Cek hasil query (HAPUS SETELAH BERHASIL)
        log_message('debug', 'User found: ' . print_r($user, true));
        
        if ($user) {
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
    
    // FUNGSI TEST - untuk debugging
    public function test()
{
    // Cek .env terbaca
    echo "<h3>Cek Environment:</h3>";
    echo "CI_ENVIRONMENT: " . ENVIRONMENT . "<br>";
    echo "Database: " . getenv('database.default.database') . "<br><br>";
    
    echo "<h3>Test Koneksi Database:</h3>";
    
    try {
        $db = \Config\Database::connect();
        
        // Test query sederhana
        $query = $db->query("SELECT 1 as test");
        $result = $query->getRow();
        
        if ($result && $result->test == 1) {
            echo "✅ Database connected successfully<br>";
        } else {
            echo "❌ Database connection failed<br>";
            die();
        }
        
    } catch (\Exception $e) {
        echo "❌ Connection Error: " . $e->getMessage() . "<br>";
        die();
    }
    
    // Test 2: Cek tabel users
    try {
        if ($db->tableExists('users')) {
            echo "✅ Table 'users' exists<br>";
        } else {
            echo "❌ Table 'users' not found<br>";
            die();
        }
    } catch (\Exception $e) {
        echo "❌ Error checking table: " . $e->getMessage() . "<br>";
        die();
    }
    
    // Test 3: Cek data user admin
    try {
        $query = $db->query("SELECT * FROM users WHERE username = 'admin'");
        $user = $query->getRow();
        
        if ($user) {
            echo "✅ User 'admin' found<br>";
            echo "<pre>";
            print_r($user);
            echo "</pre>";
        } else {
            echo "❌ User 'admin' not found<br>";
            echo "<strong>Silakan insert user admin manual!</strong><br>";
        }
    } catch (\Exception $e) {
        echo "❌ Error fetching user: " . $e->getMessage() . "<br>";
    }
    
    // Test 4: Test password hash
    echo "<h3>Test Password Hash:</h3>";
    echo "Password asli: admin123<br>";
    echo "MD5 Hash: " . md5('admin123') . "<br>";
    
    if (isset($user) && $user && $user->password == md5('admin123')) {
        echo "✅ Password hash match!<br>";
    } else {
        echo "❌ Password hash tidak match<br>";
        echo "Password di DB: " . (isset($user) && $user ? $user->password : 'User tidak ada') . "<br>";
    }
    
    // Test 5: Test session
    echo "<h3>Test Session:</h3>";
    session()->set('test', 'Session working!');
    echo session()->get('test') ? "✅ Session working" : "❌ Session not working";
}
}