<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NormalizeKegiatanAndAddUploadedBy extends Migration
{
    public function up()
    {
        $this->addUploadedByColumns();
        $this->createKegiatanChildTables();
        $this->migrateKegiatanToChildTables();
        $this->dropLegacyKegiatanDynamicColumns();
    }

    public function down()
    {
        $this->dropKegiatanChildTables();
        $this->dropUploadedByColumns();
    }

    private function addUploadedByColumns(): void
    {
        if ($this->db->tableExists('prestasi') && ! $this->db->fieldExists('uploaded_by', 'prestasi')) {
            $this->forge->addColumn('prestasi', [
                'uploaded_by' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                ],
            ]);
            $this->tryAddForeignKey('prestasi', 'uploaded_by', 'users', 'id_user', 'SET NULL', 'CASCADE', 'fk_prestasi_uploaded_by');
        }

        if ($this->db->tableExists('pengurus_osis')) {
            if (! $this->db->fieldExists('uploaded_by', 'pengurus_osis')) {
                $this->forge->addColumn('pengurus_osis', [
                    'uploaded_by' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                        'null' => true,
                    ],
                ]);
                $this->tryAddForeignKey('pengurus_osis', 'uploaded_by', 'users', 'id_user', 'SET NULL', 'CASCADE', 'fk_pengurus_osis_uploaded_by');
            }
            if (! $this->db->fieldExists('nisn', 'pengurus_osis')) {
                $this->forge->addColumn('pengurus_osis', [
                    'nisn' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true, 'after' => 'nama_siswa'],
                ]);
            }
            if (! $this->db->fieldExists('no_telp', 'pengurus_osis')) {
                $this->forge->addColumn('pengurus_osis', [
                    'no_telp' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true, 'after' => 'nisn'],
                ]);
            }
            // Hapus kolom tanggal jika ada
            if ($this->db->fieldExists('tanggal_mulai', 'pengurus_osis')) {
                $this->forge->dropColumn('pengurus_osis', 'tanggal_mulai');
            }
            if ($this->db->fieldExists('tanggal_selesai', 'pengurus_osis')) {
                $this->forge->dropColumn('pengurus_osis', 'tanggal_selesai');
            }
        }
    }

    private function dropUploadedByColumns(): void
    {
        if ($this->db->tableExists('prestasi') && $this->db->fieldExists('uploaded_by', 'prestasi')) {
            $this->tryDropForeignKey('prestasi', 'fk_prestasi_uploaded_by');
            $this->forge->dropColumn('prestasi', 'uploaded_by');
        }

        if ($this->db->tableExists('pengurus_osis') && $this->db->fieldExists('uploaded_by', 'pengurus_osis')) {
            $this->tryDropForeignKey('pengurus_osis', 'fk_pengurus_osis_uploaded_by');
            $this->forge->dropColumn('pengurus_osis', 'uploaded_by');
        }
    }

    private function createKegiatanChildTables(): void
    {
        if (! $this->db->tableExists('kegiatan_ekstrakurikuler')) {
            $this->forge->addField([
                'id_kegiatan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'pembina' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'absensi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'dokumentasi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            ]);
            $this->forge->addKey('id_kegiatan', true);
            $this->forge->addForeignKey('id_kegiatan', 'kegiatan', 'id_kegiatan', 'CASCADE', 'CASCADE');
            $this->forge->createTable('kegiatan_ekstrakurikuler', true);
        }

        if (! $this->db->tableExists('kegiatan_karakter')) {
            $this->forge->addField([
                'id_kegiatan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'nama_program' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'absensi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'dokumentasi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'laporan_pelaksanaan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            ]);
            $this->forge->addKey('id_kegiatan', true);
            $this->forge->addForeignKey('id_kegiatan', 'kegiatan', 'id_kegiatan', 'CASCADE', 'CASCADE');
            $this->forge->createTable('kegiatan_karakter', true);
        }

        if (! $this->db->tableExists('kegiatan_keagamaan')) {
            $this->forge->addField([
                'id_kegiatan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'absensi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'dokumentasi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'laporan_pelaksanaan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            ]);
            $this->forge->addKey('id_kegiatan', true);
            $this->forge->addForeignKey('id_kegiatan', 'kegiatan', 'id_kegiatan', 'CASCADE', 'CASCADE');
            $this->forge->createTable('kegiatan_keagamaan', true);
        }

        if (! $this->db->tableExists('kegiatan_lainnya')) {
            $this->forge->addField([
                'id_kegiatan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'absensi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'dokumentasi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            ]);
            $this->forge->addKey('id_kegiatan', true);
            $this->forge->addForeignKey('id_kegiatan', 'kegiatan', 'id_kegiatan', 'CASCADE', 'CASCADE');
            $this->forge->createTable('kegiatan_lainnya', true);
        }

        if (! $this->db->tableExists('kegiatan_pramuka')) {
            $this->forge->addField([
                'id_kegiatan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'tingkatan' => ['type' => 'ENUM', 'constraint' => ['Siaga', 'Penggalang', 'Penegak'], 'null' => true],
                'pembina' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'absensi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'dokumentasi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'sku_skk' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'nama_kegiatan_pramuka' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            ]);
            $this->forge->addKey('id_kegiatan', true);
            $this->forge->addForeignKey('id_kegiatan', 'kegiatan', 'id_kegiatan', 'CASCADE', 'CASCADE');
            $this->forge->createTable('kegiatan_pramuka', true);
        }
    }

    private function dropKegiatanChildTables(): void
    {
        foreach ([
            'kegiatan_ekstrakurikuler',
            'kegiatan_karakter',
            'kegiatan_keagamaan',
            'kegiatan_lainnya',
            'kegiatan_pramuka',
        ] as $table) {
            if ($this->db->tableExists($table)) {
                $this->forge->dropTable($table, true);
            }
        }
    }

    private function migrateKegiatanToChildTables(): void
    {
        if (! $this->db->tableExists('kegiatan')) {
            return;
        }

        $rows = $this->db->table('kegiatan')->get()->getResultArray();
        foreach ($rows as $row) {
            $idKegiatan = isset($row['id_kegiatan']) ? (int) $row['id_kegiatan'] : 0;
            if ($idKegiatan <= 0) {
                continue;
            }

            $jenis = strtoupper(trim((string) ($row['jenis_kegiatan'] ?? '')));

            if ($jenis === 'EKSTRAKURIKULER' && $this->db->tableExists('kegiatan_ekstrakurikuler')) {
                $exists = $this->db->table('kegiatan_ekstrakurikuler')->where('id_kegiatan', $idKegiatan)->countAllResults() > 0;
                if (! $exists) {
                    $this->db->table('kegiatan_ekstrakurikuler')->insert([
                        'id_kegiatan' => $idKegiatan,
                        'pembina' => $row['pembina_ekskul'] ?? null,
                        'absensi' => $row['file_absensi_ekskul'] ?? ($row['file_absensi'] ?? null),
                        'dokumentasi' => $row['dokumentasi_kegiatan'] ?? null,
                    ]);
                }
            }

            if ($jenis === 'PRAMUKA' && $this->db->tableExists('kegiatan_pramuka')) {
                $exists = $this->db->table('kegiatan_pramuka')->where('id_kegiatan', $idKegiatan)->countAllResults() > 0;
                if (! $exists) {
                    $this->db->table('kegiatan_pramuka')->insert([
                        'id_kegiatan' => $idKegiatan,
                        'tingkatan' => $row['tingkatan_pramuka'] ?? null,
                        'pembina' => $row['pembina_pramuka'] ?? null,
                        'sku_skk' => $row['sku_skk'] ?? null,
                        'nama_kegiatan_pramuka' => $row['nama_kegiatan'] ?? null,
                    ]);
                }
            }

            if ($jenis === 'KEAGAMAAN' && $this->db->tableExists('kegiatan_keagamaan')) {
                $exists = $this->db->table('kegiatan_keagamaan')->where('id_kegiatan', $idKegiatan)->countAllResults() > 0;
                if (! $exists) {
                    $this->db->table('kegiatan_keagamaan')->insert([
                        'id_kegiatan' => $idKegiatan,
                        'absensi' => $row['file_absensi_agama'] ?? ($row['file_absensi'] ?? null),
                        'dokumentasi' => $row['dokumentasi_kegiatan'] ?? null,
                        'laporan_pelaksanaan' => $row['file_laporan_akhir'] ?? null,
                    ]);
                }
            }

            if (($jenis === 'LAINNYA' || $jenis === 'SOSIAL') && $this->db->tableExists('kegiatan_lainnya')) {
                $exists = $this->db->table('kegiatan_lainnya')->where('id_kegiatan', $idKegiatan)->countAllResults() > 0;
                if (! $exists) {
                    $this->db->table('kegiatan_lainnya')->insert([
                        'id_kegiatan' => $idKegiatan,
                        'absensi' => $row['file_absensi'] ?? null,
                        'dokumentasi' => $row['dokumentasi_kegiatan'] ?? null,
                    ]);
                }
            }

            if ($jenis === 'KARAKTER' && $this->db->tableExists('kegiatan_karakter')) {
                $exists = $this->db->table('kegiatan_karakter')->where('id_kegiatan', $idKegiatan)->countAllResults() > 0;
                if (! $exists) {
                    $this->db->table('kegiatan_karakter')->insert([
                        'id_kegiatan' => $idKegiatan,
                        'nama_program' => $row['nama_kegiatan'] ?? null,
                        'absensi' => $row['file_absensi'] ?? null,
                        'dokumentasi' => $row['dokumentasi_kegiatan'] ?? null,
                        'laporan_pelaksanaan' => null,
                    ]);
                }
            }
        }
    }

    private function dropLegacyKegiatanDynamicColumns(): void
    {
        if (! $this->db->tableExists('kegiatan')) {
            return;
        }

        $drop = [
            'file_laporan_akhir',
            'nama_ekskul',
            'pembina_ekskul',
            'jadwal_rutin',
            'jumlah_pertemuan',
            'file_absensi_ekskul',
            'nama_proker_keg',
            'ketua_pelaksana',
            'pembina_osis_keg',
            'sasaran_peserta_osis',
            'anggaran',
            'file_sk_panitia',
            'jenis_pramuka',
            'tingkatan_pramuka',
            'pembina_pramuka',
            'sku_skk',
            'file_absensi_pramuka',
            'cabang_olahraga',
            'jenis_event_olahraga',
            'penyelenggara_olahraga',
            'pembina_olahraga',
            'tingkat_kompetisi_olahraga',
            'file_sertifikat_olahraga',
            'jenis_seni',
            'jenis_event_seni',
            'pembina_seni',
            'tema_kegiatan_seni',
            'peserta_penampil',
            'file_dokumentasi_karya',
            'agama',
            'nama_kegiatan_spesifik',
            'pembina_agama',
            'sasaran_peserta_agama',
            'file_absensi_agama',
            'nama_lomba',
            'bidang_lomba',
            'penyelenggara_lomba',
            'tingkat_kompetisi_lomba',
            'nama_peserta_lomba',
            'guru_pendamping',
            'hasil_peringkat',
            'file_surat_tugas',
            'file_sertifikat_lomba',
            'kategori_khusus',
            'pembina_lainnya',
            'deskripsi',
            'proposal',
            'foto_kegiatan',
            'file_absensi',
            'dokumentasi_kegiatan',
        ];

        foreach ($drop as $col) {
            if ($this->db->fieldExists($col, 'kegiatan')) {
                $this->forge->dropColumn('kegiatan', $col);
            }
        }
    }

    private function tryAddForeignKey(
        string $table,
        string $column,
        string $refTable,
        string $refColumn,
        string $onDelete,
        string $onUpdate,
        string $constraintName
    ): void {
        try {
            $sql = sprintf(
                'ALTER TABLE `%s` ADD CONSTRAINT `%s` FOREIGN KEY (`%s`) REFERENCES `%s`(`%s`) ON DELETE %s ON UPDATE %s',
                $table,
                $constraintName,
                $column,
                $refTable,
                $refColumn,
                $onDelete,
                $onUpdate
            );
            $this->db->query($sql);
        } catch (\Throwable $e) {
        }
    }

    private function tryDropForeignKey(string $table, string $constraintName): void
    {
        try {
            $this->db->query(sprintf('ALTER TABLE `%s` DROP FOREIGN KEY `%s`', $table, $constraintName));
        } catch (\Throwable $e) {
        }
    }
}
