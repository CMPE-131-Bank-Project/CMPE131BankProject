<html>

<html>
<head>
    <link rel="stylesheet" href="EmployeeProfile.css">
    <title>Contact Us - Bank of the Future</title>
</head>
<body>
    <h4 class="title">Bank of the Future</h4>
    <header>
        <nav>
            <ul>
                <li><a href="HomePage.html">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="services.html">Services</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="EmployeeLogIn.php">Employee Login</a></li>
            </ul>
        </nav>
    </header>
    <?php
       if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["question"])) {
        if ($_POST["name"] && $_POST["email"] && $_POST["question"]){
            $name = $_POST["name"];
            $email = $_POST["email"];
            $question = $_POST["question"];
            
    // create connection
    $conn = mysqli_connect("localhost", "root", "", "Contact_Info");
    
    // check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }
    // register user
    $sql = "INSERT INTO clients (name , email, question) VALUES ('$name', '$email', '$question')";
    $results = mysqli_query($conn, $sql);
    
    if ($results) {
    echo "Your question has been sent, Our team will asnwer your question through email.";
    echo "<br>";
    echo "THANKS FOR BANKING WITH US!"
} else {
    echo mysqli_error($conn);
    }
    if (mysqli_errno($conn) == 1062) {
        echo "Same question has been submitted alredy on your end.";}
    
    mysqli_close($conn); // close connection
        } else {
            echo "Please let us know how our can help you today";
        }
        
        
        } else {
        echo "Form was not submitted.";
        }
        ?>  

    <footer>
        <p>&copy; Bank of the Future</p>
    </footer>
</body>
</html>


    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}

h4.title, header {
    background-color: #004080;
    color: #fff;
    text-align: center;
    padding: 15px;
}

form {
    max-width: 400px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

label {
    display: block;
    margin-bottom: 10px;
    color: #333;
    font-weight: bold;
}

input[type="text"],
input[type="email"],

textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s;
}

input[type="text"]:focus,
input[type="email"]:focus,
textarea:focus {
    border-color: #004080;
}

input[type="submit"] {
    background-color: #003a70;
    color: #fff;
    padding: 15px 25px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}






    </style>


    </body>
</html>