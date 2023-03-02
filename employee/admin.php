<?php
session_start();
// Retrieve post details
include './assets/scripts/dbconnect.php';

$userid = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :id");
$stmt->bindParam(':id', $userid);
$stmt->execute();
$return = $stmt->fetch();

$adminStatus = $return['admin'];
// var_dump($userid);



if($adminStatus == "TRUE") {
    echo '<a href="index.php">Go back</a><br>';
    
} elseif($_SESSION['user_id'] == 1){
    echo "test";
} else {
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Post</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope&display=swap');
        * {
            font-family: 'Manrope', sans-serif;
        }
        body {
            color: #fff;
            background-color: #333;
        }
        form {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid gray;
            border-radius: 5px;
        }
        label {
            color: #fff;
            font-weight: bold;
            margin-right: 10px;
        }
        input[type="number"] {
            padding: 12px 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        a {
            color: #fff;
        }
        a:hover {
            color: #ccc;
        }
        h1,
        h3 {
            color: #fff;
            text-align: center;
            margin-top: 50px;
        }
        .wrap-select-input {
            display: flex;
            flex-direction: row;
            align-items: center;
        }
    </style>
</head>
<body>

<?php
// Connect to the database
try {
    include './assets/scripts/dbconnect.php';
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the database successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Retrieve the form data
    $post_id = $_POST['post_id'];

    // Prepare and execute the SQL statement to delete the replies related to the post
    $stmt = $conn->prepare("DELETE FROM replies WHERE post_id = :id");
    $stmt->bindParam(':id', $post_id);
    $stmt->execute();

    // Prepare and execute the SQL statement to delete the post
    $stmt = $conn->prepare("DELETE FROM posts WHERE post_id = :id");
    $stmt->bindParam(':id', $post_id);
    $stmt->execute();

    echo "<br>Post and its related replies have been deleted successfully";
}

// echo "Reply has been deleted successfully";

if (isset($_POST['delete_reply'])) {
    // Retrieve the form data
    $reply_id = $_POST['reply_id'];

    // Prepare and execute the SQL statement to delete the reply
    $stmt = $conn->prepare("DELETE FROM replies WHERE reply_id = :id");
    $stmt->bindParam(':id', $reply_id);
    $stmt->execute();

    echo "<br>Reply has been deleted successfully";
}


if (isset($_POST['admin_status'])) {
    $users_id = $_POST['usersAdminID'];
    $adminSet = $_POST['status'];

    // Prepare and execute the SQL statement to delete the reply
    $stmt = $conn->prepare("UPDATE users SET admin = :status WHERE user_id = :id");
    $stmt->bindParam(':id', $users_id);
    $stmt->bindParam(':status', $adminSet);
    $stmt->execute();

    echo "<br>Admin status has been set successfully";

}

if (isset($_POST['remove_user'])) {
    $removeUserId = $_POST['removeUserId'];

    $stmt = $conn->prepare("DELETE FROM replies WHERE user_id = :user_id;
    DELETE FROM posts WHERE user_id = :user_id;
    DELETE FROM users WHERE user_id = :user_id;    
    ");
    $stmt->bindParam(':user_id', $removeUserId);
    $stmt->execute();

    // echo "User succesfully removed";
}

?>
<h1>Welcome to the admin dashboard <?php echo $_SESSION['username']; ?>.</h1>
<h3>Posts/reply deletion:</h3>
<form method="post" action="">
    <label>Post ID:</label>
    <input type="number" name="post_id" required>
    <br>
    <input type="submit" name="submit" value="Delete">
</form>

<form style="margin-top:50px;" method="post" action="">
    <label>Reply ID:</label>
    <input type="number" name="reply_id" required>
    <br>
    <input type="submit" name="delete_reply" value="Delete Reply">
</form>

<!-- TODO table that shows all users. Maybe just show user count and the list on a different page? -->

<?php 

// Delete user
echo "<h3>Delete user:</h3>";
echo "<form style=margin-top:50px; method='post' action=''>";
echo "<label>User ID:</label>";
echo "<input type='number' name='removeUserId' required>";
echo "<br>";
echo "<div class='wrap-select-input'>";
echo "<br>";
echo "<br>";
echo "<input type='submit' name='remove_user' value='Delete user'>";
echo "</div>";
echo "</form>";    
echo "<br>";
echo "<br>";

if ($userid == "1" || $userid == "2") {
    // List all admins
    $usersExecute = $conn->prepare("SELECT * FROM users WHERE admin = 'TRUE'");
    $usersExecute->execute();
    $adminUsers = $usersExecute->fetchAll();

    // Shows amount of users registered
    $usersRegistered = $conn->prepare("SELECT COUNT(user_id) FROM `users`");
    $usersRegistered->execute();
    $usersRegisteredOutput = $usersRegistered->fetch();

    // Set admin
    echo "<h3>Users admin:</h3>";
    echo "<form style=margin-top:50px; method='post' action=''>";
    echo "<label>User ID:</label>";
    echo "<input type='number' name='usersAdminID' required>";
    echo "<br>";
    echo "<div class='wrap-select-input'>";
    echo "<label>Status:</label>";
    echo "<select name='status' style='width:200px; font-size:20px; background-color:#f2f2f2;'>";
    echo "<option value='TRUE' required>TRUE</option>";
    echo "<option value='FALSE' required>FALSE</option>";
    echo "</select>";
    echo "<br>";
    echo "<br>";
    echo "<input type='submit' name='admin_status' value='Set users admin status'>";
    echo "</div>";
    echo "</form>";    
    echo "<br>";
    echo "<br>";


    // List of admins in a table
    echo "<h3>Current admins:</h3>";
    echo "<div style='display: flex; justify-content: center;'>";
    echo "<table style='border-collapse: collapse;'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th style='border: 1px solid black; padding: 8px;'>Users ID</th>";
    echo "<th style='border: 1px solid black; padding: 8px;'>Username</th>";
    echo "<th style='border: 1px solid black; padding: 8px;'>Admin status</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    foreach ($adminUsers as $adminUser) {
        echo "<tr>";
        echo "<td style='border: 1px solid black; padding: 8px;'>" . $adminUser['user_id'] . "</td>";
        echo "<td style='border: 1px solid black; padding: 8px;'>" . $adminUser['username'] . "</td>";
        echo "<td style='border: 1px solid black; padding: 8px;'>" . $adminUser['admin'] . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    // Table of registered users
    echo "<h3><a href='registeredusers.php'>All registered users:</a></h3>";
    echo "<div style='display: flex; justify-content: center;'>";
    echo "<table style='border-collapse: collapse;'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th style='border: 1px solid black; padding: 8px;'>Users ID</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    echo "<tr>";
    echo "<td style='border: 1px solid black; padding: 8px;'>" . $usersRegisteredOutput[0] . "</td>";
    echo "</tr>";
    echo "</tbody>";
    echo "</table>";
    echo "</div>";


    
} else {
    echo "You currently do not have access to control the admins.";
}


?>

</body>
</html>
