<?php
    session_start();
    if (isset($_SESSION['TFA']) == TRUE && $_SESSION['TFA'] == TRUE) {
        $_SESSION['TFA'] = FALSE;
        $location = $_SESSION['Last_Location'];
        header("Location: $location");
    }
    else if ($_SESSION['logged_in'] == TRUE) header("Location: user.php");
    else header("Location: Login.php");
?>