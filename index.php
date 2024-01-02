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
                notlogged();
            }

            function notlogged() {
                echo "
                <div id='loginpanel'>  
                <h1>Witaj w G5Tabs</h1>
                <br/>
                    <form id='loginform' style='display: none;' onsubmit='handleSubmitLogin(event)'> 
                    <p>Oto panel logowania do G5Tabs:</p><br/>
                        <label for='login'>Login: </label><br/><br/>
                        <input type='text' name='login' id='login' class='LRGI'> <br/><br/>
                        <label for='pass'>Hasło: </label><br/><br/>
                        <input type='password' name='pass' id='password' class='LRGI'><br/><br/><br/>
                        <input type='submit' value='Zaloguj się' class='LRGBI'>
                    </form>
                    <form id='registerform' style='display: none;' onsubmit='handleSubmitRegister(event)'> 
                    <p>Oto panel rejestracji do G5Tabs:</p><br/>
                        <label for='login'>Login: </label><br/><br/>
                        <input type='text' name='login' id='login' class='LRGI'> <br/><br/>
                        <label for='pass'>Hasło: </label><br/><br/>
                        <input type='password' name='pass' id='password' class='LRGI'><br/><br/>
                        <label for='pass2'>Powtórz Hasło: </label><br/><br/>
                        <input type='password' name='pass2' id='password' class='LRGI'><br/><br/><br/>
                        <input type='submit' value='Zarejestruj się' class='LRGBI'>
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
                echo "Zawartość tej strony nie jest jeszcze dostępna! // zalogowany";
            }

            check();
            ?>
         </div>
     </div>
</body>
</html>