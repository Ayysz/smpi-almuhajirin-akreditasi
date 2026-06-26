<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Public Routes (Tanpa Login)
// $routes->get('/', 'Auth::index'); 
$routes->get('/', 'Home::index'); //landing
$routes->get('auth', 'Auth::index');
$routes->get('auth/index', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('download/(:any)/(:any)', 'Download::file/$1/$2');
$routes->get('view/(:any)/(:any)', 'Download::view/$1/$2');
$routes->get('uploads/(.*)', 'Download::serve/$1');
$routes->get('auth/test', 'Auth::test'); // Untuk debugging



// Protected Routes (Butuh Login)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    
    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');
    
    // Profile & Settings
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/update', 'Profile::update');
    
    // Kegiatan Kesiswaan
    $routes->get('kegiatan', 'Kegiatan::index');
    $routes->get('kegiatan/tambah', 'Kegiatan::tambah');
    $routes->post('kegiatan/simpan', 'Kegiatan::simpan');
    $routes->get('kegiatan/detail/(:num)', 'Kegiatan::detail/$1');
    $routes->get('kegiatan/edit/(:num)', 'Kegiatan::edit/$1');
    $routes->post('kegiatan/update/(:num)', 'Kegiatan::update/$1');
    $routes->get('kegiatan/hapus/(:num)', 'Kegiatan::hapus/$1');
    $routes->post('kegiatan/upload_dokumen/(:num)', 'Kegiatan::upload_dokumen/$1');
    $routes->post('kegiatan/verifikasi/(:num)', 'Kegiatan::verifikasi/$1');
    // Routes untuk view file kegiatan
$routes->get('view/kegiatan/(:any)', 'View::kegiatan/$1');
    
    // Prestasi Siswa
    $routes->get('prestasi', 'Prestasi::index');
    $routes->get('prestasi/tambah', 'Prestasi::tambah');
    $routes->post('prestasi/simpan', 'Prestasi::simpan');
    $routes->get('prestasi/edit/(:num)', 'Prestasi::edit/$1');
    $routes->post('prestasi/update', 'Prestasi::update');
    $routes->get('prestasi/hapus/(:num)', 'Prestasi::hapus/$1');
    $routes->post('prestasi/verifikasi/(:num)', 'Prestasi::verifikasi/$1');
    $routes->get('prestasi/detail/(:num)', 'Prestasi::detail/$1');
    
    // Dokumen Akreditasi
    // $routes->get('dokumen', 'Dokumen::index');
    // $routes->get('dokumen/tambah', 'Dokumen::tambah');
    // $routes->post('dokumen/simpan', 'Dokumen::simpan');
    // $routes->get('dokumen/edit/(:num)', 'Dokumen::edit/$1');
    // $routes->post('dokumen/update', 'Dokumen::update');
    // $routes->get('dokumen/hapus/(:num)', 'Dokumen::hapus/$1');
    // $routes->post('dokumen/verifikasi/(:num)', 'Dokumen::verifikasi/$1');
    // $routes->get('dokumen/download/(:num)', 'Dokumen::download/$1');
    
    // OSIS
    $routes->get('osis/program-kerja', 'Osis::programKerja'); // Halaman khusus program kerja
    $routes->get('osis/laporan-kegiatan', 'Osis::laporanKegiatan');
    $routes->get('osis/tambah-laporan-kegiatan', 'Osis::tambahLaporanKegiatan');
    $routes->post('osis/simpan_laporan_kegiatan', 'Osis::simpanLaporanKegiatan');
    $routes->get('osis/detail_laporan/(:num)', 'Osis::detail_laporan/$1');
    $routes->get('osis/edit_laporan/(:num)', 'Osis::edit_laporan/$1');
    $routes->post('osis/update_laporan', 'Osis::update_laporan');
    $routes->get('osis/hapus_laporan/(:num)', 'Osis::hapus_laporan/$1');
    $routes->get('osis/dokumen', 'Osis::dokumen'); // Halaman khusus dokumen
    // LAPORAN OSIS (BARU)
$routes->get('osis/laporan', 'Osis::laporan');

    // Edit Program & Dokumen
$routes->get('osis/edit_program/(:num)', 'Osis::edit_program/$1');
$routes->post('osis/update_program', 'Osis::update_program');
$routes->get('osis/edit_dokumen/(:num)', 'Osis::edit_dokumen/$1');
$routes->post('osis/update_dokumen', 'Osis::update_dokumen');
// Detail Program & Dokumen
$routes->get('osis/detail_program/(:num)', 'Osis::detail_program/$1');
$routes->get('osis/detail_dokumen/(:num)', 'Osis::detail_dokumen/$1');
// Route untuk melihat file
$routes->get('file/view/(:segment)/(:segment)/(:segment)', 'File::view/$1/$2/$3');
$routes->get('file/download/(:segment)/(:segment)/(:segment)', 'File::download/$1/$2/$3');

// Program Kerja osis
$routes->get('osis/tambah_program', 'Osis::tambah_program');
$routes->post('osis/simpan_program', 'Osis::simpan_program');
$routes->get('osis/hapus_program/(:num)', 'Osis::hapus_program/$1');
$routes->post('osis/verifikasi_program/(:num)', 'Osis::verifikasi_program/$1');
$routes->post('osis/verifikasi_laporan/(:num)', 'Osis::verifikasi_laporan/$1');

// Dokumen osis
$routes->get('osis/tambah_dokumen', 'Osis::tambah_dokumen');
$routes->post('osis/simpan_dokumen', 'Osis::simpan_dokumen');
$routes->get('osis/hapus_dokumen/(:num)', 'Osis::hapus_dokumen/$1');
    
    // Laporan
    $routes->get('laporan', 'Laporan::index');
    $routes->get('laporan/kegiatan', 'Laporan::kegiatan');
    $routes->get('laporan/prestasi', 'Laporan::prestasi');
    $routes->get('laporan/osis', 'Laporan::osis');
    $routes->get('laporan/komprehensif', 'Laporan::komprehensif');
    $routes->get('laporan/komprehensif_cetak', 'Laporan::komprehensif_cetak');
    $routes->get('laporan/detail_osis/(:num)', 'Laporan::detail_osis/$1');
    $routes->get('laporan/detail_dokumen/(:num)', 'Laporan::detail_dokumen/$1');
    $routes->get('laporan/detail_laporan/(:num)', 'Laporan::detail_laporan/$1');
    $routes->get('laporan/dokumen', 'Laporan::dokumen');
    // User Management (Admin Only)
    $routes->get('user', 'User::index');
    $routes->get('user/tambah', 'User::tambah');
    $routes->post('user/simpan', 'User::simpan');
    $routes->get('user/edit/(:num)', 'User::edit/$1');
    $routes->post('user/update', 'User::update');
    $routes->get('user/hapus/(:num)', 'User::hapus/$1');
    $routes->post('user/reset_password/(:num)', 'User::reset_password/$1');

    $routes->get('laporan/export_kegiatan', 'Laporan::export_kegiatan'); // BARU
    $routes->get('laporan/export_prestasi', 'Laporan::export_prestasi'); // BARU
    $routes->get('laporan/export_osis_proker', 'Laporan::export_osis_proker');
    $routes->get('laporan/export_osis_laporan', 'Laporan::export_osis_laporan');
    $routes->get('laporan/export_osis_dokumen', 'Laporan::export_osis_dokumen');
    $routes->get('laporan/export_dokumen', 'Laporan::export_dokumen'); // BARU
    
    
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}