<?php


require("config.php");
$conn = new mysqli($host, $user, $pass, $db);
session_start();
if (!isset($_GET['action'])) {
    sendReturn("Nie wprowadzono wymaganych danych");
}
$action = $_GET['action'];
if (!$conn) {
    sendReturn("BŁĄD: Serwerowi nie udało połączyć się z baza danych.");
}

// LOGIN

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

    // sendReturn("Opcja rejestracji została wyłączona przez administratora.");

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

if (!isset($_SESSION["zalogowany"])) {
    sendReturn("Musisz być zalogowany aby to wykonać!");
}
if ($_SESSION["zalogowany"] == false) {
    sendReturn("Musisz być zalogowany aby to wykonać!");
}


// SAVE 
if ($action == 2) { 
    if (!isset($_GET['A01'], $_GET['A02'])) {
        sendReturn("Nie wprowadzono wymaganych danych");
    }
    if (empty($_GET['A01']) || empty($_GET['A02'])) {  
        sendReturn("Nie wprowadzono wymaganych danych");
    }
    $id = $_GET['A01'];
    $json = verifyJSON($_GET['A02']);
    $sql = "UPDATE tabs SET dane = ? WHERE id = ? AND id_u = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssi", $json, $id, $_SESSION['id']);
        if ($stmt->execute()) {
            sendReturn("Wykonano!");
        } else {
            sendReturn("Wystąpił błąd, nie udało się zapisać tab'a!");
        }
        $stmt->close();
    } else {
        sendReturn("Wystąpił błąd, nie udało się zapisać tab'a!");
    }
}

if ($action == 3) { 
    if (!isset($_GET['A01'])) {
        sendReturn("Nie wprowadzono wymaganych danych");
    }
    if (empty($_GET['A01'])) {  
        sendReturn("Nie wprowadzono wymaganych danych");
    }
    $id = $_GET['A01'];
    $sql = "DELETE FROM tabs WHERE id = ? AND id_u = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("si", $id, $_SESSION['id']);
        if ($stmt->execute()) {
            sendReturn("Wykonano!");
        } else {
            sendReturn("Wystąpił błąd, nie udało się zapisać tab'a!");
        }
        $stmt->close();
    } else {
        sendReturn("Wystąpił błąd, nie udało się zapisać tab'a!");
    }
}

if ($action == 4) { 
    $stmt_count = $conn->prepare("SELECT COUNT(*) as count FROM tabs WHERE id_u = ?");
    $stmt_count->bind_param("i", $_SESSION['id']);
    $stmt_count->execute();
    $result = $stmt_count->get_result();
    $row = $result->fetch_assoc();
    $existing_tabs_count = $row['count'];
    if ($existing_tabs_count >= 10) {
        sendReturn("Osiągnąłeś limit (10 zakładek), usuń jakąś aby dodać kolejną!", 2);
     }
    $default = '{"name": "Nowy Tab", "public": false, "type": 1, "daty": [{"text": "przykladowy box", "data": "1 STY 2024"}]}';
    $sql = "INSERT INTO tabs(id_u, dane) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $_SESSION['id'], $default);
    if ($stmt->execute()) {
        sendReturn("Dodano!");
    } else {
        sendReturn("Nieoczekiwany Błąd");
    }
}

if ($action == 5) { 
    $sql = "UPDATE users SET id_st = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!isset($_GET['A01'])) {
        sendReturn("Nie wprowadzono wymaganych danych");
    }
    if (empty($_GET['A01'])) {  
        sendReturn("Nie wprowadzono wymaganych danych");
    }
    $sid = $_GET['A01'];
    $stmt->bind_param("ii", $sid ,$_SESSION['id'] );
    if ($stmt->execute()) {
        sendReturn("Zmieniono styl!");
    } else {
        sendReturn("Nieoczekiwany Błąd");
    }
}



function verifyJSON($jsonData) {
    try {
        $data = json_decode($jsonData, true);
        if (!is_array($data)) {
            throw new Exception("Nie udało się zdekodować danych JSON");
        }
        $usefulKeys = ["type", "name", "daty", "public"];
        $unusedKeys = array_diff(array_keys($data), $usefulKeys);
        foreach ($unusedKeys as $key) {
            unset($data[$key]);
        }
        if (isset($data['daty']) && is_array($data['daty'])) {
            foreach ($data['daty'] as &$entry) {
                $validKeys = ["data", "text"];
                $entry = array_intersect_key($entry, array_flip($validKeys));
             }
        }

        if (!isset($data['public'], $data['type'], $data['name'])) {
            sendReturn("Nie udało się zweryfikować JSON wysłanego przez twój komputer, Tab nie został zapisany!");
        }

        if (!is_numeric($data['type'])) {
            sendReturn("Nie udało się zweryfikować JSON wysłanego przez twój komputer, Tab nie został zapisany!");
        }
        if ((int)$data['type'] < 0 || (int)$data['type'] > 999) {
            sendReturn("Nie udało się zweryfikować JSON wysłanego przez twój komputer, Tab nie został zapisany!");
        }

        if (strlen($data['name']) > 75 && strlen($data['name']) < 2) {
            sendReturn("Nie udało się zweryfikować JSON wysłanego przez twój komputer, Tab nie został zapisany!");
        }

        if (!is_bool($data['public'])) { 
             sendReturn("Nie udało się zweryfikować JSON wysłanego przez twój komputer, Tab nie został zapisany!");
        } 

        $updatedJsonData = json_encode($data, JSON_PRETTY_PRINT);
        return $updatedJsonData;
    } catch (Exception $e) {
        sendReturn("Nie udało się zweryfikować JSON wysłanego przez twój komputer, Tab nie został zapisany!");
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
    session_write_close();
    exit;
}


sendReturn("Wystąpił nie oczekiwany bład");