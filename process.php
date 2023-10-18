<html>
    <head>
        <title>Processing</title>
    </head>
    <body>
        <?php
            if (isset($_POST["first"]) && isset($_POST["last"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["ssn"]) && isset($_POST["phone"]) && isset($_POST["lstate"]) && isset($_POST["license"]) && isset($_POST["address"]) && isset($_POST["city"]) && isset($_POST["state"]) && isset($_POST["zip"]) && isset($_POST["pin"])) {
                $conn = mysqli_connect("localhost", "root", "", "users");
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $username = $_POST["username"];
                $password = $_POST["password"];
                $first = $_POST["first"];
                $last = $_POST["last"];
                $email = $_POST["email"];
                $ssn = $_POST["ssn"];
                $phone = $_POST["phone"];
                $lstate = $_POST["lstate"];
                $license = $_POST["license"];
                $address = $_POST["address"];
                $address2 = $_POST["address2"];
                $city = $_POST["city"];
                $state = $_POST["state"];
                $zip = $_POST["zip"];
                $pin = $_POST["pin"];
                $sql="SELECT * FROM registrations WHERE username='$username'";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);
                if($count>0) {
                    echo "<script>alert('Registration unsuccessful. That userid is already taken.');window.location.href='Registration.html';</script>";
                }
                $sql="SELECT * FROM registrations WHERE email ='$email'";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);
                if($count>0) {
                    echo "<script>alert('Registration unsuccessful. That email is already taken.');window.location.href='Registration.html';</script>";
                }
                $sql="SELECT * FROM registrations WHERE phone ='$phone'";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);
                if($count>0) {
                    echo "<script>alert('Registration unsuccessful. That phone number is already taken.');window.location.href='Registration.html';</script>";
                }
                $sql="SELECT * FROM registrations WHERE ssn='$ssn'";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);
                if($count>0) {
                    echo "<script>alert('Registration unsuccessful.');window.location.href='Registration.html';</script>";
                }
                $sql = "INSERT INTO registrations (username, password, fname, lname, email, address, address2, phone, ssn, state, lstate, license, city, zip, pin) VALUES ('$username', '$password', '$first', '$last', '$email', '$address', '$address2', '$phone', '$ssn', '$state', '$lstate', '$license', '$city', '$zip', '$pin')";
                $results = mysqli_query($conn, $sql);
                if ($results) {
                    echo "<script>alert('Registration Successful');window.location.href='Login.html';</script>";
                }
                else {
                    echo mysqli_error($conn);
                }
                mysqli_close($conn);
            }
            else {
                echo "<script>window.location.href='Login.html';</script>";
            }
        ?>
    </body>
</html>
