<?php
namespace App\Models;

use CodeIgniter\Model;

class ProgramOsisModel extends Model
{
    protected $table = 'program_osis';
    protected $primaryKey = 'id_program';
    
    // GUNAKAN NAMA KOLOM YANG SESUAI DENGAN DATABASE!
    protected $allowedFields = [
        'nama_program', 
        'deskripsi', 
        'seksi', // <- INI YANG BENAR (bukan seksi_penanggung_jawab)
        'tanggal_mulai', 
        'tanggal_selesai',
        'status',
        'file_proposal',
        'periode',
        'created_at' // <- tambahkan ini
    ];
    
    // Database TIDAK punya kolom updated_at, jadi DISABLE
    protected $useTimestamps = false;
    // Hapus atau comment baris ini:
    // protected $createdField = 'created_at';
    // protected $updatedField = 'updated_at';

    // Method getProgramWithDetails perlu disesuaikan
    public function getProgramWithDetails($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('program_osis.*, users.nama_lengkap as nama_creator');
        $builder->join('users', 'users.id_user = program_osis.created_by', 'left');
        
        if ($id) {
            $builder->where('program_osis.id_program', $id);
            return $builder->get()->getRowArray();
        }
        
        $builder->orderBy('program_osis.created_at', 'DESC');
        return $builder->get()->getResultArray();
    }

    // Get program by status
    public function getByStatus($status)
    {
        return $this->where('status', $status)
                    ->orderBy('tanggal_mulai', 'DESC')
                    ->findAll();
    }

    // Get program by periode
    public function getByPeriode($periode)
    {
        return $this->where('periode', $periode)
                    ->orderBy('tanggal_mulai', 'DESC')
                    ->findAll();
    }
}