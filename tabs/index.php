<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G5Tabs</title>
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
         <div id="tabs1">
            <?php
            global $id;        
            global $conn;
            global $privSet;
             $result = $conn->query("SELECT dane FROM tabs WHERE id = ".$id);
             if ($result->num_rows > 0) {
                $dane = $result->fetch_assoc()["dane"];
                $json = json_decode($dane, true);
                $verfication = true;
                if (!isset($json["public"]) && !$privSet) {
                    $verfication = false;
                    echo getTab1Element("Ten tab nie ma poprawnie skonfigurowanej publiczności", "---");
                } else if (!$json["public"] && !$privSet) {
                    $verfication = false;
                    echo getTab1Element("Ten tab jest prywatny", "---");
                }
                if ($verfication) {
                    $lista = $json["daty"];
                    foreach($lista as $tab) {
                        echo getTab1Element(htmlspecialchars($tab['text']), htmlspecialchars($tab['data']));
                    }
                }
            } else {
                echo getTab1Element("Ten Tab nie istnieje", "---");
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
            <div class="authorInfo"><br/>
                <!-- <h2>Stworzone przez: xxx</h2> -->
            </div>
         </div>
</div>
</body>
</html>