<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    require("../config.php");
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed");
    }
    session_start();
    include "../styleManager.php";
    $privSet = false;
    if (!isset($_GET['id'])) {
        echo "<h1>Nie podano ID.</h1>";
        exit;
    }
    if (empty($_GET['id'])) {
        echo "<h1>Nie podano ID.</h1>";
        exit;
    }
    $id = $_GET['id'];
    if (!is_numeric($id)) {
        echo "<h1>Podano błędne ID.</h1>";
        exit;
    }
    if (isset($_SESSION["zalogowany"]) && $_SESSION["zalogowany"] == true) {
        $sql = "SELECT id FROM tabs WHERE id_u = ".$_SESSION['id']." AND id = ".$id;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $privSet = true;
        }
    }
    session_write_close();
    $tab = $conn->query("SELECT dane FROM tabs WHERE id = ".$id);
    $verfication = true;
    if ($tab->num_rows > 0) {
        $dane = $tab->fetch_assoc()["dane"];
        $json = json_decode($dane, true);
        if (!isset($json["public"]) && !$privSet) {
            $verfication = false;
            echo getTab1Element("Ten tab nie ma poprawnie skonfigurowanej publiczności", "---");
        } else if (!$json["public"] && !$privSet) {
            $verfication = false;
            echo getTab1Element("Ten tab jest prywatny", "---");
        }
        if ($verfication) {
            echo "<title>".$json["name"]." - G5Tab</title>";
        } else {
            echo "<title>Prywatny Tab - G5Tab</title>";
        }
    } else {
        echo "<title>G5Tab</title>";
    }
    
    ?>
    <link rel="stylesheet" href="tabsStyle.css">
    <script src="tabs.js" defer></script>
</head>
<body>
<div id="pack">
         <div id="navpack">
         <div id="nav">
             <div id="logo">
                 <a href="https://kubag5.pl/G5Tabs">
                     <h1 id="logo-text">G5Tabs</h1>
                 </a></div>
             <div id="wyszukiwarka">
            <form onsubmit='handleSubmitSearch(event)'>
                 <input name="szukaj" id="szukaj" type="text" placeholder="Szukaj...">
             </form> </div>
             <div style="clear: both"></div>
         </div>
         </div>
         <div id="content">   
            <?php
            global $id;        
            global $conn;
            global $privSet;
            global $verfication;
            $tab = $conn->query("SELECT dane FROM tabs WHERE id = ".$id);
             if ($tab->num_rows > 0) {
                $dane = $tab->fetch_assoc()["dane"];
                $json = json_decode($dane, true);
                if ($verfication) {
                    $nazwa = $json["name"];
                    echo "<h1>".$nazwa."</h1>";
                    echo '<div id="tabs1">';
                    $lista = $json["daty"];
                    foreach($lista as $tab) {
                        echo getTab1Element(htmlspecialchars($tab['text']), htmlspecialchars($tab['data']));
                    }
                    echo "</div>";
                }
            } else {
                echo getTab1Element("Ten Tab nie istnieje", "---");
            }
            $result = $conn->query("SELECT users.username AS username FROM tabs, users WHERE tabs.id = ".$id." AND users.id = tabs.id_u");
            if ($result->num_rows > 0) {
                $username = $result->fetch_assoc()["username"];
                echo "<div class='authorInfo'><br/><h2>Stworzone przez: ".$username."</h2></div>";
            }
           
            $conn->close();
            function getTab1Element($text, $date) {
                return '
                <div class="tab1-element">
                <div class="tab1-subElement1">'.$text.'</div>
                <div class="tab1-subElement2">'.$date.'</div>
                </div>';
            }
            ?>
         </div>
</div>
</body>
</html>