<?php

if (!function_exists('get_file_url')) {
    /**
     * Generate URL untuk view/download file dari writable/uploads
     * 
     * @param string $file_path Path dari database (contoh: uploads/prestasi/file.pdf)
     * @param string $action 'view' atau 'download'
     * @return string URL lengkap
     */
    function get_file_url($file_path, $action = 'view')
    {
        if (empty($file_path)) {
            return '';
        }
        
        // Parse path: uploads/prestasi/file.pdf -> [prestasi, file.pdf]
        $parts = explode('/', $file_path);
        
        if (count($parts) >= 3) {
            $folder = $parts[1];   // prestasi
            $filename = $parts[2]; // file.pdf
            
            return base_url($action . '/' . $folder . '/' . $filename);
        }
        
        return '';
    }
}

if (!function_exists('file_exists_in_uploads')) {
    /**
     * Cek apakah file ada di writable/uploads
     */
    function file_exists_in_uploads($file_path)
    {
        if (empty($file_path)) {
            return false;
        }
        
        $full_path = WRITEPATH . $file_path;
        return file_exists($full_path);
    }
}