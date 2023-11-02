<?php 
    session_start();
    if (isset($_POST["code"]) && isset($_SESSION['TFA']) == TRUE && $_SESSION['TFA'] == TRUE) {
        $username = $_SESSION['username'];
        $code = $_POST["code"];
        $conn = mysqli_connect("localhost", "root", "", "users");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT TFAcode FROM registrations WHERE username = '$username'";
        $results = mysqli_query($conn, $sql);
        if ($results) {
            session_start();
            $row = mysqli_fetch_assoc($results);
            if ($row["TFAcode"] == $code) {
                $_SESSION['logged_in'] = TRUE;
                $_SESSION['TFA'] = FALSE;
                echo "<script>window.location.href='user.php';</script>";
            } 
            else {
                echo "<script>alert('The code that you entered was invalid.');window.location.href='MultiFactor.php';</script>";
            }
        } 
        else {
            echo mysqli_error($conn);
        }
    }
    else if ($_SESSION['logged_in'] == TRUE && $_SESSION['TFA'] == FALSE) header("Location: user.php");
    else header("Location: Login.php");
?>