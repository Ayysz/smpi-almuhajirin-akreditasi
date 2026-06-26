<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNamaSiswaToPrestasi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('prestasi', [
            'nama_siswa' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'id_prestasi'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('prestasi', 'nama_siswa');
    }
}
