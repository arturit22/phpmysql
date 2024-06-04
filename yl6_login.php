<?php
 session_start();
 if (isset($_SESSION['tuvastamine'])) {
   header('Location: yl6_admin.php');
   exit();
   }
?>