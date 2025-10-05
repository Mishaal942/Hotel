<?php
/* DB Connection: MySQL (PDO) */
$DB_HOST = 'localhost';
$DB_NAME = 'dbvau1rehjwocd';
$DB_USER = 'uppbmi0whibtc';
$DB_PASS = 'bjgew6ykgu1v';

try {
    $pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (Exception $e) {
    die("Database Connection Failed: " . htmlspecialchars($e->getMessage()));
}

/* Helper: clean string for output */
function e($str) { return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8'); }

/* Helper: date diff in nights (>=1) */
function nights_between($check_in, $check_out) {
    $ci = strtotime($check_in);
    $co = strtotime($check_out);
    if ($ci === false || $co === false || $co <= $ci) return 1;
    $n = (int)ceil(($co - $ci) / (60*60*24));
    return max(1, $n);
}
