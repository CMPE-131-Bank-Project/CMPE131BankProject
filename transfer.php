<?php
    session_start();
    if(isset($_SESSION['logged_in']) == FALSE) header("Location: Login.php");
    else if (isset($_POST['account']) && isset($_POST['recipient']) && isset($_POST['amount'])) {
        if ($_POST['account'] && $_POST['recipient'] && $_POST['amount']) {
            $_SESSION['Last_Location'] = "transfer.php";
            $username = $_SESSION['username'];
            $conn = mysqli_connect("localhost", "root", "", "users");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $account = $_POST['account'];
            $recipient = $_POST['recipient'];
            $amount = $_POST['amount'];
            $sql = "SELECT Balance FROM BankAccounts WHERE accountNum = '$account'";
            $result = mysqli_query($conn, $sql);
            $bal = mysqli_fetch_assoc($result);
            $bal['Balance'] = $bal['Balance'] - $amount;
            $nbal = $bal['Balance'];
            $sql = "SELECT username FROM BankAccounts WHERE accountNum = '$recipient'";
            $result = mysqli_query($conn, $sql);
            $recipientUser = mysqli_fetch_assoc($result);
            $otherUser = $recipientUser['username'];
            if ($nbal < 0) {
                mysqli_close($conn);
                echo "<script>alert('Overdraft: Inadequate Balance in Sender Account to Perform Transfer');window.location.href='user.php';</script>";
            } 
            else if ($account == $recipient) {
                mysqli_close($conn);
                echo "<script>alert('You cannot transfer money to and from the same account.');window.location.href='user.php';</script>";
            } 
            else if ($username == $otherUser) {
                $sql = "UPDATE BankAccounts SET Balance = '$nbal' WHERE accountNum = '$account'";
                $result = mysqli_query($conn, $sql);
                $sql = "SELECT Balance FROM BankAccounts WHERE accountNum = '$recipient'";
                $result = mysqli_query($conn, $sql);
                $bal = mysqli_fetch_assoc($result);
                $bal['Balance'] = $bal['Balance'] + $amount;
                $nbal = $bal['Balance'];
                $sql = "UPDATE BankAccounts SET Balance = '$nbal' WHERE accountNum = '$recipient'";
                $result = mysqli_query($conn, $sql);
                $date = date("m/d/Y");
                $time = date("h:i:sa");
                $sql = "INSERT INTO Transactions (accountNum, date_occured, time_occured, transaction_type, transaction_status, amount, location) VALUES ('$account', '$date', '$time', 'Transfer', 'Processed', '-$amount', '$recipient')";
                $result = mysqli_query($conn, $sql);
                $sql = "INSERT INTO Transactions (accountNum, date_occured, time_occured, transaction_type, transaction_status, amount, location) VALUES ('$recipient', '$date', '$time', 'Transferee', 'Processed', '$amount', '$account')";
                $result = mysqli_query($conn, $sql);
                mysqli_close($conn);
                header("Location: user.php");
            }
            else {
                $_SESSION['account'] = $account;
                $_SESSION['recipient'] = $recipient;
                $_SESSION['nbal'] = $nbal;
                $_SESSION['amount'] = $amount;
                $_SESSION['TFA'] = TRUE;
                header("Location: GenerateCode.php");
            }
        }
        else header("Location: user.php");
    }
    else if ($_SESSION['TFA_Token'] == TRUE && $_SESSION['Last_Location'] == "transfer.php") {
        $account = $_SESSION['account'];
        $recipient = $_SESSION['recipient'];
        $nbal = $_SESSION['nbal'];
        $amount = $_SESSION['amount'];
        $_SESSION['TFA'] = FALSE;
        $_SESSION['TFA_Token'] = FALSE;
        $conn = mysqli_connect("localhost", "root", "", "users");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "UPDATE BankAccounts SET Balance = '$nbal' WHERE accountNum = '$account'";
        $result = mysqli_query($conn, $sql);
        $sql = "SELECT Balance FROM BankAccounts WHERE accountNum = '$recipient'";
        $result = mysqli_query($conn, $sql);
        $bal = mysqli_fetch_assoc($result);
        $bal['Balance'] = $bal['Balance'] + $amount;
        $nbal = $bal['Balance'];
        $sql = "UPDATE BankAccounts SET Balance = '$nbal' WHERE accountNum = '$recipient'";
        $result = mysqli_query($conn, $sql);
        date_default_timezone_set('America/Los_Angeles');
        $date = date("m/d/Y");
        $time = date("h:i:sa");
        $sql = "INSERT INTO Transactions (accountNum, date_occured, time_occured, transaction_type, transaction_status, amount, location) VALUES ('$account', '$date', '$time', 'Transfer', 'Processed', '-$amount', '$recipient')";
        $result = mysqli_query($conn, $sql);
        $sql = "INSERT INTO Transactions (accountNum, date_occured, time_occured, transaction_type, transaction_status, amount, location) VALUES ('$recipient', '$date', '$time', 'Transferee', 'Processed', '$amount', '$account')";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        header("Location: user.php");
    }
    else header("Location: user.php");
?>
