<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src= "https://code.jquery.com/jquery-3.4.1.min.js"></script>  
        <title>Deposit</title>
        <link rel="stylesheet" href="deposit.css" />
    </head>
    <body>
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
        <div id="form-container">   
        <div class="container">
        <h1>Online Check Deposit</h1> <br> 
        <form action="depositprocess.php" method="POST" enctype="multipart/form-data" style="display: inline-block;">
            <label for="account">To:</label>
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
                </select>
                <br>
            <br>
            <div id="form-section">
            $<input type="text" name="amount" placeholder="Enter a dollar amount" id="amount" required> <br><br>
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
                </div>
            Upload a picture of the front of your check: 
            <input type="file" name="frontCheck"> 
            <br>
            Upload a picture of the back of your check: <input type="file" name="backCheck" id="backUpload">
            <br>
            <br>
            <input name="submit_button" type="submit" value="Deposit" id="deposit">
            <button name="reset_button" type="reset" onclick="return confirm('Are you sure you want to reset form?')">Reset</button>
        </form> <br> <br> <br> <br> 
        <form action="user.php" style="display: inline-block;">
            <button type="submit" id="home-button">Home</button>
        </form>
        <?php
            mysqli_close($conn);
        ?> 

    <div class="popup" id ="popup-3">
                <div class="overlay"></div>
                <div class="content">
                    <p class="timertext" style="font-size: 1.5rem;"> 
                        <span class="secs"></span>
                        <br>
                        <button id="stay" onclick="stay()">Stay Logged In</button>
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
                                    $(this).on("mousemove keypress keyup keypress keydown touchstart click dblclick scroll wheel load unload", function() {
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

    </div>
    </div>
    </body>
</html>
    
