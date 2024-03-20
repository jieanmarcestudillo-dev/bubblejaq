<?php
  //update user image
  require_once('includes/load.php');
  if(isset($_POST['uploadImage'])) {
    $photo = new Media();
    $user_id = (int)$_POST['user_id'];
    $photo->upload($_FILES['userImage']);
      if($photo->process_user($user_id)){
        $session->msg('s','photo has been uploaded.');
        redirect('usersAccount.php');
      } else{
        $session->msg('d',join($photo->errors));
        redirect('usersAccount.php');
      }
  }
?>
<?php
  //update user info
  require_once('includes/load.php');
  if(isset($_POST['updateInfo'])){
    $req_fields = array('name','username' );
    validate_fields($req_fields);
    if(empty($errors)){
      $id = (int)$_SESSION['user_id'];
      $name = remove_junk($db->escape($_POST['name']));
      $username = remove_junk($db->escape($_POST['username']));
      $sql = "UPDATE users SET name ='{$name}', username ='{$username}' WHERE id='{$id}'";
      $result = $db->query($sql);
      if($result && $db->affected_rows() === 1){
        $session->msg('s',"Acount updated ");
        redirect('usersAccount.php', false);
      } else {
        $session->msg('d',' Sorry Update Failed');
        redirect('usersAccount.php', false);
      }
    }else {
      $session->msg("d", $errors);
      redirect('usersAccount.php',false);
    }
  }
?>