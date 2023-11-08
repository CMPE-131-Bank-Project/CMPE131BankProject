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
                <a href="card_selection.php" class="log logbutton" name="ATM">ATM</a>
            </div>
            <div class="lbtn">
                <a href="user.php" class="log logbutton" name="user_page">Home</a>
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
                    <th>Transaction Number</th>
                    <th>Transaction Date</th>
                    <th>Transaction Time</th>
                    <th>Description</th>
                    <th>Amount($)</th>
                    <th>Old Balance($)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM Transactions WHERE accountNum = '$account' ORDER BY date_occured DESC, time_occured DESC";
                    $result = mysqli_query($conn, $sql);
                    while ($transactions = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $transactions["transaction_num"] . "</td>";
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
                        else if ($transactions["transaction_type"] == "Withdrawal") {
                            echo "<td>ATM Withdrawal</td>";
                        }
                        echo "<td>" . $transactions["amount"] . "</td>";
                        echo "<td>" . $transactions["old_balance"] . "</td>";
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
        <div class="popup" id ="popup-3">
            <div class="overlay"></div>
            <div class="content">
                <p class="timertext" style="font-size: 1.5rem;"> 
                    <span class="secs"></span>
                    <br>
                    <button onclick="stay()">Stay Logged In</button>
                    <button onclick="logout()">Logout</button>
                </p> 
                    <script type="text/javascript"> 
                        var currSeconds = 0; 
                        var popUpInactive = true;

                        $(document).ready(function() { 
                            let idleInterval = 
                                setInterval(timerIncrement, 1000); 
                                document.addEventListener("wheel", function (e) {
                                    var oldVal = parseInt(document.getElementById("body").style.transform.replace("translateY(","").replace("px)",""));
                                    var variation = parseInt(e.deltaY);
                                    document.getElementById("body").style.transform = "translateY(" + (oldVal - variation) + "px)";
                                    return false;
                                }, true);
                                $(this).on("mousemove keypress keyup keypress keydown touchstart click dblclick scroll wheel load unload", function() {
                                    if(popUpInactive) resetTimer();
                                })
                        });

                        function resetTimer() { 
                            document.querySelector(".timertext") 
                                .style.display = 'none'; 

                            currSeconds = 0; 
                        } 

                        function logout() {
                            window.location.href='Logout.php';
                        }

                        function stay() {
                            popUpInactive = true;
                            resetTimer();
                            document.getElementById("popup-3").classList.toggle("active");
                        }

                        function timerIncrement() { 
                            currSeconds = currSeconds + 1;
                            left = 600 - currSeconds;
                            dSeconds = left % 60;
                            Minutes = Math.trunc(left/60); 
                            if (dSeconds < 10) dSeconds = "0" + dSeconds;
                            if (currSeconds == 300) {
                                popUpInactive = false;
                                document.getElementById("popup-3").classList.toggle("active");
                            }
                            if (currSeconds >= 300 && left >= 0) {
                                document.querySelector(".secs") 
                                .textContent = "Due to inactivity, you will be logged out in " + Minutes + ":" + dSeconds; 
                                document.querySelector(".timertext") 
                                    .style.display = 'block'; 
                            }
                            if (currSeconds == 600) logout();
                        } 
                </script>
            </div>
        </div>
    </body>
</html>
