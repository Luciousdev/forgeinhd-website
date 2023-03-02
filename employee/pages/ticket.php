<?php
include '../../db_connect.php';
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$post_id = $_GET['id'];

// Retrieve post details
$stmt = $conn->prepare("SELECT * FROM ticket WHERE id = :id");
$stmt->bindParam(':id', $post_id);
$stmt->execute();
$result = $stmt->fetch();
?>
<html>
<head>
    <?php echo "<title>". $result['subject']. "</title>";?>
    <link rel="stylesheet" href="../../assets/css/ticket.css">
</head>
<body>
    <nav>
        <a href="../index.php">Go back</a>
        <?php
            session_start();
            // $_SESSION['user_id'] = $user['id'];
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
                echo '<a href="./status/setpending.php">Set pending</a>';
                echo '<a href="./status/setopen.php">Set open</a>';
                echo '<a href="./status/setclosed.php">Set closed</a>';
                echo '<a href="../logout.php">Logout</a>';
            }
        ?>
    </nav>
    <?php
        include '../../db_connect.php';
        $post_id = $_GET['id'];

        $_SESSION['ticketID'] = $_GET['id'];

        $userid = $_SESSION['id'];
        // var_dump($_GET);
        // Connect to database
        try {
            include '../../db_connect.php';
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Retrieve post details
            $stmt = $conn->prepare("SELECT * FROM ticket WHERE id = :id");
            $stmt->bindParam(':id', $post_id);
            $stmt->execute();
            $result = $stmt->fetch();
            // var_dump($_SESSION);
            

            $customerid == null;

            if($result['customer_id'] == null) {
                $customerid = 'Anonymous';
            } else {
                $customerid = $result['customer_id'];
            }

            // Display post details
        
            echo '<h1>' . $result['subject']. '</h1>';
            if($result['status'] == 'pending') {
                echo '<h4 style="color:#FFF; display:inline; border: 2px solid #D1A92C; border-radius: 20px 20px 20px 20px; background-color: #D1A92C; padding-left: 5px;padding-top: 5px;padding-right: 5px;padding-bottom: 5px;">'. $result['status'] . '</h4>';
            } elseif($result['status'] == 'open') {
                echo '<h4 style="color:#FFF; display:inline; border: 2px solid #238636; border-radius: 20px 20px 20px 20px; background-color: #238636; padding-left: 5px;padding-top: 5px;padding-right: 5px;padding-bottom: 5px;">'. $result['status'] . '</h4>';
            } elseif($result['status'] == 'closed'){
                echo '<h4 style="color:#FFF; display:inline; border: 2px solid #8957e5; border-radius: 20px 20px 20px 20px; background-color: #8957e5; padding-left: 5px;padding-top: 5px;padding-right: 5px;padding-bottom: 5px;">'. $result['status'] . '</h4>';
            }
            echo '<p style="margin-left: 10px;">' . $result['needs'] . '</p>';
            echo '<p style="margin-left: 10px; margin-bottom: 0; "> By: ' . $result['fullname'] . '</p>';
            echo '<p style="margin-left: 10px; margin-bottom: 0; margin-top: 0;"> Email: ' . $result['email'] . '</p>';
            echo '<p style="margin-left: 10px; margin-bottom: 0; margin-top: 0;"> Phone: ' . $result['tel'] . '</p>';
            echo '<p style="margin-left: 10px; margin-bottom: 0; margin-top: 0;"> Other contact: ' . $result['otherContactWay'] . '</p>';
            echo '<p style="margin-left: 10px; margin-bottom: 0; margin-top: 0;"> Date: ' . $result['created_at'] . '</p>';
            echo '<p style="margin-left: 10px; margin-bottom: 0; margin-top: 0;"> Post ID: ' . $post_id . '</p>';
            echo '<p style="margin-left: 10px; margin-bottom: 0; margin-top: 0;"> User ID: ' . $customerid . '</p>';
            
            // Retrieve replies
            $stmt = $conn->prepare("SELECT * FROM replies WHERE ticket_id = :id ORDER BY created_at ASC");
            $stmt->bindParam(':id', $post_id);
            $stmt->execute();
            $replies = $stmt->fetchAll();

            // Display replies
            echo '<h2 style="margin-bottom: 0;">Replies:</h2>';
            echo '<div class="replies">';
            foreach ($replies as $reply) {
                if($adminStatus == "TRUE") {
                    echo '<div class="reply">';
                    echo '<p>' . $reply['content'] . '</p>';
                    echo '<p style="margin-bottom: 0; "> By: ' . $reply['usernamereply'] . '</p>';
                    echo '<p style="margin-top: 0; margin-bottom: 0;"> Date: ' . $reply['created_at'] . '</p>';
                    echo '<p style="margin-top: 0; margin-bottom: 0;"> Reply ID: ' . $reply['reply_id'] . '</p>';
                    echo '<p style="margin-top: 0;"> User ID: ' . $reply['user_id'] . '</p>';
                    echo '</div>';  
                } else {
                    echo '<div class="reply">';
                    echo '<p>' . $reply['content'] . '</p>';
                    echo '<p style="margin-bottom: 0; "> By: ' . $reply['usernamereply'] . '</p>';
                    echo '<p style="margin-top: 0; margin-bottom: 0;"> Date: ' . $reply['created_at'] . '</p>';
                    echo '</div>';
                }
                
            }
            echo '</div>';

            // Display reply form
            if (isset($_SESSION['id'])) {
                echo '<form action="addreply.php" method="post">';
                echo '<h2>Leave a reply:</h2>';
                echo '<input type="hidden" name="post_id" value=' . $post_id . '>';
                echo '<textarea name="content"></textarea>';
                echo '<button type="submit">Reply</button>';
                echo '</form>';
            } else {
                echo '<p>Please <a href="../login.php">login</a> to leave a reply.</p>';
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    ?>
</body>
</html>