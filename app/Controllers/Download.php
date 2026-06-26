<?php

namespace App\Controllers;

class Download extends BaseController
{
    public function file($folder = '', $filename = '')
    {
        $filepath = FCPATH . 'uploads/' . $folder . '/' . $filename;
        
        if (!file_exists($filepath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan');
        }
        
        // Set headers untuk download
        return $this->response->download($filepath, null);
    }
    
    public function view($folder = '', $filename = '')
    {
        $filepath = FCPATH . 'uploads/' . $folder . '/' . $filename;
        
        if (!file_exists($filepath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan');
        }
        
        // Set headers untuk view di browser
        $mime = mime_content_type($filepath);
        
        return $this->response
                    ->setHeader('Content-Type', $mime)
                    ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
                    ->setBody(file_get_contents($filepath));
    }
    
    public function serve($path)
    {
        $filepath = FCPATH . 'uploads/' . $path;
        
        if (!file_exists($filepath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan');
        }
        
        $mime = mime_content_type($filepath);
        
        return $this->response
                    ->setHeader('Content-Type', $mime)
                    ->setHeader('Content-Disposition', 'inline; filename="' . basename($filepath) . '"')
                    ->setBody(file_get_contents($filepath));
    }
}