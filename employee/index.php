<html>
<head>
    <title>Total tickets</title>
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<?php
    echo '<body>';
        echo '<nav>';
            require '../db_connect.php';
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
                $userid = $_SESSION['id'];

                $stmt = $conn->prepare("SELECT * FROM employ WHERE id = :id");
                $stmt->bindParam(':id', $userid);
                $stmt->execute();
                $return = $stmt->fetch();
                
                $role = $return['role'];
                
                echo '<a href="logout.php">Logout</a>';
                if ($role == 'owner') {
                    echo '<a href="admin.php">Admin Panel</a>';
                }
                echo '<a>Welcome ' . $_SESSION['fname'] . ' ' .$_SESSION['lname']. "</a>";
            }
        echo '</nav>';
        require '../db_connect.php';
        
        // Retrieve all ticket counts
        $stmt = $conn->prepare("SELECT status, COUNT(*) AS count FROM ticket GROUP BY status");
        $stmt->execute();
        $ticketCounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // echo "Query executed. Found " . count($ticketCounts) . " results.";

        echo '<table>';
        echo '<tr>';    
        echo '<th>Ticket type</th>';
        echo '<th>Ticket amount</th>';
        echo '</tr>';
        // Display ticket counts in a table
        foreach ($ticketCounts as $ticketCount) {
            echo '<tr>';
            echo '<td><a href="./pages/' . strtolower($ticketCount['status']) . '.php"><p style="color: #999;">' . ucfirst($ticketCount['status']) . ' tickets</p></a></td>';
            echo '<td><p class="tabletext">Amount of tickets: ' . $ticketCount['count'] . '</p></td>';
            echo '</tr>';
        }
        echo '</table>';
    echo '</body>';
?>
</html>
