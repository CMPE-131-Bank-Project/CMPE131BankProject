<?php
    $conn = mysqli_connect("localhost", "root", "", "users");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM BankAccounts ORDER BY Balance DESC";
    $result = mysqli_query($conn, $sql);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="employee.css">
    </head>
    <body>
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
    </body>
</html>
