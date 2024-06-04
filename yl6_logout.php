<?php
session_start();
if (!isset($_SESSION['tuvastamine'])) {
 header('Location: yl6_login.php');
 exit();
}
if(isset($_POST['logout'])){
 session_destroy();
 header('Location: yl6_admin.php');
 exit();
}
?>