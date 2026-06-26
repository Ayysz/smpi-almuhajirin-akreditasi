<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDynamicFieldsToKegiatan extends Migration
{
    public function up()
    {
        $fields = [
            // Shared
            'file_laporan_akhir' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            
            // EKSTRAKURIKULER
            'nama_ekskul' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'pembina_ekskul' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'jadwal_rutin' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'jumlah_pertemuan' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'file_absensi_ekskul' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            
            // OSIS (Specific to Kegiatan table to avoid confusion with Osis module)
            'nama_proker_keg' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'ketua_pelaksana' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'pembina_osis_keg' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sasaran_peserta_osis' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'anggaran' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'null' => true],
            'file_sk_panitia' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            
            // PRAMUKA
            'jenis_pramuka' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tingkatan_pramuka' => ['type' => 'ENUM', 'constraint' => ['Siaga', 'Penggalang', 'Penegak'], 'null' => true],
            'pembina_pramuka' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sku_skk' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'file_absensi_pramuka' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            
            // OLAHRAGA
            'cabang_olahraga' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'jenis_event_olahraga' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'penyelenggara_olahraga' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'pembina_olahraga' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tingkat_kompetisi_olahraga' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'file_sertifikat_olahraga' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            
            // SENI & BUDAYA
            'jenis_seni' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'jenis_event_seni' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'pembina_seni' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tema_kegiatan_seni' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'peserta_penampil' => ['type' => 'TEXT', 'null' => true],
            'file_dokumentasi_karya' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            
            // KEAGAMAAN
            'agama' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'nama_kegiatan_spesifik' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'pembina_agama' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sasaran_peserta_agama' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'file_absensi_agama' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            
            // LOMBA
            'nama_lomba' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'bidang_lomba' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'penyelenggara_lomba' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tingkat_kompetisi_lomba' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'nama_peserta_lomba' => ['type' => 'TEXT', 'null' => true],
            'guru_pendamping' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hasil_peringkat' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'file_surat_tugas' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'file_sertifikat_lomba' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            
            // LAINNYA
            'kategori_khusus' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'pembina_lainnya' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ];

        $this->forge->addColumn('kegiatan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('kegiatan', array_keys($this->up_fields()));
    }
    
    private function up_fields() {
        // Helper to get keys for down()
        $migration = new self();
        // Since we can't easily call up() without side effects, we just return the keys manually or re-list them
        return [
            'file_laporan_akhir', 'nama_ekskul', 'pembina_ekskul', 'jadwal_rutin', 'jumlah_pertemuan', 'file_absensi_ekskul',
            'nama_proker_keg', 'ketua_pelaksana', 'pembina_osis_keg', 'sasaran_peserta_osis', 'anggaran', 'file_sk_panitia',
            'jenis_pramuka', 'tingkatan_pramuka', 'pembina_pramuka', 'sku_skk', 'file_absensi_pramuka',
            'cabang_olahraga', 'jenis_event_olahraga', 'penyelenggara_olahraga', 'pembina_olahraga', 'tingkat_kompetisi_olahraga', 'file_sertifikat_olahraga',
            'jenis_seni', 'jenis_event_seni', 'pembina_seni', 'tema_kegiatan_seni', 'peserta_penampil', 'file_dokumentasi_karya',
            'agama', 'nama_kegiatan_spesifik', 'pembina_agama', 'sasaran_peserta_agama', 'file_absensi_agama',
            'nama_lomba', 'bidang_lomba', 'penyelenggara_lomba', 'tingkat_kompetisi_lomba', 'nama_peserta_lomba', 'guru_pendamping', 'hasil_peringkat', 'file_surat_tugas', 'file_sertifikat_lomba',
            'kategori_khusus', 'pembina_lainnya'
        ];
    }
}
