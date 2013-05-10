<?php
	require_once('inc/config.php');
    include(ROOT_PATH . 'inc/header.php');

	session_start();
	$_SESSION = array();
	session_destroy();

	echo '<h2>You have successfully logged out.</h2>';

	include(ROOT_PATH . 'inc/footer.php');

?>