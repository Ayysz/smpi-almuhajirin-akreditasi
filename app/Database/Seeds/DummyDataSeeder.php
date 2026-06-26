<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Users
        $usersData = [
            [
                'username' => 'dummy_admin',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Admin Dummy',
                'role' => 'admin',
                'nip_nis' => '1001001',
                'email' => 'admin.dummy@example.com',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'dummy_osis',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Osis Dummy',
                'role' => 'osis',
                'nip_nis' => '2002002',
                'email' => 'osis.dummy@example.com',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'dummy_siswa',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Siswa Dummy',
                'role' => 'siswa',
                'nip_nis' => '3003003',
                'email' => 'siswa.dummy@example.com',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('users')->insertBatch($usersData);

        // 2. Dokumen Osis
        $dokumenData = [
            [
                'jenis_dokumen' => 'SK',
                'nama_dokumen' => 'SK Kepengurusan Dummy 1',
                'nomor_dokumen' => 'SK/001/DUMMY',
                'tanggal_dokumen' => date('Y-m-d'),
                'periode' => '2023/2024',
                'keterangan' => 'Dokumen Dummy 1',
                'status' => 'aktif',
                'status_verifikasi' => 'disetujui',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'jenis_dokumen' => 'Sertifikat',
                'nama_dokumen' => 'Sertifikat Lomba Dummy 2',
                'nomor_dokumen' => 'SRT/002/DUMMY',
                'tanggal_dokumen' => date('Y-m-d'),
                'periode' => '2023/2024',
                'keterangan' => 'Dokumen Dummy 2',
                'status' => 'aktif',
                'status_verifikasi' => 'disetujui',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'jenis_dokumen' => 'Laporan',
                'nama_dokumen' => 'Laporan LPJ Dummy 3',
                'nomor_dokumen' => 'LPJ/003/DUMMY',
                'tanggal_dokumen' => date('Y-m-d'),
                'periode' => '2023/2024',
                'keterangan' => 'Dokumen Dummy 3',
                'status' => 'aktif',
                'status_verifikasi' => 'menunggu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('dokumen_osis')->insertBatch($dokumenData);

        // 3. Kegiatan
        $kegiatanData = [
            [
                'nama_kegiatan' => 'Class Meeting Dummy',
                'jenis_kegiatan' => 'Internal',
                'tanggal_mulai' => date('Y-m-d', strtotime('+1 days')),
                'tanggal_selesai' => date('Y-m-d', strtotime('+3 days')),
                'tempat' => 'Lapangan Sekolah',
                'status_verifikasi' => 'disetujui',
                'tahun_ajaran' => '2023/2024',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kegiatan' => 'Porseni Dummy',
                'jenis_kegiatan' => 'Eksternal',
                'tanggal_mulai' => date('Y-m-d', strtotime('+10 days')),
                'tanggal_selesai' => date('Y-m-d', strtotime('+12 days')),
                'tempat' => 'GOR Kota',
                'status_verifikasi' => 'menunggu',
                'tahun_ajaran' => '2023/2024',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kegiatan' => 'LDKS Dummy',
                'jenis_kegiatan' => 'Internal',
                'tanggal_mulai' => date('Y-m-d', strtotime('-5 days')),
                'tanggal_selesai' => date('Y-m-d', strtotime('-3 days')),
                'tempat' => 'Aula Sekolah',
                'status_verifikasi' => 'disetujui',
                'tahun_ajaran' => '2023/2024',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('kegiatan')->insertBatch($kegiatanData);

        // 4. Laporan Kegiatan Osis
        $laporanData = [
            [
                'nama_kegiatan' => 'Laporan LDKS Dummy',
                'tanggal_pelaksanaan' => date('Y-m-d', strtotime('-5 days')),
                'jumlah_peserta' => 100,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kegiatan' => 'Laporan Maulid Nabi Dummy',
                'tanggal_pelaksanaan' => date('Y-m-d', strtotime('-30 days')),
                'jumlah_peserta' => 500,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kegiatan' => 'Laporan HUT Sekolah Dummy',
                'tanggal_pelaksanaan' => date('Y-m-d', strtotime('-60 days')),
                'jumlah_peserta' => 1000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('laporan_kegiatan_osis')->insertBatch($laporanData);

        // 5. Pengurus Osis
        $pengurusData = [
            [
                'nama_siswa' => 'Budi Dummy',
                'nisn' => '1234567890',
                'no_telp' => '081234567890',
                'jabatan' => 'Ketua',
                'periode' => '2023/2024',
                'status' => 'Aktif',
            ],
            [
                'nama_siswa' => 'Siti Dummy',
                'nisn' => '1234567891',
                'no_telp' => '081234567891',
                'jabatan' => 'Wakil Ketua',
                'periode' => '2023/2024',
                'status' => 'Aktif',
            ],
            [
                'nama_siswa' => 'Andi Dummy',
                'nisn' => '1234567892',
                'no_telp' => '081234567892',
                'jabatan' => 'Sekretaris',
                'periode' => '2023/2024',
                'status' => 'Aktif',
            ]
        ];
        $this->db->table('pengurus_osis')->insertBatch($pengurusData);

        // 6. Prestasi
        $prestasiData = [
            [
                'nama_siswa' => 'Siswa Dummy Berprestasi 1',
                'nama_prestasi' => 'Juara 1 Lomba Pidato',
                'tingkat' => 'Kabupaten/Kota',
                'kategori' => 'Akademik',
                'peringkat' => 'Juara 1',
                'tahun_perolehan' => date('Y'),
                'penyelenggara' => 'Dinas Pendidikan',
                'status_verifikasi' => 'disetujui',
                'tanggal_pelaksanaan' => date('Y-m-d', strtotime('-10 days')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_siswa' => 'Siswa Dummy Berprestasi 2',
                'nama_prestasi' => 'Juara 2 Lomba Futsal',
                'tingkat' => 'Provinsi',
                'kategori' => 'Non-Akademik',
                'peringkat' => 'Juara 2',
                'tahun_perolehan' => date('Y'),
                'penyelenggara' => 'PSSI',
                'status_verifikasi' => 'menunggu',
                'tanggal_pelaksanaan' => date('Y-m-d', strtotime('-20 days')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_siswa' => 'Siswa Dummy Berprestasi 3',
                'nama_prestasi' => 'Juara 3 Olimpiade Matematika',
                'tingkat' => 'Nasional',
                'kategori' => 'Akademik',
                'peringkat' => 'Juara 3',
                'tahun_perolehan' => date('Y'),
                'penyelenggara' => 'Kementerian Pendidikan',
                'status_verifikasi' => 'disetujui',
                'tanggal_pelaksanaan' => date('Y-m-d', strtotime('-30 days')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('prestasi')->insertBatch($prestasiData);

        // 7. Program Osis
        $programData = [
            [
                'nama_program' => 'Bakti Sosial Dummy',
                'deskripsi' => 'Program bakti sosial panti asuhan',
                'seksi' => 'Bidang Keagamaan',
                'tanggal_mulai' => date('Y-m-d', strtotime('+5 days')),
                'tanggal_selesai' => date('Y-m-d', strtotime('+6 days')),
                'status' => 'Direncanakan',
                'periode' => '2023/2024',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_program' => 'Pentas Seni Dummy',
                'deskripsi' => 'Program pentas seni tahunan',
                'seksi' => 'Bidang Kesenian',
                'tanggal_mulai' => date('Y-m-d', strtotime('+30 days')),
                'tanggal_selesai' => date('Y-m-d', strtotime('+31 days')),
                'status' => 'Direncanakan',
                'periode' => '2023/2024',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_program' => 'Latihan Dasar Kepemimpinan Dummy',
                'deskripsi' => 'LDKS untuk pengurus baru',
                'seksi' => 'Bidang Organisasi',
                'tanggal_mulai' => date('Y-m-d', strtotime('-10 days')),
                'tanggal_selesai' => date('Y-m-d', strtotime('-8 days')),
                'status' => 'Terlaksana',
                'periode' => '2023/2024',
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('program_osis')->insertBatch($programData);
    }
}
