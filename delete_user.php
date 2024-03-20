<?php
require_once('includes/load.php');
$userId = (int)$db->escape($_POST['userId']);

$sqlGetName = "SELECT name FROM users WHERE id = $userId";
$resultGetName = $db->query($sqlGetName);

if ($resultGetName && $row = $resultGetName->fetch_assoc()) {
    $userName = $row['name'];

    date_default_timezone_set('Asia/Manila');
    $content = "he/she deleted the user of $userName";
    $user = $_SESSION['user_id'];
    $date = date('Y-m-d H:i:s');
    $sqlInsertLog = "INSERT INTO logs(content, user, created_at) VALUES('$content', '$user', '$date')";

    if ($db->query($sqlInsertLog)) {
        $delete_id = delete_by_id('users',(int)$_POST['userId']);
        return $delete_id ? true : false;
    }
} else {
    echo '0'; 
}
?>
