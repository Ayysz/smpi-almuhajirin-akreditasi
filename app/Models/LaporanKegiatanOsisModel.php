<?php
namespace App\Models;

use CodeIgniter\Model;

class LaporanKegiatanOsisModel extends Model
{
    protected $table = 'laporan_kegiatan_osis';
    protected $primaryKey = 'id_laporan';
    protected $allowedFields = [
        'nama_kegiatan', 
        'tanggal_pelaksanaan', 
        'jumlah_peserta', 
        'dokumentasi', 
        'file_laporan',
        'created_by',
        'created_at',
        'updated_at'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getLaporanWithUploader($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('laporan_kegiatan_osis.*, users.nama_lengkap as uploader');
        $builder->join('users', 'users.id_user = laporan_kegiatan_osis.created_by', 'left');
        
        if ($id) {
            $builder->where('laporan_kegiatan_osis.id_laporan', $id);
            return $builder->get()->getRowArray();
        }
        
        $builder->orderBy('laporan_kegiatan_osis.tanggal_pelaksanaan', 'DESC');
        return $builder->get()->getResultArray();
    }
}
