
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
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["question"])) {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $question = $_POST["question"];

            // Create a connection
            $conn = mysqli_connect("localhost", "root", "", "ContactInfo");

            // Check the connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Prepare a SQL 
            $sql = "INSERT INTO ClientInfoRequest1 (name, email, question) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $question);

            if (mysqli_stmt_execute($stmt)) {
                echo "Data has been successfully stored in the database.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
            mysqli_close($conn); // Close the connection
        } else {
            echo "One or more fields are empty.";
        }
    }
    ?>

    <form method="post" action="contact.php">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="question">Question:</label>
        <textarea name="question" id="question" required></textarea><br>

        <input type="submit" value="Submit">
    </form>
   




    <footer>
        <p>&copy; Bank of the Future</p>
    </footer>
</body>
</html>





    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h4.title {
            background-color: #003a70;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        header {
            background-color: #003a70;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #003a70;
            color: orange;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>



