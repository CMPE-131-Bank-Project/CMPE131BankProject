<?php 
        session_start();
        if(isset($_SESSION['logged_in']) == FALSE) header("Location: Login.html");
        else {
            $logged_in = $_SESSION['logged_in'];
            $username = $_SESSION['username'];
            print($username);
            if (isset($_POST["acc"])) {
                if ($_POST["acc"]) {
                    $acc = $_POST["acc"];
                    $check = "Checking Account";
                    $save = "Savings Account";
                    $conn = mysqli_connect("localhost", "root", "", "users");
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    if ($acc == $check) {
                        $ir = 0.0005;
                        $year = (date("Y") - 1004) * pow(10, 6);
                        $num = $year + rand(0, 999999);
                        $sql="SELECT * FROM BankAccounts WHERE accountNum='$num'";
                        $result = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($result);
                        while ($count > 0) {
                            $num = $year + rand(0, 999999);
                            $sql="SELECT * FROM BankAccounts WHERE accountNum='$num'";
                            $result = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($result);
                        }
                        $sql = "INSERT INTO BankAccounts (accountNum, username, Balance, type, interest) VALUES ('$num', '$username', '0', 'Checking Account', '$ir')";
                        $results = mysqli_query($conn, $sql);
                    }
                    else if ($acc == $save) {
                        $ir = 0.0057;
                        $year = (date("Y") - 1004) * pow(10, 6);
                        $num = $year + rand(0, 999999);
                        $sql="SELECT * FROM BankAccounts WHERE accountNum='$num'";
                        $result = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($result);
                        while ($count > 0) {
                            $num = $year + rand(0, 999999);
                            $sql="SELECT * FROM BankAccounts WHERE accountNum='$num'";
                            $result = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($result);
                        }
                        $sql = "INSERT INTO BankAccounts (accountNum, username, Balance, type, interest) VALUES ('$num', '$username', '0', 'Savings Account', '$ir')";
                        $results = mysqli_query($conn, $sql);
                    }
                    mysqli_close($conn);
                    header("Location: user.php");
                }
                else header("Location: user.php");
            }
            else header("Location: user.php");
        } 
?>