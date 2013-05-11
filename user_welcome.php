<?php	
require_once('inc/config.php');
include(ROOT_PATH . 'inc/connect.php');
include(ROOT_PATH . 'inc/header.php');


$query = 'SELECT * FROM users WHERE session_id = ' . session_id() . '" LIMIT 1';
$email_result = mysql_query($query);

echo '<h2>Welcome to 603north ' . $email_result['email'] . '</h2>'; 






include(ROOT_PATH . 'inc/footer.php');
?>