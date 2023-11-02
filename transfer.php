<?php
    session_start();
    if(isset($_SESSION['logged_in']) == FALSE) header("Location: Login.php");
    else {
        if (isset($_POST['account']) && isset($_POST['recipient']) && isset($_POST['amount'])) {
            if ($_POST['account'] && $_POST['recipient'] && $_POST['amount']) {
                $conn = mysqli_connect("localhost", "root", "", "users");
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $account = $_POST['account'];
                $recipient = $_POST['recipient'];
                $amount = $_POST['amount'];
                $sql = "SELECT * FROM BankAccounts WHERE accountNum = '$account'";
                $result = mysqli_query($conn, $sql);
                $bal = mysqli_fetch_assoc($result);
                $bal['Balance'] = $bal['Balance'] - $amount;
                $nbal = $bal['Balance'];
                if ($nbal < 0) {
                    mysqli_close($conn);
                    echo "<script>alert('Overdraft: Inadequate Balance in Sender Account to Perform Transfer');window.location.href='user.php';</script>";
                } 
                else {
                    $sql = "UPDATE BankAccounts SET Balance = '$nbal' WHERE accountNum = '$account'";
                    $result = mysqli_query($conn, $sql);
                    $sql = "SELECT * FROM BankAccounts WHERE accountNum = '$recipient'";
                    $result = mysqli_query($conn, $sql);
                    $bal = mysqli_fetch_assoc($result);
                    $bal['Balance'] = $bal['Balance'] + $amount;
                    $nbal = $bal['Balance'];
                    $sql = "UPDATE BankAccounts SET Balance = '$nbal' WHERE accountNum = '$recipient'";
                    $result = mysqli_query($conn, $sql);
                    mysqli_close($conn);
                    header("Location: user.php");
                }
            }
            else header("Location: user.php");
        }
        else header("Location: user.php");
    } 
?>
