<?php 
    session_start();
    if(isset($_SESSION['TFA']) == FALSE || $_SESSION['TFA'] == FALSE) header("Location: Login.php");
    else {
        $conn = mysqli_connect("localhost", "root", "", "users");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $digits = 6;
        $code =  sprintf("%06d", mt_rand(0, 999999));
        $_SESSION['body'] = "Your multifactor authentication code is: $code.";
        if ($_SESSION['Last_Location'] == "authentication.php") {
            $username = $_SESSION['username'];
            $sql = "UPDATE registrations SET TFAcode='$code' WHERE username = '$username'";
            $results = mysqli_query($conn, $sql);
        }
        else if ($_SESSION['Last_Location'] == "employee_authentication.php") {
            $id = $_SESSION['id'];
            $sql = "UPDATE Employees SET TFAcode='$code' WHERE employee_id = '$id'";
            $results = mysqli_query($conn, $sql);
        }
        else if ($_SESSION['logged_in'] == TRUE) {
            $username = $_SESSION['username'];
            $sql = "UPDATE registrations SET TFAcode='$code' WHERE username = '$username'";
            $results = mysqli_query($conn, $sql);
        }
        else if ($_SESSION['e_logged_in'] == TRUE) {
            $id = $_SESSION['id'];
            $sql = "UPDATE Employees SET TFAcode='$code' WHERE employee_id = '$id'";
            $results = mysqli_query($conn, $sql);
        }
        header("Location: send-email.php");
    }
?>
