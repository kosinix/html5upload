<?php
    session_start();
    require_once 'uploads/creds.php';
    $post = $_POST;
    $get = $_GET;
    $msg = '';
    if(isset($get['msg'])){
        if($get['msg'] == 1){
            $msg = 'Incorrect login.';
        }
    }
    if(isset($post['username']) and isset($post['password'])){
        if($post['username'] === $USERNAME and $post['password'] === $PASSWORD){
            $_SESSION['active'] = true;
            header("Location: index.php");
            exit;
        } else {

            header("Location: login.php?msg=1");
            exit;
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset=utf-8>
    <meta name="viewport" content="width=device-width">
    <title>HTML5 Uploader</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="" method="post">
    <div>
        <?php echo $msg; ?>
    </div>
    <div class="fields">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="">
    </div>
    <div class="fields">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" value="">
    </div>
    <button type="submit" name="submit">Login</button>
</form>
</body>
</html>