<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveLombaFieldsFromPrestasi extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('prestasi', ['nama_lomba', 'guru_pendamping', 'nama_tim', 'bidang_lomba']);
    }

    public function down()
    {
        $fields = [
            'nama_lomba' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'bidang_lomba' => [
                'type' => 'ENUM',
                'constraint' => ['Akademik', 'Olahraga', 'Seni & Budaya', 'Pramuka', 'Teknologi', 'Keagamaan', 'Lainnya'],
                'null' => true,
            ],
            'guru_pendamping' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'nama_tim' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ];

        $this->forge->addColumn('prestasi', $fields);
    }
}
