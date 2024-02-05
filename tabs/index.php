<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G5Tabs</title>
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
            if (!isset($_GET['id'])) {
                echo "<h1>Nie podano ID.</h1></div></div></div></body></html>";
                exit;
            }
            if (empty($_GET['id'])) {
                echo "<h1>Nie podano ID.</h1></div></div></div></body></html>";
                exit;
            }

            $id = $_GET['id'];
            if (!is_numeric($id)) {
                echo "<h1>Podano błędne ID.</h1></div></div></div></body></html>";
                exit;
            }
            $conn = new mysqli("localhost", "root", "", "g5tabs");
            if ($conn->connect_error) {
                die("Connection failed");
            }
             $result = $conn->query("SELECT dane FROM tabs WHERE id = ".$id);
             if ($result->num_rows > 0) {
                $dane = $result->fetch_assoc()["dane"];
                $json = json_decode($dane, true);
                $lista = $json["daty"];
                foreach($lista as $tab) {
                    echo getTab1Element(htmlspecialchars($tab['text']), htmlspecialchars($tab['data']));
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