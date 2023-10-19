<?php
    session_start();
    if(isset($_SESSION['logged_in']) == FALSE) header("Location: Login.html");
    else {
        $logged_in = $_SESSION['logged_in'];
        $username = $_SESSION['username'];
        $conn = mysqli_connect("localhost", "root", "", "users");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM registrations WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $fname = mysqli_fetch_assoc($result);
        $sql = "SELECT * FROM BankAccounts WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
    } 
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="userpageCSS.css">
        <script src="userpagescripts.js"></script>
    </head>
    <body>
        <h1>
            <?php
                print "Welcome, " . $fname['fname'] . "!";
            ?>
            <div class="lbtn">
                <a href="Logout.php" class="log logbutton" name="logout">Logout</a>
            </div>
        </h1>
        <table>
            <thead>
                <tr>
                    <?php 
                        if ($logged_in && $result) {
                            echo "<th>Accounts</th>"; 
                        }
                    ?>      
                </tr>
                <tr>
                    <th>Account Type</th>
                    <th>Account Number</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if ($logged_in && $result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row["type"] . "</td>";
                            echo "<td>" . $row["accountNum"] . "</td>";
                            echo "<td>" . $row["Balance"] . "</td>";
                            echo "</tr>";
                            echo "<br>";
                        }
                    }
                ?>
            </tbody>
        </table>
        <div class="popup" id ="popup-1">
            <div class="overlay"></div>
            <div class="content">
                <div class="close-btn" onclick="togglePopup()">&times;</div>
                <form action="account.php" method="post">
                    <div class="container">
                        <h2>Choose an Account</h2>
                        <input type="radio" id="checking" name="acc" value="Checking Account">
                        <label for="checking">Checking Account</label> <br>
                        <input type="radio" id="savings" name="acc" value="Savings Account">
                        <label for="savings">Savings Account</label> <br>
                        <button type="submit" class="btn">Open</button>
                    </div>
                </form>
            </div>
        </div>
        <button onclick="togglePopup()">Open an Account</button>
    </body>
</html>
