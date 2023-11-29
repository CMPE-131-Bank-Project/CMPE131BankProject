<?php
    session_start();
    if(isset($_SESSION['e_logged_in']) == FALSE) header("Location: EmployeeLogin.php");
    else if ($_SESSION['TFA'] == TRUE) header("Location: MultiFactor.php");
    else if ($_SESSION['TFA'] == FALSE && $_SESSION['e_logged_in'] == FALSE) header("Location: EmployeeLogin.php");
    else if (isset($_SESSION['e_logged_in']) && $_SESSION['e_logged_in'] == FALSE) header("Employee_Login.php");
    else if (time() - $_SESSION['time'] > 600) header("Location: Logout.php");
    else {
        $_SESSION['time'] = time();
        $conn = mysqli_connect("localhost", "root", "", "users");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM BankAccounts ORDER BY Balance DESC";
        $result = mysqli_query($conn, $sql);
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="employee.css">
        <script defer src="employee.js"></script>
        <title>Employee</title>
    </head>
    <body>
        <h1>
            <?php
                $id = $_SESSION['id'];
                $sql = "SELECT * FROM Employees WHERE employee_id = '$id'";
                $results = mysqli_query($conn, $sql);
                $ename = mysqli_fetch_assoc($results);
                $name = $ename["fname"] . " " . $ename["lname"];
                print "<span style=\"font-weight: bold;\">Welcome to work, " . $name . $_SESSION['tier'] . "!</span>";
            ?>
            <div class="lbtn">
                <a href="Logout.php" class="log logbutton" name="logout">Logout</a>
            </div>
            <div class="lbtn">
                <a href="Registration.php" class="log logbutton" name="logout">New User</a>
            </div>

        </h1><br>
        <table>
            <thead>
                <th>Account Number</th>
                <th>Owner</th>
                <th>Balance</th>
                <th>Type</th>
            </thead>
            <tbody>
                <?php
                    $num = 0;
                    while ($accounts = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $accounts["accountNum"] . "</td>";
                        echo "<td>" . $accounts["username"] . "</td>";
                        echo "<td>" . "$" . $accounts["Balance"] . "</td>";
                        echo "<td>" . $accounts["type"] . "</td></tr>";
                        $num++;
                    }
                    echo "</tbody>";
                    echo "<caption>Total Bank Accounts (" . $num . ")</caption>";
                ?>
        </table>
        <br>
        <table>
            <thead>
                <th>Front of Check</th>
                <th>Back of Check</th>
                <th>Amount</th>
                <th>Approve/Deny</th>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM deposits ORDER BY date ASC, time ASC";
                    $result = mysqli_query($conn, $sql);
                    $num = 0;
                    while ($deposits = mysqli_fetch_assoc($result)) {
                        echo "<form action=\"deposit_final_process.php\" method=\"post\"><input type=\"hidden\" name=\"transaction_num\" value=\"" . $deposits["transaction_num"] . "\"><input type=\"hidden\" name=\"account_num\" value=\"" . $deposits["accountNum"] . "\">";
                        echo "<tr><td><img src=\"" . $deposits["frontcheck"] . "\"></td>";
                        echo "<td><img src=\"" . $deposits["backcheck"] . "\"></td>";
                        echo "<td><input type=\"hidden\" name=\"amount\" value=\"" . $deposits["amount"] . "\">$" . $deposits["amount"] . "</td>";
                        echo "<td><button name=\"decision\" type=\"submit\" value=\"approve\">Approve</button>     <button name=\"decision\" type=\"submit\" value=\"deny\">Deny</button></tr></form>";
                        $num++;
                    }
                    echo "</tbody>";
                    echo "<caption>Pending Online Deposits (" . $num . ")</caption>";
                ?>
        </table>
    </body>
</html>
