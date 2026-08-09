<div class="sidebar bg-white border-end">
    <div class="list-group list-group-flush">
        <div class="sidebar-section px-3">Menu Utama</div>
        <a href="<?= base_url('dashboard') ?>" class="list-group-item list-group-item-action border-0 <?= (uri_string() == 'dashboard') ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        
        <?php 
            $role = session()->get('role');
            $allowedKegiatan = ['admin','waka_kesiswaan','guru'];
            if (in_array($role, $allowedKegiatan)):
        ?>
        <a href="<?= base_url('kegiatan') ?>" class="list-group-item list-group-item-action border-0 <?= (uri_string() == 'kegiatan' || strpos(uri_string(), 'kegiatan/') !== false) ? 'active' : '' ?>">
            <i class="bi bi-calendar-event"></i> Kegiatan Kesiswaan
        </a>
        <?php endif; ?>
        
        <?php if (in_array($role, ['admin','waka_kesiswaan','guru'])): ?>
        <a href="<?= base_url('prestasi') ?>" class="list-group-item list-group-item-action border-0 <?= (strpos(uri_string(), 'prestasi') !== false) ? 'active' : '' ?>">
            <i class="bi bi-trophy"></i> Prestasi Siswa
        </a>
        <?php endif; ?>
        
        <!-- Menu OSIS dengan submenu (Admin, Waka, dan Guru) -->
        <?php 
            $allowedOsis = ['admin', 'waka_kesiswaan', 'guru'];
            if (in_array($role, $allowedOsis)):
        ?>
        <div class="sidebar-section px-3">Organisasi</div>
        <div class="list-group-item border-0 p-0">
            <a class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center <?= (strpos(uri_string(), 'osis') !== false) ? 'active' : '' ?>" 
               href="#collapseOsis" role="button" aria-expanded="<?= (strpos(uri_string(), 'osis') !== false) ? 'true' : 'false' ?>">
                <div>
                    <i class="bi bi-people"></i> OSIS
                </div>
                <i class="bi bi-chevron-down"></i>
            </a>
            <div class="osis-submenu <?= (strpos(uri_string(), 'osis') !== false) ? 'is-open' : '' ?>" id="collapseOsis">
                <div class="list-group list-group-flush border-0">
                    <a href="<?= base_url('osis/program-kerja') ?>" class="list-group-item list-group-item-action border-0 ps-4 <?= (uri_string() == 'osis/program-kerja' || strpos(uri_string(), 'osis/program-kerja') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-clipboard-check"></i> Program Kerja
                    </a>
                    <a href="<?= base_url('osis/laporan-kegiatan') ?>" class="list-group-item list-group-item-action border-0 ps-4 <?= (uri_string() == 'osis/laporan-kegiatan' || strpos(uri_string(), 'osis/laporan-kegiatan') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-journal-check"></i> Laporan Kegiatan
                    </a>
                    <a href="<?= base_url('osis/dokumen') ?>" class="list-group-item list-group-item-action border-0 ps-4 <?= (uri_string() == 'osis/dokumen' || strpos(uri_string(), 'osis/dokumen') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-file-earmark-text"></i> Dokumen OSIS
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if (in_array(session()->get('role'), ['admin', 'waka_kesiswaan', 'kepala_sekolah'])): ?>
        <div class="sidebar-section px-3">Monitoring</div>
        <a href="<?= base_url('laporan') ?>" class="list-group-item list-group-item-action border-0 <?= (uri_string() == 'laporan' || strpos(uri_string(), 'laporan/') !== false) ? 'active' : '' ?>">
            <i class="bi bi-file-bar-graph"></i> Laporan
        </a>
        <?php endif; ?>
        
        <?php if (session()->get('role') == 'admin'): ?>
        <div class="sidebar-section px-3">Manajemen Sistem</div>
        <a href="<?= base_url('user') ?>" class="list-group-item list-group-item-action border-0 <?= (strpos(uri_string(), 'user') !== false) ? 'active' : '' ?>">
            <i class="bi bi-person-gear"></i> Kelola User
        </a>
        <?php endif; ?>
    </div>
</div>

<div class="content-wrapper">
