<?php
if(isset($_SESSION['active']) and $_SESSION['active']){

} else {
    header("Location: login.php");
    exit;
}