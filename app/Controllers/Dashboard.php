<?php
namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\PrestasiModel;
use App\Models\ProgramOsisModel;
use App\Models\UserModel;
// use App\Models\DokumenModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $kegiatanModel = new KegiatanModel();
        $prestasiModel = new PrestasiModel();
        $userModel = new UserModel();
        $programOsisModel = new ProgramOsisModel();
        //$dokumenModel = new DokumenModel();
        
        $role = session()->get('role');
        $userId = session()->get('id_user');
        
        $isAdminLike = in_array($role, ['admin', 'waka_kesiswaan', 'kepala_sekolah']);
        
        $seriesKegiatan = $isAdminLike 
            ? $kegiatanModel->countByMonth(date('Y'))
            : $kegiatanModel->countByMonthForUser($userId, date('Y'));
        $seriesPrestasi = $isAdminLike
            ? $prestasiModel->countByMonth(date('Y'))
            : $prestasiModel->countByMonthForUser($userId, date('Y'));
        $recentKegiatan = $kegiatanModel->getRecent(5);
        $recentPrestasi = $prestasiModel->getRecent(5);
        $siswaAktif = $userModel->where('role', 'siswa')->where('is_active', 1)->countAllResults();
        
        $personalPrestasi = 0;
        $personalKegiatan = 0;
        if ($role === 'guru' && $userId) {
            // Kegiatan yang dibuat user
            $personalKegiatan = $kegiatanModel->where('created_by', $userId)->countAllResults();
        }
        $kegiatanPendingVerif = $kegiatanModel->countPendingVerifikasi();
        $prestasiPendingVerif = $prestasiModel->countPendingVerifikasi();
        $programOsisPendingVerif = $programOsisModel->countPendingVerifikasi();
        $pendingVerifikasi = $kegiatanPendingVerif + $prestasiPendingVerif + $programOsisPendingVerif;
        
        $data = [
            'total_kegiatan' => $isAdminLike ? $kegiatanModel->countAll() : $personalKegiatan,
            'total_prestasi' => $isAdminLike ? $prestasiModel->countAll() : $personalPrestasi,
            //'total_dokumen' => $dokumenModel->countAll(),
            'kegiatan_berjalan' => $kegiatanModel->getKegiatanBerjalan(),
            'kegiatan_belum_verifikasi' => $kegiatanModel->getPendingVerifikasi(10),
            'pending_verifikasi' => $pendingVerifikasi,
            'siswa_aktif' => $siswaAktif,
            'series_kegiatan' => $seriesKegiatan,
            'series_prestasi' => $seriesPrestasi,
            'recent_kegiatan' => $recentKegiatan,
            'recent_prestasi' => $recentPrestasi,
            'personal_prestasi' => $personalPrestasi,
            'personal_kegiatan_diikuti' => $personalKegiatan,
            'kegiatan_mendatang' => $kegiatanModel->getKegiatanMendatang(3),
            'is_admin_like' => $isAdminLike
        ];
        
        return view('template/header', $data)
             . view('template/sidebar', $data)
             . view('dashboard/index', $data)
             . view('template/footer');
    }
}
