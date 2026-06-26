<?php
namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id_kegiatan';
    protected $allowedFields = [
        'nama_kegiatan',
        'jenis_kegiatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'tempat',
        'status_verifikasi',
        'alasan_penolakan',
        'tahun_ajaran',
        'file_absensi',
        'foto_kegiatan',
        'rundown_kegiatan',
        'surat_keterangan',
        'proposal_laporan',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllKegiatan()
    {
        return $this->select('kegiatan.*, users.nama_lengkap as nama_penanggung_jawab')
                    ->join('users', 'users.id_user = kegiatan.penanggung_jawab', 'left')
                    ->orderBy('kegiatan.created_at', 'DESC')
                    ->findAll();
    }

    public function getKegiatanBerjalan()
    {
        return $this->where('tanggal_mulai <=', date('Y-m-d'))
                    ->where('tanggal_selesai >=', date('Y-m-d'))
                    ->findAll();
    }

    public function countPendingVerifikasi()
    {
        return $this->where('status_verifikasi', 'menunggu')->countAllResults();
    }

    public function countKegiatanBulanIni()
    {
        return $this->where('MONTH(tanggal_mulai)', date('m'))
                    ->where('YEAR(tanggal_mulai)', date('Y'))
                    ->countAllResults();
    }
    
    public function countByMonth($year = null)
    {
        $year = $year ?? date('Y');
        $rows = $this->select('MONTH(tanggal_mulai) as m, COUNT(*) as c')
                     ->where('YEAR(tanggal_mulai)', $year)
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
        $rows = $this->select('MONTH(tanggal_mulai) as m, COUNT(*) as c')
                     ->where('YEAR(tanggal_mulai)', $year)
                     ->where('created_by', $userId)
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
    
    public function getKegiatanMendatang($limit = 3)
    {
        return $this->where('tanggal_mulai >', date('Y-m-d'))
                    ->orderBy('tanggal_mulai', 'ASC')
                    ->limit($limit)
                    ->find();
    }
    
    public function getPendingVerifikasi($limit = 10)
    {
        return $this->where('status_verifikasi', 'menunggu')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->find();
    }
}
