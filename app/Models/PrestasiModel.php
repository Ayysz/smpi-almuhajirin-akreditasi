<?php
namespace App\Models;

use CodeIgniter\Model;

class PrestasiModel extends Model
{
    protected $table = 'prestasi';
    protected $primaryKey = 'id_prestasi';
    protected $allowedFields = [
        'nama_siswa', 'nama_prestasi', 'tingkat', 'kategori',
        'peringkat', 'tahun_perolehan', 'penyelenggara',
        'file_sertifikat', 'surat_tugas', 'dokumen_pendukung',
        'status_verifikasi', 'alasan_penolakan',
        'tanggal_pelaksanaan', 'lokasi_lomba', 'created_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllPrestasi()
    {
        return $this->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function countPrestasiTahunIni()
    {
        return $this->where('tahun_perolehan', date('Y'))
                    ->countAllResults();
    }
    
    public function countByMonth($year = null)
    {
        $year = $year ?? date('Y');
        $rows = $this->select('MONTH(created_at) as m, COUNT(*) as c')
                     ->where('YEAR(created_at)', $year)
                     ->groupBy('m')
                     ->orderBy('m', 'ASC')
                     ->findAll();
        $out = array_fill(1, 12, 0);
        foreach ($rows as $r) {
            $out[(int)$r['m']] = (int)$r['c'];
        }
        return $out;
    }
    
    public function countByMonthForUser($userId, $year = null)
    {
        $year = $year ?? date('Y');
        $currentName = (string) (session()->get('nama_lengkap') ?? '');
        $rows = $this->select('MONTH(created_at) as m, COUNT(*) as c')
                     ->where('YEAR(created_at)', $year)
                     ->where('nama_siswa', $currentName)
                     ->groupBy('m')
                     ->orderBy('m', 'ASC')
                     ->findAll();
        $out = array_fill(1, 12, 0);
        foreach ($rows as $r) {
            $out[(int)$r['m']] = (int)$r['c'];
        }
        return $out;
    }

    public function getRecent($limit = 5)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->find();
    }

    public function countPendingVerifikasi()
    {
        return $this->where('status_verifikasi', 'menunggu')->countAllResults();
    }
}
