<?php
require_once('includes/load.php');
if (isset($_POST['catId'])) {
    $catId = (int)$_POST['catId'];
    $sqlGetName = "SELECT name FROM categories WHERE id = $catId";
    $resultGetName = $db->query($sqlGetName);
    if ($resultGetName && $row = $resultGetName->fetch_assoc()) {
        $categoryName = $row['name'];
        $delete_id = delete_by_id('categories', $catId);
        date_default_timezone_set('Asia/Manila');
        $content = "he/she deleted the product of $categoryName";
        $user = $_SESSION['user_id'];
        $date = date('Y-m-d H:i:s');
        $sqlInsertLog = "INSERT INTO logs(content, user, created_at) VALUES('$content', '$user', '$date')";
        if ($db->query($sqlInsertLog)) {
            return $delete_id ? true : false;
        }
    }
}
return false;
?>
