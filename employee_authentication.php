<?php 
    session_start();
    if (isset($_POST["employee_id"]) && isset($_POST["password"])) {
        $_SESSION['Last_Location'] = "employee_authentication.php";
        $id = $_POST["employee_id"];
        $password = $_POST["password"];
        $conn = mysqli_connect("localhost", "root", "", "users");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT password FROM Employees WHERE employee_id = '$id'";
        $results = mysqli_query($conn, $sql);
        if ($results) {
            $row = mysqli_fetch_assoc($results);
            if ($row["password"] === $password) {
                $_SESSION['e_logged_in'] = FALSE;
                $_SESSION['id'] = $id;
                $_SESSION['TFA'] = TRUE;
                echo "<script>window.location.href='GenerateCode.php';</script>";
            } 
            else {
                echo "<script>alert('Login Failed');window.location.href='Logout.php';</script>";
            }
        } 
        else {
            echo mysqli_error($conn);
        }
        mysqli_close($conn); 
    }
    else if ($_SESSION['TFA_Token'] == TRUE && $_SESSION['Last_Location'] == "employee_authentication.php") {
        $_SESSION['e_logged_in'] = TRUE;
        $_SESSION['TFA_Token'] = FALSE;
        $_SESSION['time'] = time();
        header("Location: employee.php");
    }
    else {
        header("Location: EmployeeLogin.php");
    }
?>
