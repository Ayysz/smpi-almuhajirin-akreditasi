<?php
// Force development mode for debugging
$_SERVER['CI_ENVIRONMENT'] = 'development';

// Forward Vercel requests to normal index.php
require __DIR__ . '/../public/index.php';
