<html>
    <head><title>Authentication</title></head>
    <body>
        <?php
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];
                // create connection
                $conn = mysqli_connect("localhost", "root", "", "users");
                // check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                // select user
                $sql = "SELECT password FROM registrations WHERE username = '$username'";
                $results = mysqli_query($conn, $sql);
                if ($results) {
                    session_start();
                    $_SESSION['logged_in'] = false;
                    $row = mysqli_fetch_assoc($results);
                    if ($row["password"] === $password) {
                        $_SESSION['username'] = $username;
                        $_SESSION['logged_in'] = true;
                        echo "<script>window.location.href='user.php';</script>";
                    } 
                    else {
                        session_destroy();
                        echo "<script>alert('Login Failed');window.location.href='Login.html';</script>";
                    }
                } 
                else {
                    echo mysqli_error($conn);
                }
                mysqli_close($conn); // close connection
            } 
            else {
                header("Location: Login.html");
            }
        ?>
    </body>
</html>