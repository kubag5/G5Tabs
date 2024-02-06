<?php
if (isset($conn) && session_status() == PHP_SESSION_ACTIVE) {
    $sql = "SELECT id_st FROM users WHERE id = " . $_SESSION["id"];
    $result = $conn->query($sql);
    $style = -1;
    if ($result->num_rows > 0) {
        $style = $result->fetch_assoc()["id_st"];
    }

    if ($style != -1) {
        $sql = "SELECT * FROM styles WHERE id_u = " . $_SESSION["id"];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
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