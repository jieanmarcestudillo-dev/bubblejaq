<?php
  $page_title = 'Change Password';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
?>
<?php $user = current_user(); ?>
<?php
  if(isset($_POST['update'])){

    $req_fields = array('new-password','old-password','id' );
    validate_fields($req_fields);

    if(empty($errors)){
        if(sha1($_POST['old-password']) !== current_user()['password'] ){
          $session->msg('d', "Your old password not match");
          redirect('usersAccount.php',false);
        }
        $id = (int)$_POST['id'];
        $new = remove_junk($db->escape(sha1($_POST['new-password'])));
        $sql = "UPDATE users SET password ='{$new}' WHERE id='{$db->escape($id)}'";
        $result = $db->query($sql);
            if($result && $db->affected_rows() === 1):
              $session->logout();
              $session->msg('s',"Login with your new password.");
              redirect('index.php', false);
            else:
              $session->msg('d',' Sorry failed to updated!');
              redirect('usersAccount.php', false);
            endif;
    } else {
      $session->msg("d", $errors);
      redirect('usersAccount.php',false);
    }
  }
?>