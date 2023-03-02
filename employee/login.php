<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // validate form data
    if (empty($email) || empty($password)) {
        echo "Please fill out all fields";
    } else {
        try {
            include '../db_connect.php';
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // check if username and password match a user in the database
            $stmt = $conn->prepare("SELECT * FROM employ WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $password = $_POST['password'];

            // if a user is found and the password matches
            if ($user && password_verify($password, $user['password'])) {
                // start a session and redirect to index.php
                $_SESSION['logged_in'] = true;
                $_SESSION['email'] = $user['email'];
                $_SESSION['id'] = $user['id'];
                $_SESSION['fname'] = $user['fname'];
                $_SESSION['lname'] = $user['lname'];
                header('Location: index.php');
                exit;
            } else {
                echo "Incorrect username or password";
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        } finally {
            $conn = null;
        }
    }
}
?>

<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="../assets/css/loginsignup.css">
    </head>
    <body>
        <nav>
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
        </nav>
        <form action="login.php" method="post">
            <label for="username">E-mail:</label>
            <input type="text" id="username" name="email"><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br>

            <input type="submit" value="Login">
        </form>
    </body>
</html>
