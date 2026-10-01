<?php
    define('HOST', 'localhost');
    define('USER', 'root');
    define('PASS', '');
    define('BASE', 'pit');

    $conn = new mysqli(HOST,USER,PASS,BASE);
    $conn->set_charset('utf8mb4');

    require_once(__DIR__ . '/seguranca.php');
?>
