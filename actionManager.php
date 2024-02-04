<?php
// ini_set('display_errors', 0);

$conn = new mysqli("localhost", "root", "", "g5tabs");
if (!isset($_GET['action'])) {
    sendReturn("Nie wprowadzono wymaganych danych");
}
$action = $_GET['action'];
if (!$conn) {
    sendReturn("BŁĄD: Serwerowi nie udało połączyć się z baza danych.");
}

// LOGIN
session_start();
if ($action == 0) {
if (!isset($_GET['A01'], $_GET['A02'])) {
sendReturn("Nie wprowadzono wymaganych danych");
}
if (empty($_GET['A01']) || empty($_GET['A02'])) {  
sendReturn("Nie wprowadzono wymaganych danych");
}

    $login = $_GET['A01'];
    $pass = $_GET['A02'];
    if ($stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ?')) {
        $stmt->bind_param('s', $login);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows>0) {
            $stmt->bind_result($userId, $dbpass);
            $stmt->fetch();
           if (password_verify($pass, $dbpass)) {
            session_regenerate_id();
            $_SESSION['zalogowany'] = TRUE;
	    	$_SESSION['name'] = $login;
	    	$_SESSION['id'] = $userId;
            session_write_close();
            sendReturn("Wprowadzone dane są poprawne. Zaraz nastąpi przekierowanie!", 0);
           } else {
            sendReturn("Wprowadzone dane są nieprawidłowe. Logowanie nie udane.");
           }
        } else {
            sendReturn("Wprowadzone dane są nieprawidłowe. Logowanie nie udane.");
        }
        $stmt->close();
    } else {
        sendReturn("Wystąpił nieoczekiwany błąd podczas rejestracji.");
    }
}


// REGISTER
if ($action == 1) {

    sendReturn("Opcja rejestracji została wyłączona przez administratora. Przepraszamy za utrudnienia!");

if (!isset($_GET['A01'], $_GET['A02'])) {
    sendReturn("Nie wprowadzono wymaganych danych");
}
if (empty($_GET['A01']) || empty($_GET['A02'])) {  
    sendReturn("Nie wprowadzono wymaganych danych");
}

    $login = $_GET['A01'];
    $pass = $_GET['A02']; 
    if ($stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ?')) {
        $stmt->bind_param('s', $login);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows>0) {
            sendReturn("Taki użytkownik już istnieje");
        } else {
            if ($stmt = $conn->prepare('INSERT INTO users(username,password) VALUES (?,?)')) {
                $hashpass = password_hash($pass, PASSWORD_DEFAULT);
                $stmt->bind_param('ss', $login, $hashpass);
                $stmt->execute();
                sendReturn("Pomyślnie zarejestrowano. Teraz możesz sie zalogować!", 1);
            } else {
                sendReturn("Wystąpił nieoczekiwany błąd podczas rejestracji.");
            }
        }
        $stmt->close();
    } else {
        sendReturn("Wystąpił nieoczekiwany błąd podczas rejestracji.");
    }
}


function sendReturn($info = "null", $javascript = -1) {
    global $conn;
    $response = [
        'info' => $info,
        'js' => $javascript
    ];
    $conn->close();
    echo json_encode($response);
    exit;
}


sendReturn("Wystąpił nie oczekiwany bład");