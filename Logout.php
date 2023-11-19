<?php
    session_start();
    if ($_SESSION["e_logged_in"] == TRUE) $location = "EmployeeLogin.php";
    else if ($_SESSION["logged_in"] == TRUE) $location = "Login.php";
    else $location = "home.php";
    unset($_SESSION['logged_in'], $_SESSION['TFA'], $_SESSION['username'], $SESSION['body'], $_SESSION['Last_Location'], $_SESSION['account'], $_SESSION['recipient'], $_SESSION['nbal'], $_SESSION['amount'], $_SESSION['old_sender'], $_SESSION['e_logged_in'], $_SESSION['new_e_token'], $_SESSION['id'], $_SESSION['time']);
    session_destroy();
    header("Location: $location");
    exit;
?>
