<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Komprehensif</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 10px;
            background-color: #f0f0f0;
            padding: 5px 10px;
            border-left: 4px solid #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
            table-layout: fixed;
            word-wrap: break-word;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #eaeaea;
            font-weight: bold;
            text-align: center;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .signature {
            display: inline-block;
            text-align: center;
            margin-top: 20px;
        }
        .signature .name {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }
        a {
            color: #0000EE;
            text-decoration: none;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
            a {
                color: #000;
                text-decoration: underline;
            }
        }
        .btn-print {
            padding: 10px 20px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            font-size: 16px;
        }
        tr {
            page-break-inside: avoid;
        }
        .section-title {
            page-break-after: avoid;
        }
    </style>
</head>
<body>
    <!-- Overlay putih untuk menutupi HTML dari layar user, tapi html2pdf tetap bisa merender wrapper di bawahnya -->
    <div style="position:fixed; top:0; left:0; width:100%; height:100%; background:white; z-index:9999;"></div>

    <div id="pdf-wrapper">

    <div class="header">
        <h2>Laporan Komprehensif Kesiswaan & OSIS</h2>
        <p>Sistem Informasi Kegiatan Kesiswaan</p>
        <p>Tahun: <?= !empty($tahun_filter) ? esc($tahun_filter) : 'Semua Tahun' ?></p>
        <p>Tanggal Cetak: <?= date('d F Y') ?></p>
    </div>

    <!-- 1. KEGIATAN KESISWAAN -->
    <div class="section-title">1. Ringkasan Kegiatan Kesiswaan</div>
    <?php if(empty($kegiatan)): ?>
        <p><em>Tidak ada data kegiatan yang telah disetujui.</em></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Nama Kegiatan</th>
                    <th width="15%">Jenis</th>
                    <th width="15%">Tanggal</th>
                    <th width="20%">Tempat</th>
                    <th width="20%">Akses Data (Link)</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($kegiatan as $k): ?>
                <tr>
                    <td style="text-align:center;"><?= $no++ ?></td>
                    <td><?= esc($k['nama_kegiatan']) ?></td>
                    <td><?= esc($k['jenis_kegiatan']) ?></td>
                    <td><?= date('d/m/Y', strtotime($k['tanggal_mulai'])) ?></td>
                    <td><?= esc($k['tempat'] ?? '-') ?></td>
                    <td>
                        <?php if($k['proposal_laporan']): ?>- <a href="<?= base_url($k['proposal_laporan']) ?>">Proposal</a><br><?php endif; ?>
                        <?php if($k['file_absensi']): ?>- <a href="<?= base_url($k['file_absensi']) ?>">Absensi</a><br><?php endif; ?>
                        <?php if($k['foto_kegiatan']): ?>- <a href="<?= base_url($k['foto_kegiatan']) ?>">Foto Kegiatan</a><br><?php endif; ?>
                        <?php if($k['rundown_kegiatan']): ?>- <a href="<?= base_url($k['rundown_kegiatan']) ?>">Rundown</a><br><?php endif; ?>
                        <?php if($k['surat_keterangan']): ?>- <a href="<?= base_url($k['surat_keterangan']) ?>">SK/Tugas</a><br><?php endif; ?>
                        <?php if(!$k['proposal_laporan'] && !$k['file_absensi'] && !$k['foto_kegiatan'] && !$k['rundown_kegiatan'] && !$k['surat_keterangan']) echo '-'; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- 2. PRESTASI SISWA -->
    <div class="section-title">2. Ringkasan Prestasi Siswa</div>
    <?php if(empty($prestasi)): ?>
        <p><em>Tidak ada data prestasi yang telah disetujui.</em></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Nama Siswa</th>
                    <th width="25%">Nama Prestasi</th>
                    <th width="15%">Tingkat / Peringkat</th>
                    <th width="15%">Tahun</th>
                    <th width="20%">Akses Data (Link)</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($prestasi as $p): ?>
                <tr>
                    <td style="text-align:center;"><?= $no++ ?></td>
                    <td><?= esc($p['nama_siswa']) ?></td>
                    <td><?= esc($p['nama_prestasi']) ?></td>
                    <td><?= esc($p['tingkat']) ?> / <?= esc($p['peringkat']) ?></td>
                    <td style="text-align:center;"><?= esc($p['tahun_perolehan']) ?></td>
                    <td>
                        <?php if($p['file_sertifikat']): ?>- <a href="<?= base_url('view/prestasi/'.basename($p['file_sertifikat'])) ?>">Sertifikat</a><br><?php endif; ?>
                        <?php 
                        if(!empty($p['surat_tugas'])): 
                            $tugas = json_decode($p['surat_tugas'], true);
                            if(is_array($tugas) && !empty($tugas)):
                                foreach($tugas as $i => $file):
                        ?>
                            - <a href="<?= base_url('view/prestasi/'.basename($file)) ?>">Surat Tugas <?= $i+1 ?></a><br>
                        <?php 
                                endforeach;
                            endif;
                        endif; 
                        if(!$p['file_sertifikat'] && empty($p['surat_tugas'])) echo '-';
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- 3. PROGRAM KERJA OSIS -->
    <div class="section-title">3. Ringkasan OSIS (Program Kerja)</div>
    <?php if(empty($osis)): ?>
        <p><em>Tidak ada data program OSIS yang telah disetujui.</em></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Nama Program</th>
                    <th width="20%">Seksi / Divisi</th>
                    <th width="15%">Periode</th>
                    <th width="15%">Tanggal Mulai</th>
                    <th width="15%">Akses Data (Link)</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($osis as $o): ?>
                <tr>
                    <td style="text-align:center;"><?= $no++ ?></td>
                    <td><?= esc($o['nama_program']) ?></td>
                    <td><?= esc($o['seksi']) ?></td>
                    <td style="text-align:center;"><?= esc($o['periode']) ?></td>
                    <td style="text-align:center;"><?= $o['tanggal_mulai'] ? date('d/m/Y', strtotime($o['tanggal_mulai'])) : '-' ?></td>
                    <td>
                        <?php if(!empty($o['file_proposal'])): ?>
                            <a href="<?= base_url($o['file_proposal']) ?>">Proposal</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- 4. LAPORAN KEGIATAN OSIS -->
    <div class="section-title">4. Ringkasan OSIS (Laporan Kegiatan)</div>
    <?php if(empty($laporan_osis)): ?>
        <p><em>Tidak ada data laporan kegiatan OSIS yang telah disetujui.</em></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Nama Kegiatan</th>
                    <th width="20%">Tanggal Pelaksanaan</th>
                    <th width="15%">Jumlah Peserta</th>
                    <th width="25%">Akses Data (Link)</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($laporan_osis as $lo): ?>
                <tr>
                    <td style="text-align:center;"><?= $no++ ?></td>
                    <td><?= esc($lo['nama_kegiatan']) ?></td>
                    <td style="text-align:center;"><?= $lo['tanggal_pelaksanaan'] ? date('d/m/Y', strtotime($lo['tanggal_pelaksanaan'])) : '-' ?></td>
                    <td style="text-align:center;"><?= esc($lo['jumlah_peserta']) ?></td>
                    <td>
                        <?php if(!empty($lo['file_laporan'])): ?>- <a href="<?= base_url($lo['file_laporan']) ?>">Laporan</a><br><?php endif; ?>
                        <?php if(!empty($lo['dokumentasi'])): ?>- <a href="<?= base_url($lo['dokumentasi']) ?>">Dokumentasi</a><?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- 5. DOKUMEN OSIS -->
    <div class="section-title">5. Ringkasan OSIS (Dokumen OSIS)</div>
    <?php if(empty($dokumen_osis)): ?>
        <p><em>Tidak ada data dokumen OSIS.</em></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Nama Dokumen</th>
                    <th width="25%">Jenis Dokumen</th>
                    <th width="15%">Periode</th>
                    <th width="20%">Akses Data (Link)</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($dokumen_osis as $do): ?>
                <tr>
                    <td style="text-align:center;"><?= $no++ ?></td>
                    <td><?= esc($do['nama_dokumen']) ?></td>
                    <td><?= esc($do['jenis_dokumen']) ?></td>
                    <td style="text-align:center;"><?= esc($do['periode']) ?></td>
                    <td>
                        <?php if(!empty($do['file_path'])): ?>
                            <a href="<?= base_url($do['file_path']) ?>">Buka Dokumen</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="footer">
        <div class="signature">
            <p>Mengetahui,</p>
            <p>Kepala Sekolah</p>
            <br><br><br>
            <div class="name">( ........................................ )</div>
        </div>
    </div>
    
    </div> <!-- End pdf-wrapper -->
    
    <!-- Load html2pdf.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        // Otomatis convert ke PDF dan download saat halaman dimuat
        window.onload = function() {
            const element = document.getElementById('pdf-wrapper');
            const opt = {
                margin:       10,
                filename:     'Laporan_Komprehensif.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
            };

            html2pdf().set(opt).from(element).save().then(function() {
                // Tutup tab secara otomatis setelah didownload
                setTimeout(function() { window.close(); }, 500);
            });
        };
    </script>
</body>
</html>
