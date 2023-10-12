<?php
    session_start();
    $logged_in = $_SESSION['logged_in'];
    if ($logged_in) {
        $username = $_SESSION['username'];
        print($username);
        session_destroy();
    }
    else echo "<script>window.location.href='Login.html';</script>";
?>