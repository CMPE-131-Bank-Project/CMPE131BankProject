<?php
    session_start();
    unset($_SESSION['logged_in'], $_SESSION['TFA'], $_SESSION['username'], $SESSION['body'], $_SESSION['Last_Location'], $_SESSION['account'], $_SESSION['recipient'], $_SESSION['nbal'], $_SESSION['amount']);
    session_destroy();
    header("Location: Login.php");
    exit;
