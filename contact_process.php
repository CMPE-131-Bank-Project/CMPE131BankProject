<?php
    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["question"])) {
        $conn = mysqli_connect("localhost", "root", "", "users");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $name = $_POST["name"];
        $email = $_POST["email"];
        $question = $_POST["question"];
        date_default_timezone_set('America/Los_Angeles');
        $date = date("m/d/Y");
        $time = date("h:i:sa");
        $mtime = date("H:i:s");
        $year = (date("Y") - 1045) * pow(10, 8);
        $ticket = $year + rand(0, 99999999);
        $sql = "SELECT * FROM support WHERE ticket='$ticket'";
        $result = mysqli_query($conn, $sql);
        $duplicate = mysqli_num_rows($result);
        $count = 0;
        while ($duplicate > 0) {
            if ($count == 1000) {
                $year = $year + 1;
                $count = 0;
            }
            $ticket = $year + rand(0, 99999999);
            $sql = "SELECT * FROM support WHERE ticket='$ticket'";
            $result = mysqli_query($conn, $sql);
            $duplicate = mysqli_num_rows($result);
            $count = $count + 1;
        }
        $sql = "INSERT INTO support (ticket, name, email, question, date, time, mil_time) VALUES ('$ticket', '$name', '$email', '$question', '$date', '$time', '$mtime')";
        $result = mysqli_query($conn, $sql);
        header("Location: Contact.php");
    }
    else header("Location: HomePage.html");
?>