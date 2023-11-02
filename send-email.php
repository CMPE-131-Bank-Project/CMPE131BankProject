<?php
    session_start();
    require "vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    if (isset($_SESSION['body']) && $_SESSION['TFA'] == true) {
        $username = $_SESSION['username'];
        $conn = mysqli_connect("localhost", "root", "", "users");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT email FROM registrations WHERE username = '$username'";
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
    else header("Location: Login.php");
?>