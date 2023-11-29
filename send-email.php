<?php
    session_start();
    require "vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    if (isset($_SESSION['body'])) {
        if (isset($_POST["email"])) $email = $_POST["email"];
        else $email = $_SESSION['email'];
        $body = $_SESSION['body'];
        $name = "Bank of the Future";
    
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

        unset($_SESSION['body']);
    
        header("Location: MultiFactor.php");
    }
    else if ($_SESSION['logged_in'] == TRUE) header("Location: user.php");
    else if ($_SESSION['e_logged_in'] == TRUE) header("Location: employee.php");
    else header("Location: HomePage.html");
?>
