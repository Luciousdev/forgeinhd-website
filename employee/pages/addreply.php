<?php
session_start();
// $_SESSION['user_id'] = $user['id'];

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    echo "Please login before you continue";
    exit();
}

// Get post data
$user_id = $_SESSION['id'];
$post_id = intval($_POST['post_id']);
$content = nl2br($_POST['content']);
$username = $_SESSION['fname'];
// var_dump($_POST);

// Connect to database
try {
    include '../../db_connect.php';
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert reply
    $stmt = $conn->prepare("INSERT INTO replies (`ticket_id`, `content`, `employ_id`, `usernamereply`) VALUES (:ticket_id, :content, :user_id,  :username)");
    $stmt->bindParam(':ticket_id', $post_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':username', $_SESSION['fname']);
    $stmt->execute();

    // Redirect to thread
    header('Location: ticket.php?id=' . $post_id);
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
