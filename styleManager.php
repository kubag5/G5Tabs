<?php
 $styleList = array(); 
if (isset($conn) && session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["zalogowany"]) && $_SESSION["zalogowany"] == true) {
    $sql = "SELECT id_st FROM users WHERE id = " . $_SESSION["id"];
    $result = $conn->query($sql);
    $style = -2;
    if ($result->num_rows > 0) {
        $style = $result->fetch_assoc()["id_st"];
    }

    if ($style != -2) {
        $sql = "SELECT styles.description AS description ,styles.name AS name ,styles.id AS id, styles.hex1 AS hex1, styles.hex2 AS hex2 , styles.hex3 AS hex3 FROM styles, users, items WHERE items.item = 1 AND users.id = items.id_u AND items.id_i = styles.id AND users.id = " . $_SESSION["id"];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $styleList[] = $row;
                if ($row["id"] == $style) {
                    $hex1 = $row["hex1"];
                    $hex2 = $row["hex2"];
                    $hex3 = $row["hex3"];
                    echo "<script> 
                    document.documentElement.style.setProperty('--kubaVP1', '".$hex1."');
                    document.documentElement.style.setProperty('--kubaVP2', '".$hex2."');
                    document.documentElement.style.setProperty('--kubaVP3', '".$hex3."');
                   </script>";
                }
            }
        }
    }  
}

?>