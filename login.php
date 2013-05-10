<?php
define('TITLE', 'LOGIN');
require_once('inc/config.php');
include(ROOT_PATH . 'inc/header.php');

print '<h2>Please login to access this material.</h2>';
print '<h3>Username:  test@piersons.me</h3>
	   <h3>Password: thisisonlyatest</h3>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ( (isset($_POST['email'])) && (isset($_POST['password'])) ) {

		$email = $_POST['email'];
		$pass = $_POST['password'];
		$validated = false;

		if ( (strtolower($email) == 'test@piersons.me') && ($pass == 'thisisonlyatest') ) {

			$validated = true;

			session_start();
			$_SESSION['email'] = $email;
			$_SESSION['loggedin'] = time();
		?>

			<p>Thank you.  You are now logged in and can view our <a href="contract.php">contact</a>.</p>

		<?php	
			
		
		} else {

			print '<p>Sorry, the email and password you entered do not match.</p>';

		}

	} else {

		print '<p>Please make sure to enter both an email address and a password.</p>';

	}
}

	print '<form action="login.php" method="post">
				<p>Email Address: <input type="text" name="email" size="20" /></p>
				<p>Password: <input type="password" name="password" size="20" /></p>
				<p><input type="submit" value="Login" /></p>
		   </form>';

include(ROOT_PATH . 'inc/footer.php');
?>