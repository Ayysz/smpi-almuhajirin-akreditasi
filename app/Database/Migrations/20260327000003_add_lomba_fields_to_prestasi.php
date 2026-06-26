<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLombaFieldsToPrestasi extends Migration
{
    public function up()
    {
        $fields = [
            'tanggal_pelaksanaan' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'lokasi_lomba' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
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

    public function down()
    {
        $this->forge->dropColumn('prestasi', ['tanggal_pelaksanaan', 'lokasi_lomba', 'nama_lomba', 'bidang_lomba', 'guru_pendamping', 'nama_tim']);
    }
}
