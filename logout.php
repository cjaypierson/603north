<?php
require_once('inc/config.php');
include_once(ROOT_PATH . 'inc/connect.php'); 

$query = 'UPDATE users SET session_id = NULL WHERE id = ' . $_SESSION['user']['id'] . ' LIMIT 1';  
mysql_query($query);  
unset($_SESSION['user']);  
header('Location: login.php');  
exit();

?>