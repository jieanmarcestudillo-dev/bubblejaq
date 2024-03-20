<?php
require_once('includes/load.php');
if(isset($_POST['edit_cat'])){
  $req_field = array('categoriesName');
  validate_fields($req_field);
  $cat_name = remove_junk($db->escape($_POST['categoriesName']));
  $cat_id = remove_junk($db->escape($_POST['categoryId']));
  if(empty($errors)){
       $sql = "UPDATE categories SET name='{$cat_name}'";
       $sql .= "WHERE id='{$cat_id}'";
     $result = $db->query($sql);
     if($result && $db->affected_rows() === 1) {
      date_default_timezone_set('Asia/Manila');
      $content = 'he/she update the product of '. $cat_name;
      $user = $_SESSION['user_id'];
      $date = date('Y-m-d H:i:s');
       $sql = "INSERT INTO logs(content,user,created_at) VALUES('$content','$user','$date')";
       if($db->query($sql)){
         $session->msg("s", "Successfully updated Category");
         redirect('categories.php',false);
       }
     }else {
       $session->msg("d", "Sorry! Failed to Update");
       redirect('categories.php',false);
     }
  }
}
?>