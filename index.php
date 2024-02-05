<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G5Tabs</title>
    <link rel="stylesheet" href="style.css">
    <script src="core.js" defer></script>
    <meta name="description" content="Używaj G5Tabs do tworzenia stron informacyjnych, kalendarzy i innych rzeczy!"> 
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
            function check() {
                session_start();
                if (!isset($_SESSION['zalogowany'])) {
                    notlogged();
                } else {
                    if ($_SESSION['zalogowany']) {
                        logged();
                    } else {
                        notlogged();
                    }
                }
                session_write_close();
            }

            function notlogged() {
                echo "
                <div id='loginpanel'>  
                <h1>Witaj w G5Tabs</h1>
                <br/>
                    <form id='loginform' style='display: none;' onsubmit='handleSubmitLogin(event)'> 
                    <p>Oto panel logowania do G5Tabs:</p><br/>
                        <label for='login'>Login: </label><br/><br/>
                        <input type='text' name='login' id='login' class='LRGI' maxlength='50'> <br/><br/>
                        <label for='pass'>Hasło: </label><br/><br/>
                        <input type='password' name='pass' id='password' class='LRGI'><br/><br/><br/>
                        <input type='submit' value='Zaloguj się' class='LRGBI' id='LRGBT1'>
                    </form>
                    <form id='registerform' style='display: none;' onsubmit='handleSubmitRegister(event)'> 
                    <p>Oto panel rejestracji do G5Tabs:</p><br/>
                        <label for='login'>Login: </label><br/><br/>
                        <input type='text' name='login' id='login' class='LRGI' maxlength='50'> <br/><br/>
                        <label for='pass'>Hasło: </label><br/><br/>
                        <input type='password' name='pass' id='password' class='LRGI'><br/><br/>
                        <label for='pass2'>Powtórz Hasło: </label><br/><br/>
                        <input type='password' name='pass2' id='password' class='LRGI'><br/><br/><br/>
                        <input type='submit' value='Zarejestruj się' class='LRGBI' id='LRGBT2'>
                    </form><br/><br/>
                    <button onclick='changeLRG();' id='LRGBT' class='LRGBI' >Chce sie zarejestrować</button>
                    <br/><br/><div id='information-box'> </div>
                </div>
             
                <br/><br/><hr/><br/>
                <h1>Publiczne projekty użytkowników</h1> <br/>
                <div class='tab-list'>
                    - - - -
                </div>
                ";
                
            }

            function logged() { 
                require_once("../config.php");
                $conn = new mysqli($host, $user, $pass, $db);
                if ($conn->connect_error) {
                    die("Connection failed");
                }
                if (isset($_GET['edit'])) {
                    $id = $_GET['edit'];
                    if (!is_numeric($id)) {
                        echo "<h1>Podano błędne ID.";
                    } else {
                        $sql = "SELECT dane, id FROM tabs WHERE id_u = ".$_SESSION['id']." AND id = ".$id;
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $dane = $result->fetch_assoc()["dane"];
                            echo "wczytywanie...";
                            echo "<script defer>
                            let projectID = ".$id."
                            let json = ".$dane."; 
                            function opener() {
                                setTimeout(() => {
                                  try {
                                    editMode();
                                  } catch (error) {
                                    opener();
                                  }
                                }, 500);
                              }opener();</script>";
                        } else {
                            echo "<h1>Nie można uzyskać tej zakładki w trybie edycji. spróbuj zalogowac się na inne konto</h1>";
                        }
                    }
                } else {
                    $sql = "SELECT dane, id FROM tabs WHERE id_u = ".$_SESSION['id'];
                    $result = $conn->query($sql);
                    echo "
                <h2>Twoje Taby:</h2>
                <div class='projectList'> ";
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $dane = $row["dane"];
                        $json = json_decode($dane, true);
                        $name = $json["name"];
                        echo createProjectDiv($name, $row['id']);
                    }
                }
                echo "</div>";
                echo "<br/><a onclick='addTab()'>Dodaj zakładkę</a><br/><br/>";
                echo "<br/><a href='logout.php'>Wyloguj</a>";
                }
                $conn->close();
            }
            function createProjectDiv($name, $id) {
                return " <div class='project'>".$name." | ID: ".$id." | <a href='tabs/?id=".$id."'>Zobacz</a> | <a href='?edit=".$id."'>Edytuj</a></div>";
            }

            check();
            ?>
         </div>
     </div>
</body>
</html>