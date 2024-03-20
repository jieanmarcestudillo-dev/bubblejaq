<?php
require_once('includes/load.php'); 
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);
global $db;
$username = $db->escape($username);
$password = $db->escape($password);
$sql  = "SELECT id, username, password, user_level FROM users WHERE username ='$username' LIMIT 1";
$result = $db->query($sql);

if ($db->num_rows($result) === 1) { 
    $user = $db->fetch_assoc($result);
    $hashed_password = sha1($password);

    if ($hashed_password === $user['password']) {
        $session->login($user['id']);
        updateLastLogIn($user['id']);
        if ($user['user_level'] == 1) {
            header("Location: admin.php");
            exit;
        } else {
            header("Location: add_sales.php");
            exit;
        }
    }
}
header("Location: login.php");
exit;
?>