<?php
ini_set('display_errors', 0);
$host = "localhost";
$user = "root";
$pass = "";
$db = "g5tabs"
if (session_status() != PHP_SESSION_ACTIVE) {
    session_name('G5TabSes');
    ini_set('session.gc_probability', 1);
    ini_set('session.gc_divisor', 100);
    ini_set('session.gc_maxlifetime', 7200);
    session_set_cookie_params(7200);
}
?>