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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
                <caption>
                    <?php 
                        if ($logged_in && $result > 0) {
                            echo "Accounts"; 
                        }
                    ?>      
                </caption>
                <tr>
                    <th>Account Type</th>
                    <th>Account Number</th>
                    <th>Balance</th>
                    <th>Date Created</th>
                    <th>Time Created</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if ($logged_in && $result > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row["type"] . "</td>";
                            echo "<td>" . $row["accountNum"] . "</td>";
                            echo "<td>$" . $row["Balance"] . "</td>";
                            echo "<td>" . $row["dcreated"] . "</td>";
                            echo "<td>" . $row["tcreated"] . "</td>";
                            echo "</tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
        <button onclick="togglePopup()">Open an Account</button>
        <button onclick="togglePopupTwo()">Transfer</button>
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
        <?php 
            $sql = "SELECT * FROM BankAccounts WHERE username = '$username'";
            $result = mysqli_query($conn, $sql);
        ?>
        <div class="popup" id ="popup-2">
            <div class="overlay"></div>
            <div class="content">
                <div class="close-btn" onclick="togglePopupTwo()">&times;</div>
                <form action="transfer.php" method="post">
                        <h2>Transfer</h2>
                        <label for="account">From:</label>
                        <select name="account" id="account">
                            <?php 
                                if ($logged_in && $result > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value=\"" . $row["accountNum"] . "\">";
                                        echo $row["type"] . " (" . $row["accountNum"] . ")";
                                        echo "</option>";
                                    }
                                }
                            ?>
                        </select>
                        <br>
                        <label for="recipient">To (Account #):</label>
                        <input type="text" name="recipient"  maxlength="10" id="recipient" required><br>
                        <script>
                            $(function() {
                                $("input[name='recipient']").on('input', function(e) {
                                    $(this).val($(this).val().replace(/[^0-9]/g, ''));
                                });
                            });
                        </script>
                        <label for="amount">Amount($):</label required>
                        <input type="text" name="amount" id="amount"> <br><br>
                        <script>
                            $(function() {
                                $("input[name='amount']").on('input', function(e) {
                                    $(this).val($(this).val().replace(/[^0-9.]/g, ''));
                                });
                            });
                        </script>
                        <button type="submit" class="btn">Transfer</button>
                </form>
            </div>
        </div>
    </body>
</html>
