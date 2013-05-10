<?php session_start();

// Connect to the DB
$db_link = mysql_connect('localhost', 'pierson3_cameron', 'Summer9(');
if (!$db_link) {
	die("Unable to connect to the database because of " . mysql_error());
}

$db_current = mysql_select_db('pierson3_603north', $db_link);
if (!$db_current) {
	die("Database is connect but unable to access the table because of " . mysql_error());
}

// Check authentication status
$loggedIn = false;
$query = 'SELECT * FROM users WHERE session_id = "' . session_id() . '" LIMIT 1';
$userResult = mysql_query($query);
if (mysql_num_rows($userResult) == 1){
	$_SESSION['user'] = mysql_fetch_assoc($userResult);
	$loggedIn = true;
} else {
	if(basename($_SERVER['PHP_SELF']) != 'login.php'){
		header('Location: login.php');
		exit();
	}
}

?>