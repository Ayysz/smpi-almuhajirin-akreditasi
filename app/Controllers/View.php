<?php

namespace App\Controllers;

class View extends BaseController
{
    public function kegiatan($filename)
    {
        $filepath = FCPATH . 'uploads/kegiatan/' . $filename;
        
        if (!file_exists($filepath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        // Deteksi tipe file
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $filepath);
        finfo_close($finfo);
        
        // Set header
        header('Content-Type: ' . $mime);
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($filepath));
        
        // Baca dan output file
        readfile($filepath);
        exit;
    }
}