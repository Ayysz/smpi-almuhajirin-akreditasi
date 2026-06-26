<?php
// Force development mode for debugging
$_SERVER['CI_ENVIRONMENT'] = 'development';
ini_set('display_errors', '1');
error_reporting(E_ALL);

set_exception_handler(function($e) {
    echo "<h1>CRITICAL ERROR CAUGHT</h1>";
    echo "<pre>" . $e->getMessage() . "</pre>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    exit;
});
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    echo "<h1>CRITICAL ERROR CAUGHT</h1>";
    echo "<pre>[$errno] $errstr in $errfile on line $errline</pre>";
    exit;
});

// Forward Vercel requests to normal index.php
require __DIR__ . '/../public/index.php';
