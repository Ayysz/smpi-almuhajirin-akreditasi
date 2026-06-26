<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-pencil-square"></i> Edit Kegiatan</h2>
        <a href="<?= base_url('kegiatan') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error_list')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle"></i> <strong>Periksa kembali form Anda:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach (session()->getFlashdata('error_list') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('kegiatan/update/' . $kegiatan['id_kegiatan']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_kegiatan" value="<?= old('nama_kegiatan', $kegiatan['nama_kegiatan']) ?>" required>
                        </div>
                    </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenis Kegiatan <span class="text-danger">*</span></label>
                                <select class="form-select" name="jenis_kegiatan" id="jenis_kegiatan" required onchange="toggleFileFields()">
                                    <option value="">Pilih Jenis</option>
                                    <option value="KARAKTER" <?= old('jenis_kegiatan', $kegiatan['jenis_kegiatan']) == 'KARAKTER' ? 'selected' : '' ?>>Karakter / Pembinaan Karakter</option>
                                    <option value="KEAGAMAAN" <?= old('jenis_kegiatan', $kegiatan['jenis_kegiatan']) == 'KEAGAMAAN' ? 'selected' : '' ?>>Keagamaan</option>
                                    <option value="EKSTRAKURIKULER" <?= old('jenis_kegiatan', $kegiatan['jenis_kegiatan']) == 'EKSTRAKURIKULER' ? 'selected' : '' ?>>Ekstrakurikuler</option>
                                    <option value="LAINNYA" <?= old('jenis_kegiatan', $kegiatan['jenis_kegiatan']) == 'LAINNYA' ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>
                        </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_mulai" value="<?= old('tanggal_mulai', $kegiatan['tanggal_mulai']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="tanggal_selesai" value="<?= old('tanggal_selesai', $kegiatan['tanggal_selesai']) ?>">
                            <small class="text-muted">Kosongkan jika kegiatan 1 hari</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tempat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tempat" value="<?= old('tempat', $kegiatan['tempat']) ?>" placeholder="Contoh: Aula Sekolah" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tahun_ajaran" value="<?= old('tahun_ajaran', $kegiatan['tahun_ajaran']) ?>" placeholder="Contoh: 2024/2025" required>
                        </div>
                    </div>
                </div>



                <div id="file-fields">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" id="label-absensi">File Absensi <span class="text-danger" id="req-absensi" style="display: none;">*</span></label>
                                <?php if (!empty($kegiatan['file_absensi'])): ?>
                                    <div class="mb-1 small">
                                        <a href="<?= base_url($kegiatan['file_absensi']) ?>" target="_blank" class="text-primary">
                                            <i class="bi bi-file-earmark-check"></i> Lihat File Saat Ini
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" name="file_absensi" id="file_absensi" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Format: PDF, JPG, PNG. Maks: 5MB. Kosongkan jika tidak ingin mengganti.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" id="label-foto">Foto Kegiatan <span class="text-danger" id="req-foto">*</span></label>
                                <?php if (!empty($kegiatan['foto_kegiatan'])): ?>
                                    <div class="mb-1 small">
                                        <a href="<?= base_url($kegiatan['foto_kegiatan']) ?>" target="_blank" class="text-primary">
                                            <i class="bi bi-image"></i> Lihat Foto Saat Ini
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" name="foto_kegiatan" id="foto_kegiatan" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Format: PDF, JPG, PNG. Maks: 5MB. Kosongkan jika tidak ingin mengganti.</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 dynamic-field" id="div-rundown" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Rundown Kegiatan <span class="text-danger" id="req-rundown">*</span></label>
                                <?php if (!empty($kegiatan['rundown_kegiatan'])): ?>
                                    <div class="mb-1 small">
                                        <a href="<?= base_url($kegiatan['rundown_kegiatan']) ?>" target="_blank" class="text-primary">
                                            <i class="bi bi-list-task"></i> Lihat Rundown Saat Ini
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" name="rundown_kegiatan" id="rundown_kegiatan" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Format: PDF, JPG, PNG. Maks: 5MB. Kosongkan jika tidak ingin mengganti.</small>
                            </div>
                        </div>
                        <div class="col-md-6 dynamic-field" id="div-sk" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Surat Keputusan / SK <span class="text-danger" id="req-sk">*</span></label>
                                <?php if (!empty($kegiatan['surat_keterangan'])): ?>
                                    <div class="mb-1 small">
                                        <a href="<?= base_url($kegiatan['surat_keterangan']) ?>" target="_blank" class="text-primary">
                                            <i class="bi bi-file-earmark-text"></i> Lihat SK Saat Ini
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" name="surat_keterangan" id="surat_keterangan" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Format: PDF, JPG, PNG. Maks: 5MB. Kosongkan jika tidak ingin mengganti.</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 dynamic-field" id="div-laporan" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Laporan Kegiatan (Opsional)</label>
                                <?php if (!empty($kegiatan['proposal_laporan'])): ?>
                                    <div class="mb-1 small">
                                        <a href="<?= base_url($kegiatan['proposal_laporan']) ?>" target="_blank" class="text-primary">
                                            <i class="bi bi-journal-text"></i> Lihat Laporan Saat Ini
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" name="proposal_laporan" id="proposal_laporan" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Format: PDF, JPG, PNG. Maks: 5MB. Kosongkan jika tidak ingin mengganti.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save"></i> Perbarui Kegiatan
                    </button>
                    <a href="<?= base_url('kegiatan') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleFileFields() {
    const jenis = document.getElementById('jenis_kegiatan').value.toUpperCase();
    
    // Elements
    const divRundown = document.getElementById('div-rundown');
    const divSk = document.getElementById('div-sk');
    const divLaporan = document.getElementById('div-laporan');
    
    const reqRundown = document.getElementById('req-rundown');
    const reqSk = document.getElementById('req-sk');
    const reqFoto = document.getElementById('req-foto');
    const reqAbsensi = document.getElementById('req-absensi');
    
    const labelAbsensi = document.getElementById('label-absensi');
    const labelFoto = document.getElementById('label-foto');
    
    // Reset
    divRundown.style.display = 'none';
    divSk.style.display = 'none';
    divLaporan.style.display = 'none';
    
    if (reqFoto) reqFoto.style.display = 'inline';
    if (reqAbsensi) reqAbsensi.style.display = 'none';
    
    // In edit mode, we don't force required if file already exists
    const hasAbsensi = <?= !empty($kegiatan['file_absensi']) ? 'true' : 'false' ?>;
    const hasFoto = <?= !empty($kegiatan['foto_kegiatan']) ? 'true' : 'false' ?>;
    const hasRundown = <?= !empty($kegiatan['rundown_kegiatan']) ? 'true' : 'false' ?>;
    const hasSk = <?= !empty($kegiatan['surat_keterangan']) ? 'true' : 'false' ?>;
    const hasLaporan = <?= !empty($kegiatan['proposal_laporan']) ? 'true' : 'false' ?>;

    if (jenis === '') return;

    if (jenis === 'KARAKTER') {
        labelAbsensi.childNodes[0].nodeValue = 'Absensi Siswa ';
        if (reqFoto) labelFoto.childNodes[0].nodeValue = 'Foto Kegiatan ';
        divRundown.style.display = 'block';
        divLaporan.style.display = 'block';
        
        if (reqAbsensi) reqAbsensi.style.display = hasAbsensi ? 'none' : 'inline';
        if (reqRundown) reqRundown.style.display = hasRundown ? 'none' : 'inline';
        if (reqFoto) reqFoto.style.display = hasFoto ? 'none' : 'inline';

    } else if (jenis === 'KEAGAMAAN') {
        labelAbsensi.childNodes[0].nodeValue = 'Absensi Peserta ';
        if (reqFoto) labelFoto.childNodes[0].nodeValue = 'Foto Kegiatan ';
        divRundown.style.display = 'block';
        divSk.style.display = 'block';
        divLaporan.style.display = 'block';
        
        if (reqAbsensi) reqAbsensi.style.display = hasAbsensi ? 'none' : 'inline';
        if (reqRundown) reqRundown.style.display = hasRundown ? 'none' : 'inline';
        if (reqSk) reqSk.style.display = hasSk ? 'none' : 'inline';
        if (reqFoto) reqFoto.style.display = hasFoto ? 'none' : 'inline';

    } else if (jenis === 'EKSTRAKURIKULER') {
        labelAbsensi.childNodes[0].nodeValue = 'Absensi ';
        if (reqFoto) labelFoto.childNodes[0].nodeValue = 'Foto Kegiatan ';
        divLaporan.style.display = 'block';
        
        if (reqAbsensi) reqAbsensi.style.display = hasAbsensi ? 'none' : 'inline';
        if (reqFoto) reqFoto.style.display = hasFoto ? 'none' : 'inline';
        
    } else if (jenis === 'LAINNYA') {
        labelAbsensi.childNodes[0].nodeValue = 'File Absensi ';
        if (reqFoto) labelFoto.childNodes[0].nodeValue = 'Foto Kegiatan ';
        divRundown.style.display = 'block';
        divSk.style.display = 'block';
        divLaporan.style.display = 'block';
        
        if (reqAbsensi) reqAbsensi.style.display = 'none';
        if (reqRundown) reqRundown.style.display = 'none';
        if (reqSk) reqSk.style.display = 'none';
        if (reqFoto) reqFoto.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleFileFields();
});
</script>