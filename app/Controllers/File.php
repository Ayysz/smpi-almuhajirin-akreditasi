<?php

namespace App\Controllers;

class File extends BaseController
{
    public function view($folder, $subfolder, $filename)
    {
        $filepath = WRITEPATH . $folder . '/' . $subfolder . '/' . $filename;
        
        if (!file_exists($filepath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan');
        }
        
        // Deteksi MIME type
        $mime = mime_content_type($filepath);
        
        // Set header untuk preview di browser
        return $this->response
                    ->setHeader('Content-Type', $mime)
                    ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
                    ->setBody(file_get_contents($filepath));
    }
    
    public function download($folder, $subfolder, $filename)
    {
        $filepath = WRITEPATH . $folder . '/' . $subfolder . '/' . $filename;
        
        if (!file_exists($filepath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan');
        }
        
        // Force download
        return $this->response->download($filepath, null);
    }
}