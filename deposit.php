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

</div>
</div>
    