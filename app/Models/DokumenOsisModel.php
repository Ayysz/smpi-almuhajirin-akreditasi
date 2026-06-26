<?php
namespace App\Models;

use CodeIgniter\Model;

class DokumenOsisModel extends Model
{
    protected $table = 'dokumen_osis';
    protected $primaryKey = 'id_dokumen';
    protected $allowedFields = [
        'jenis_dokumen', 'nama_dokumen', 'nomor_dokumen',
        'tanggal_dokumen', 'periode', 'file_path',
        'keterangan', 'status', 'status_verifikasi',
        'uploaded_by', 'created_at', 'updated_at'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Get dokumen dengan uploader
    public function getDokumenWithUploader($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('dokumen_osis.*, users.nama_lengkap as uploader');
        $builder->join('users', 'users.id_user = dokumen_osis.uploaded_by', 'left');
        if ($id) {
            $builder->where('dokumen_osis.id_dokumen', $id);
            return $builder->get()->getRowArray();
        }
        
        $builder->orderBy('dokumen_osis.created_at', 'DESC');
        return $builder->get()->getResultArray();
    }

    // Get by jenis dokumen
    public function getByJenis($jenis)
    {
        return $this->where('jenis_dokumen', $jenis)
                    ->where('status', 'aktif')
                    ->orderBy('tanggal_dokumen', 'DESC')
                    ->findAll();
    }

    // Get by periode
    public function getByPeriode($periode)
    {
        $builder = $this->db->table($this->table);
        $builder->select('dokumen_osis.*, users.nama_lengkap as uploader');
        $builder->join('users', 'users.id_user = dokumen_osis.uploaded_by', 'left');
        $builder->where('dokumen_osis.periode', $periode);
        $builder->where('dokumen_osis.status', 'aktif');
        $builder->orderBy('dokumen_osis.tanggal_dokumen', 'DESC');
        return $builder->get()->getResultArray();
    }
}