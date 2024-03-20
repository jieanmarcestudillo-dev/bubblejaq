<?php
require_once('includes/load.php');
if(isset($_POST['add_user'])){
  $name   = remove_junk($db->escape($_POST['full-name']));
  $username   = remove_junk($db->escape($_POST['username']));
  $password   = remove_junk($db->escape($_POST['password']));
  $user_level = (int)$db->escape($_POST['level']);
  $password = sha1($password);
  $query = "INSERT INTO users (";
  $query .="name,username,password,user_level,status";
  $query .=") VALUES (";
  $query .=" '{$name}', '{$username}', '{$password}', '{$user_level}','1'";
  $query .=")";
  if($db->query($query)){
    date_default_timezone_set('Asia/Manila');
    $content = "he/she added the user of $name";
    $user = $_SESSION['user_id'];
    $date = date('Y-m-d H:i:s');
    $sqlInsertLog = "INSERT INTO logs(content, user, created_at) VALUES('$content', '$user', '$date')";
    if ($db->query($sqlInsertLog)) {
        $session->msg('s',"User account has been created! ");
        redirect('users.php', false);
    }
  }else{
    $session->msg('d',' Sorry failed to create account!');
    redirect('users.php', false);
  }
}
?>