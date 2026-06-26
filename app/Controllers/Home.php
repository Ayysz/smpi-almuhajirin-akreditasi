<?php
namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\PrestasiModel;
use App\Models\ProgramOsisModel;
use App\Models\DokumenOsisModel;
use Config\Database;

class Home extends BaseController
{
    public function index()
    {
        $kegiatanModel = new KegiatanModel();
        $prestasiModel = new PrestasiModel();
        $programModel  = new ProgramOsisModel();
        $dokumenModel  = new DokumenOsisModel();

        $kegiatanCount = $kegiatanModel->countAll();
        $prestasiCount = $prestasiModel->countAll();
        $programCount  = $programModel->countAll();

        $db = Database::connect();
        $hasColumn = function($table, $column) use ($db) {
            try {
                $fields = $db->getFieldData($table);
                foreach ($fields as $f) {
                    if (isset($f->name) && $f->name === $column) return true;
                }
            } catch (\Throwable $e) {
                return false;
            }
            return false;
        };

        $kegiatanTerverifikasi = $hasColumn('kegiatan', 'status_verifikasi')
            ? $kegiatanModel->where('status_verifikasi', 'disetujui')->countAllResults()
            : 0;
        $prestasiTerverifikasi = $hasColumn('prestasi', 'status_verifikasi')
            ? $prestasiModel->where('status_verifikasi', 'disetujui')->countAllResults()
            : 0;
        $dokumenTerverifikasi  = $hasColumn('dokumen_osis', 'status_verifikasi')
            ? $dokumenModel->where('status_verifikasi', 'disetujui')->countAllResults()
            : 0;
        $kepuasan = $kegiatanTerverifikasi + $prestasiTerverifikasi + $dokumenTerverifikasi;

        return view('landing', [
            'stat_kegiatan' => $kegiatanCount,
            'stat_prestasi' => $prestasiCount,
            'stat_program'  => $programCount,
            'stat_kepuasan' => $kepuasan
        ]);
    }
}
