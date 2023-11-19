<?php 
    session_start();
    if (isset($_POST["code"]) && isset($_SESSION['TFA']) == TRUE && $_SESSION['TFA'] == TRUE) {
        $conn = mysqli_connect("localhost", "root", "", "users");
        $code = $_POST["code"];
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        if ($_SESSION['Last_Location'] == "authentication.php") {
            $username = $_SESSION['username'];
            $sql = "SELECT TFAcode FROM registrations WHERE username = '$username'";
            $results = mysqli_query($conn, $sql);
        }
        else if ($_SESSION['Last_Location'] == "employee_authentication.php") {
            $id = $_SESSION['id'];
            $sql = "SELECT TFAcode FROM Employees WHERE employee_id = '$id'";
            $results = mysqli_query($conn, $sql);
        }
        if ($results) {
            session_start();
            $row = mysqli_fetch_assoc($results);
            if ($row["TFAcode"] == $code) {
                $_SESSION['TFA'] = FALSE;
                $_SESSION['TFA_Token'] = TRUE;
                $location = $_SESSION['Last_Location'];
                header("Location: $location");
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
