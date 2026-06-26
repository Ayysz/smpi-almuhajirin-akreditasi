<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveSiswaRole extends Migration
{
    public function up()
    {
        // 1. Hapus user dengan role 'siswa'
        // PENTING: Karena 'id_siswa' di tabel prestasi dan pengurus_osis 
        // merujuk ke id_user, kita harus berhati-hati. 
        // Namun karena permintaan adalah menghapus role siswa secara total:
        
        $this->db->table('users')->where('role', 'siswa')->delete();
    }

    public function down()
    {
        // Tidak ada rollback otomatis untuk penghapusan data
    }
}
