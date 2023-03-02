<?php
    error_reporting(E_ALL); ini_set('display_errors', 1);
    // check if form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // get form data
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        // validate form data
        if (empty($fname) || empty($lname) || empty($phone) || empty($password) || empty($email)) {
            echo "Please fill out all fields";
        } else {
            // hash password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // connect to database
            try {
                include '../db_connect.php';
                
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // insert user into database
                $stmt = $conn->prepare("INSERT INTO employ (fname, lname, email, phone, password) VALUES (:fname, :lname, :email, :phone, :password)");
                $stmt->bindParam(':fname', $fname);
                $stmt->bindParam(':lname', $lname);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':password', $password_hash);
                $stmt->execute();

                echo "Welcome to the team, $fname!";
            }
            catch(PDOException $e)
            {
                echo "Connection failed: " . $e->getMessage();
            }
            $conn = null;
        }
    }
?>
<html>
    <head>
        <title>Signup</title>
        <link rel="stylesheet" href="./assets/css/style.css">
    </head>
    <body>
        <nav>
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
        </nav>
        <form action="signup.php" method="post">
            <label for="username">First name:</label>
            <input type="text" id="username" name="fname" required><br>

            <label for="password">Last name:</label>
            <input type="text" id="password" name="lname" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Phone number:</label>
            <input type="tel" id="password" name="phone" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Sign Up">
        </form>
    </body>
</html>
