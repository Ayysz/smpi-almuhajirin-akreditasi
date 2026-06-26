<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SimplifyKegiatanUploads extends Migration
{
    public function up()
    {
        $fields = [
            'file_absensi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'tahun_ajaran'],
            'dokumentasi_kegiatan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'file_absensi'],
        ];

        $this->forge->addColumn('kegiatan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('kegiatan', ['file_absensi', 'dokumentasi_kegiatan']);
    }
}
