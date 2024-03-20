<?php
require_once('includes/load.php');

if(isset($_POST['update'])) {
    $id = (int)$e_user['id'];
    $user_id = remove_junk($db->escape($_POST['user_id']));
    $name = remove_junk($db->escape($_POST['name']));
    $username = remove_junk($db->escape($_POST['username']));
    $sql = "UPDATE users SET name ='{$name}', username ='{$username}' WHERE id = '$user_id'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1){
        $session->msg('s',"Account Updated ");
        redirect('manage_account.php', false);
    }else {
        $session->msg('d',' Sorry failed to updated!');
        redirect('manage_account.php', false);
    }
}


if(isset($_POST['update-pass'])){
    if($_POST['password'] != $_POST['confirmPassword']){
        $session->msg('d',"User password not equal to Confirm Password ");
        redirect('manage_account.php', false);
    }else{
        $user_id = remove_junk($db->escape($_POST['user_id']));
        $password = remove_junk($db->escape($_POST['password']));
        $h_pass = sha1($password);
        $sql = "UPDATE users SET password='{$h_pass}' WHERE id = '$user_id'";
        $result = $db->query($sql);
        if($result && $db->affected_rows() === 1){
            $session->msg('s',"Your Password has been updated ");
            redirect('manage_account.php', false);
        }else {
            $session->msg('d',' Sorry failed to updated your password!');
            redirect('manage_account.php', false);
        }
    }
}
?>