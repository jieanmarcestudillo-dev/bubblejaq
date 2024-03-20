<?php
    require_once('includes/load.php');

    // $sqlGetName = "SELECT name FROM products WHERE id = '$_POST[prodId]'";
    // $resultGetName = $db->query($sqlGetName);

    // if ($resultGetName && $row = $resultGetName->fetch_assoc()) {
    //     $productName = $row['name'];
    //     $sql = "SELECT picture FROM products WHERE common_id = '" . (int)$_POST['prodId'] . "'";
    //     $result = $db->query($sql);
    
    //     if ($result && $result->num_rows > 0) {
    //         $row = $result->fetch_assoc();
    //         $filename = 'uploads/products/'.$row['picture'];
    //         if (file_exists($filename) && unlink($filename)) {
    //             date_default_timezone_set('Asia/Manila');
    //             $content = "he/she deleted the product of $productName";
    //             $user = $_SESSION['user_id'];
    //             $date = date('Y-m-d H:i:s');
    //             $sqlInsertLog = "INSERT INTO logs(content, user, created_at) VALUES('$content', '$user', '$date')";
    //             if ($db->query($sqlInsertLog)) {
    //                 $delete_id = delete_by_common_id('products', (int)$_POST['prodId']);
    //                 $itemId = delete_by_common_id('item', (int)$_POST['prodId']);
    //             }
    //         } else {
    //             echo $row['picture'];
    //         }
    //     } 
        
    // }
    $sql = "SELECT picture FROM products WHERE common_id = '" . (int)$_POST['prodId'] . "'";
    $result = $db->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $filename = 'uploads/products/'.$row['picture'];
        if(file_exists($filename) && unlink($filename)) {
            $delete_id = delete_by_common_id('products', (int)$_POST['prodId']);
            $itemId = delete_by_common_id('item', (int)$_POST['prodId']);
        }else {
            echo $row['picture'];
        }
    } 

?>
