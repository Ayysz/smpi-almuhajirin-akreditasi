<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $allowedFields = [
        'username', 
        'password', 
        'nama_lengkap', 
        'role', 
        'nip_nis', 
        'email', 
        'foto', 
        'is_active'
    ];
    
    // PENTING: Set ini ke false jika tidak pakai timestamps
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Atau jika error, set false:
    // protected $useTimestamps = false;
}
