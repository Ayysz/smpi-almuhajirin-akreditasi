<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAlasanPenolakan extends Migration
{
    public function up()
    {
        // Tambahkan kolom alasan_penolakan ke tabel 'kegiatan' jika belum ada
        try {
            $fields = $this->db->getFieldData('kegiatan');
            $exists = false;
            foreach ($fields as $f) {
                if ($f->name === 'alasan_penolakan') { $exists = true; break; }
            }
            if (!$exists) {
                $this->forge->addColumn('kegiatan', [
                    'alasan_penolakan' => [
                        'type' => 'TEXT',
                        'null' => true,
                        'after' => 'status_verifikasi'
                    ]
                ]);
            }
        } catch (\Throwable $e) {
            // ignore
        }

        // Tambahkan kolom alasan_penolakan ke tabel 'prestasi' jika belum ada
        try {
            $fields = $this->db->getFieldData('prestasi');
            $exists = false;
            foreach ($fields as $f) {
                if ($f->name === 'alasan_penolakan') { $exists = true; break; }
            }
            if (!$exists) {
                $this->forge->addColumn('prestasi', [
                    'alasan_penolakan' => [
                        'type' => 'TEXT',
                        'null' => true,
                        'after' => 'status_verifikasi'
                    ]
                ]);
            }
        } catch (\Throwable $e) {
            // ignore
        }
    }

    public function down()
    {
        // Drop kolom jika ada
        try {
            $fields = $this->db->getFieldData('kegiatan');
            $exists = false;
            foreach ($fields as $f) {
                if ($f->name === 'alasan_penolakan') { $exists = true; break; }
            }
            if ($exists) {
                $this->forge->dropColumn('kegiatan', 'alasan_penolakan');
            }
        } catch (\Throwable $e) {
            // ignore
        }

        try {
            $fields = $this->db->getFieldData('prestasi');
            $exists = false;
            foreach ($fields as $f) {
                if ($f->name === 'alasan_penolakan') { $exists = true; break; }
            }
            if ($exists) {
                $this->forge->dropColumn('prestasi', 'alasan_penolakan');
            }
        } catch (\Throwable $e) {
            // ignore
        }
    }
}

