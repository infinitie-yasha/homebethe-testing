<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
const CI_VERSION = '3.1.13';
$autoload = __DIR__ . '/vendor/autoload.php';


if (file_exists($autoload)) {
    require_once $autoload;

    if (class_exists('\CodeIgniter3\Bootstrap')) {
        \CodeIgniter3\Bootstrap::init();
    } else {
        echo 'Bootstrap class not found in autoload.';
        exit;
    }
}
