<?php

session_start();

if(!isset($_SESSION['id'])){
    echo "Please login";
    echo '<head>';
    echo '<meta http-equiv = "refresh" content = "1; url=../index.php"/>';
    echo '</head>';
    echo '<body>';
    echo '403 FORBIDDEN';
    echo '</body>';
    exit();
} else {
    $ticketID = $_SESSION['ticketID'];

    require '../../../db_connect.php';

    $stmt = $conn->prepare("UPDATE ticket SET status='open' WHERE id=:ticketid");
    $stmt->bindParam(':ticketid', $ticketID);
    $stmt->execute();
    echo '<meta http-equiv = "refresh" content = "0; url=../ticket.php?id='.$ticketID.'"/>';
}