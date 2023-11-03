<?php
    session_start();
    if(isset($_SESSION['logged_in']) == FALSE) header("Location: Login.php");
    else if ($_SESSION['TFA'] == TRUE) header("Location: MultiFactor.php");
    else if ($_SESSION['TFA'] == FALSE && $_SESSION['logged_in'] == FALSE) header("Location: Login.php");
    else if (isset($_POST["account"])) {
        $conn = mysqli_connect("localhost", "root", "", "users");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $account = $_POST["account"];
        $sql = "SELECT * FROM BankAccounts WHERE accountNum = '$account'";
        $results = mysqli_query($conn, $sql);
        $info = mysqli_fetch_assoc($results);
    }
    else header("Location: user.php");
?>

<html>
    <head>
        <title>Account Info</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="account_info.css" />
    </head>
    <body>
        <h1>
            <?php
                print "Account Information";
            ?>
            <div class="lbtn">
                <a href="Logout.php" class="log logbutton" name="logout">Logout</a>
            </div>
            <div class="lbtn">
                <a href="deposit.php" class="log logbutton" name="deposit">Deposit</a>
            </div>
            <div class="lbtn">
                <a href="user.php" class="log logbutton" name="user_page">Accounts</a>
            </div>
        </h1>
        <h2><?php print $info["type"] . " (" . $info["accountNum"] . ")"; ?></h2>
        <p id="balance"><?php print "Balance: $" . $info["Balance"];?></p>
        <p id="time_created"><?php print "Date Created: " . $info["dcreated"] . " | Time Created: " . $info["tcreated"];?></p>
        <br> <br>

        <table class="center">
            <caption>Transaction(s)</caption>
            <thead>
                <tr>
                    <th>Transaction Date</th>
                    <th>Transaction Time</th>
                    <th>Description</th>
                    <th>Amount($)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM Transactions WHERE accountNum = '$account' ORDER BY date_occured DESC, time_occured DESC";
                    $result = mysqli_query($conn, $sql);
                    while ($transactions = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $transactions["date_occured"] . "</td>";
                        echo "<td>" . $transactions["time_occured"] . "</td>";
                        if ($transactions["transaction_type"] == "Transfer") {
                            echo "<td>Transfer to Account Number: " . $transactions["location"] . "</td>";
                        }
                        else if ($transactions["transaction_type"] == "Transferee") {
                            echo "<td>Received Transfer from Account Number: " . $transactions["location"] . "</td>";
                        }
                        else if ($transactions["transaction_type"] == "Deposit") {
                            echo "<td>Online Deposit</td>";
                        }
                        echo "<td>" . $transactions["amount"] . "</td>";
                        if ($transactions["transaction_status"] == "Processed") {
                            echo "<td style=\"color:green\">" . $transactions["transaction_status"] . "</td>";
                        }
                        else {
                            echo "<td style=\"color:red\">" . $transactions["transaction_status"] . "</td>";
                        }
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </body>
</html>