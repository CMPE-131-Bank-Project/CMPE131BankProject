<?php
    session_start();
    unset($_SESSION['logged_in'], $_SESSION['TFA'], $_SESSION['username'], $SESSION['body']);
    session_destroy();
    header("Location: Login.php");
    exit;
