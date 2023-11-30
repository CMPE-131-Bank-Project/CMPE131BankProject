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


    <form  method="post" action="ProcessContact.php">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email"  required><br>

        <label for="question">Question:</label>
        <textarea type = "question"  name="question"  required></textarea><br>

        <input type="submit" value="Submit">
    </form>
   <br><br>
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
    padding: 30px;
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
    background-color: #004080;
    color: #fff;
    padding: 15px 25px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #002b4d;
}

footer {
    background-color: #004080;
    color: #fff;
    text-align: center;
    padding: 10px;
    position: fixed;
    bottom: 0;
    width: 100%;
}
    </style>




