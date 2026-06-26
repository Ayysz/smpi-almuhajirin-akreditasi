<?php
// File: public/test_db.php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_akreditasi';
$port = 3306;

echo "<h3>Test Koneksi MySQL Manual</h3>";

// Test dengan MySQLi
$conn = @new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    echo "❌ Koneksi gagal: " . $conn->connect_error . "<br>";
    echo "Error code: " . $conn->connect_errno . "<br>";
} else {
    echo "✅ Koneksi berhasil!<br>";
    echo "MySQL Version: " . $conn->server_info . "<br>";
    
    // Cek tabel users
    $result = $conn->query("SHOW TABLES LIKE 'users'");
    if ($result->num_rows > 0) {
        echo "✅ Tabel 'users' ditemukan<br>";
    } else {
        echo "❌ Tabel 'users' tidak ditemukan<br>";
    }
    
    $conn->close();
}
?>