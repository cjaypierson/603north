<?php	
require_once('inc/config.php');
include(ROOT_PATH . 'inc/connect.php');
include(ROOT_PATH . 'inc/header.php');

print_r($_SESSION['user']);

echo '<h2>Welcome to 603north ' . $_SESSION['user']['email'] . '</h2>'; 






include(ROOT_PATH . 'inc/footer.php');
?>