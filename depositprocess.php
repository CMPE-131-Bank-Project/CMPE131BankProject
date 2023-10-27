<?php
    if (isset($_FILES['frontCheck']) && isset($_FILES['backCheck'])) {
        $phpFileUploadErrors = array(
            0 => 'There is no error, the file uploaded with success',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'Error: No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        );

        $ext_error = false;
        // a list of extensions that we allow to be uploaded 
        $extensions = array('jpg','jpeg','gif','png');
        $file_ext1 = explode('.', $_FILES['frontCheck']['name']);
        $file_ext1 = end($file_ext1);
        $file_ext2 = explode('.', $_FILES['backCheck']['name']);
        $file_ext2 = end($file_ext2);
        if (!in_array($file_ext1, $extensions) || !in_array($file_ext2, $extensions)) {
            $ext_error = true;
        }

        if ($_FILES['frontCheck']['error']) {
            if ($_FILES['frontCheck']['error'] == '4') {
                echo "<div class='alert alert-danger'>
                <strong>Error!</strong> At least one file was not uploaded.
              </div>";
            }
            else {
            echo $phpFileUploadErrors[$_FILES['frontCheck']['error']];
            }
        }
        elseif ($_FILES['backCheck']['error']) {
            if ($_FILES['backCheck']['error'] == '4') {
                echo "<div class='alert alert-danger'>
                <strong>Error!</strong> At least one file was not uploaded.
              </div>";
            }
            else {
            echo $phpFileUploadErrors[$_FILES['backCheck']['error']];
            }
        }
        elseif ($ext_error) {
            echo "<div class='alert alert-danger'>
            <strong>Error!</strong> At least one file is an unsupported type. Please upload files of the following type only: (.jepg .jpg .png .gif)
          </div>";
        }
        else {
            move_uploaded_file($_FILES['frontCheck']['tmp_name'], 'images/'.$_FILES['frontCheck']['name']);
            move_uploaded_file($_FILES['backCheck']['tmp_name'], 'images/'.$_FILES['backCheck']['name']);
        }
    }
    ?>
<?php
session_start();
if(isset($_SESSION['logged_in']) == FALSE) header("Location: Login.html");
else {
    if (!$ext_error) {
    $logged_in = $_SESSION['logged_in'];
    $username = $_SESSION['username'];
    $conn = mysqli_connect("localhost", "root", "", "users");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if (isset($_POST['submit_button'])) {
        $logged_in = $_SESSION['logged_in'];
        $username = $_SESSION['username'];
        $conn = mysqli_connect("localhost", "root", "", "users");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $accountNum = $_POST['account'];
        $amount = $_POST['amount'];
        $frontcheck = 'images/'.$_FILES['frontCheck']['name'];
        $backcheck = 'images/'.$_FILES['backCheck']['name'];
        $sql = "INSERT INTO deposits (accountNum, username, amount, frontcheck, backcheck) VALUES ('$accountNum', '$username', '$amount', '$frontcheck', '$backcheck')";
        $results = mysqli_query($conn, $sql);
        if ($results) {
            echo "<div class='alert alert-success'>
            <strong>Success!</strong> Your deposit is being processed.
          </div>";
        }
        else {
            echo mysqli_error($conn);
        }
    } 
}
}
        ?>
<!DOCTYPE html>
<html lang="en">  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>depositprocess</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <br>
    <form action="deposit.php" style="display: inline-block;">
        <button type="submit">Deposit another check</button>
    </form>
    <form action="user.php" style="display: inline-block;">
        <button type="submit">Back to Homepage</button>
    </form>
</body>
</html>