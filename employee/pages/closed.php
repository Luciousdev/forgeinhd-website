<html>
<head>
    <title>Closed tickets</title>
    <link rel="stylesheet" href="../../assets/css/index.css">
</head>
<body>
    <nav>
        <a href="../index.php">Go back</a>
        <?php
            session_start();
            if(!isset($_SESSION['id'])){
                echo "Please login";
                echo '<head>';
                echo '<meta http-equiv = "refresh" content = "3; url=../index.php"/>';
                echo '</head>';
                echo '<body>';
                echo '403 FORBIDDEN';
                echo '</body>';
                exit();
            } else {
                
                // Retrieve post details
                include '../../db_connect.php';

                $userid = $_SESSION['id'];

                $stmt = $conn->prepare("SELECT * FROM employ WHERE id = :id");
                $stmt->bindParam(':id', $userid);
                $stmt->execute();
                $return = $stmt->fetch();

                $adminStatus = $return['role'];

                if(isset($_SESSION['id'])) {
                    echo '<a href="logout.php">Logout</a>';
                }
            }
        ?>
    </nav>
    <?php
        // Connect to database
        try {
            include '../../db_connect.php';
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Retrieve all posts
            $stmt = $conn->prepare("SELECT * FROM ticket WHERE status='closed' ORDER BY created_at DESC");
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        // echo $_SESSION['user_id'];
    ?>

    <table>
        <tr>
            <th>Title</th>
            <th>Ticket Type</th>
            <th>Created at</th>
        </tr>
        <?php
        // var_dump($results);
            foreach ($results as $result) {
                echo '<tr>';
                echo '<td><a href="ticket.php?id=' . $result['id'] . '"><p style="color: #999;">Subject: </p>' . $result['subject'] . '</a></td>';
                echo '<td><p class="tabletext">Ticket type: </p>' . $result['category'] . '</td>';
                echo '<td><p class="tabletext">Date: </p>' . $result['created_at'] . '</td>';
                echo '</tr>';
            }

            ?>
    </table>
    <?php

    ?>
</body>
</html>
