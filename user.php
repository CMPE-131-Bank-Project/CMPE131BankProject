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
        <script src= "https://code.jquery.com/jquery-3.4.1.min.js"></script>
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
                <caption>Account(s)</caption>
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
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["type"] . "</td>";
                        echo "<td>" . $row["accountNum"] . "</td>";
                        echo "<td>$" . $row["Balance"] . "</td>";
                        echo "<td>" . $row["dcreated"] . "</td>";
                        echo "<td>" . $row["tcreated"] . "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        <button onclick="togglePopup()">Open an Account</button>
        <button onclick="togglePopupTwo()">Transfer</button>
        <form action="deposit.php" style="display: inline-block;">
            <button type="Submit">Deposit</button>
        </form>
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
                        <input type="text" name="recipient" minlength="10"  maxlength="10" id="recipient" required><br>
                        <script>
                            $(function() {
                                $("input[name='recipient']").on('input', function(e) {
                                    $(this).val($(this).val().replace(/[^0-9]/g, ''));
                                });
                            });
                        </script>
                        <label for="amount">Amount($):</label>
                        <input type="text" name="amount" id="amount" required> <br><br>
                        <script>
                            $("#amount").on("keyup", function(){
                                var valid = /^\d+(\.\d{0,2})?$/.test(this.value),
                                    val = this.value;
                                
                                if(!valid){
                                    console.log("Invalid input!");
                                    this.value = val.substring(0, val.length - 1);
                                }
                            });
                        </script>
                        <button type="submit" class="btn">Transfer</button>
                </form>
            </div>
        </div>
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

                            /* Increment the idle time 
                                counter every second */ 
                            let idleInterval = 
                                setInterval(timerIncrement, 1000); 

                            /* Zero the idle timer 
                                on mouse movement */ 
                                document.addEventListener("wheel", function (e) {
                                    // get the old value of the translation (there has to be an easier way than this)
                                    var oldVal = parseInt(document.getElementById("body").style.transform.replace("translateY(","").replace("px)",""));

                                    // to make it work on IE or Chrome
                                    var variation = parseInt(e.deltaY);

                                    // update the body translation to simulate a scroll
                                    document.getElementById("body").style.transform = "translateY(" + (oldVal - variation) + "px)";

                                    return false;

                                }, true);
                                $(this).on("mousemove keypress keyup keypress keydown touchstart click dblclick scroll wheel", function() {
                                    if(popUpInactive) resetTimer();
                                })
                        });

                        function resetTimer() { 

                            /* Hide the timer text */ 
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

                            /* Set the timer text to 
                                the new value */ 
                            if (currSeconds == 300) {
                                popUpInactive = false;
                                document.getElementById("popup-3").classList.toggle("active");
                            }
                            if (currSeconds >= 300 && left >= 0) {
                                document.querySelector(".secs") 
                                .textContent = "Due to inactivity, you will be logged out in " + Minutes + ":" + dSeconds; 

                                /* Display the timer text */ 
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
