<?php
    session_start();
    require "vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    if (isset($_SESSION['body']) && $_SESSION['TFA'] == true) {
        $conn = mysqli_connect("localhost", "root", "", "users");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        if ($_SESSION['Last_Location'] == "authentication.php") {
            $username = $_SESSION['username'];
            $sql = "SELECT email FROM registrations WHERE username = '$username'";
        }
        else if ($_SESSION['Last_Location'] == "employee_authentication.php") {
            $id = $_SESSION['id'];
            $sql = "SELECT email FROM Employees WHERE employee_id = '$id'";
        }
        else if ($_SESSION['logged_in'] == TRUE) {
            $username = $_SESSION['username'];
            $sql = "SELECT email FROM registrations WHERE username = '$username'";
        }
        else if ($_SESSION['e_logged_in'] == TRUE) {
            $id = $_SESSION['id'];
            $sql = "SELECT email FROM Employees WHERE employee_id = '$id'";
        }
        $result = mysqli_query($conn, $sql);
        $info = mysqli_fetch_assoc($result);
        $email = $info['email'];
        $body = $_SESSION['body'];
        $name = "Online Banking Website";
    
        $mail = new PHPMailer(true);
    
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    
        $mail->isSMTP();
        $mail->SMTPAuth = true;
    
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = "tls";
        $mail->Port = "587";
    
        $mail->Username = "onlinebankingwebsite@gmail.com";
        $mail->Password = "jmanactbghairvty";
    
        $mail->setFrom($email, $name);
        $mail->addAddress($email);
        $mail->Subject = "Multi-Factor Authentication";
        $mail->Body = $body;
    
        $mail->send();
    
        header("Location: MultiFactor.php");
    }
    else if ($_SESSION['logged_in'] == TRUE) header("Location: user.php");
    else if ($_SESSION['e_logged_in'] == TRUE) header("Location: employee.php");
    else header("Location: HomePage.html");
?>
