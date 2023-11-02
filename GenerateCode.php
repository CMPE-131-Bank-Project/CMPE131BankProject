<?php 
    session_start();
    if(isset($_SESSION['TFA']) == FALSE || $_SESSION['TFA'] == FALSE) header("Location: Login.php");
    else {
        $username = $_SESSION['username'];
        $conn = mysqli_connect("localhost", "root", "", "users");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $digits = 6;
        $code =  sprintf("%06d", mt_rand(0, 999999));
        $sql = "UPDATE registrations SET TFAcode='$code' WHERE username = '$username'";
        $results = mysqli_query($conn, $sql);
        $_SESSION['body'] = "Your multifactor authentication code is: $code.";
        header("Location: send-email.php");
    }
?>