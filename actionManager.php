<?php
ini_set('display_errors', 0);
$action = $_GET['action'];
// LOGIN
if ($action == 0) {
$login = $_GET['A01'];
$pass = $_GET['A02'];
sendReturn("Wykonanie loginu dla: ".$login, 1);
}
// REGISTER
if ($action == 1) {
    $login = $_GET['A01'];
    $pass = $_GET['A02'];
    sendReturn("Wykonanie register dla: ".$login, 2);
   
}


function sendReturn($info, $javascript) {
    $response = [
        'info' => $info,
        'js' => $javascript
    ];
    echo json_encode($response);
    exit;
}

sendReturn("Wystąpił nie oczekiwany bład", -1);