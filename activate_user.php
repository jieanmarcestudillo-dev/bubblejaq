<?php
require_once('includes/load.php');
$userId = (int)$db->escape($_POST['userId']);

$sqlGetName = "SELECT name FROM users WHERE id = $userId";
$resultGetName = $db->query($sqlGetName);

if ($resultGetName && $row = $resultGetName->fetch_assoc()) {
    $userName = $row['name'];

    date_default_timezone_set('Asia/Manila');
    $content = "he/she activated the user of $userName";
    $user = $_SESSION['user_id'];
    $date = date('Y-m-d H:i:s');
    $sqlInsertLog = "INSERT INTO logs(content, user, created_at) VALUES('$content', '$user', '$date')";

    if ($db->query($sqlInsertLog)) {
        $sql = "UPDATE users SET status = 1 WHERE id = $userId";
        echo $db->query($sql) === TRUE ? '1' : '0';
    }
} else {
    echo '0'; 
}
?>
