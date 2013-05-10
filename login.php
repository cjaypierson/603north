<?php
// Below is the original login system

/* 
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
*/

// Begins the new login system
require_once('inc/config.php');
include(ROOT_PATH . 'inc/connect.php');

// Clear out any errors
$errors = array();
$success = array();


//Attempt to login
if(isset($_POST['loginSubmit']) && $_POST['loginSubmit'] == 'true') {  
    $loginEmail = trim($_POST['email']);  
    $loginPassword  = trim($_POST['password']); 

    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    if (!preg_match($regex, $loginEmail)) {
    	$errors['loginEmail'] = 'Please enter a valid email address'; 
    }

    if (strlen($loginPassword) < 5 OR strlen($loginPassword) > 12) {
    	$errors['loginPassword'] = 'Please enter a password between 5 and 12 characters';
    }

    if (!$errors) {
    	$query = 'SELECT * FROM users WHERE email = "' . mysql_real_escape_string($loginEmail) . '" AND password = MD5("' . $loginPassword . '") LIMIT 1';
    	$result = mysql_query($query);
    	if (mysql_num_rows($result) == 1) {
    		$user = mysql_fetch_assoc($result);
    		$query = 'UPDATE users SET session_id = "' . session_id() . '" WHERE id = ' . $user['id'] . ' LIMIT 1';
    		mysql_query($query);
    		header('Location: index.php');
    		exit();
    	} else {
    		$errors['login'] = "Sorry, your email or password is incorrect.";
    	}
    }
}

// Attempt to Register

if(isset($_POST['registerSubmit']) && $_POST['registerSubmit'] == 'true') {  
    $registerEmail = trim($_POST['email']);  
    $registerPassword = trim($_POST['password']);  
    $registerConfirmPassword = trim($_POST['confirmPassword']);

    if (!preg_match($regex, $registerEmail)) {
    	$errors['registerEmail'] = 'Please enter a valid email address'; 
    }

    if (strlen($registerPassword) < 5 OR strlen($registerPassword) > 12) {
    	$errors['registerPassword'] = 'Please enter a password between 5 and 12 characters';
    }

    if ($registerConfirmPassword != $registerPassword) {
    	$errors['registerConfirmPassword'] = 'Your passwords do not match';
    }

    //Check for current registration

    $query = 'SELECT * FROM users WHERE email = "' . mysql_real_escape_string($registerEmail) . '" LIMIT 1';  
    $result = mysql_query($query);  
    if (mysql_num_rows($result) == 1) {   
        $errors['registerEmail'] = 'We already have an account with this email address';
    }

    if (!$errors) {  
        $query = 'INSERT INTO users SET email = "' . mysql_real_escape_string($registerEmail) . '", password = MD5("' . mysql_real_escape_string($registerPassword) . '"), date_registered = "' . date('Y-m-d H:i:s') . '"';

        if (mysql_query($query)) {  
            $success['register'] = 'Thank you for registering your 603north account.';  
        } else {  
            $errors['register'] = 'There was an error trying to register your account.  Please check your information and try again.';  
        }
    }
}

define('TITLE', 'Login or Register');
include(ROOT_PATH . 'inc/header.php');
?>

	<header><h1>Login / Register Here</h1></header>  
      
    <form class="box400" name="loginForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">  
        <h2>Login</h2>  
        <?php if($errors['login']) print '<div class="invalid">' . $errors['login'] . '</div>'; ?>  
          
        <label for="email">Email Address</label>  
        <input type="text" name="email" value="<?php echo htmlspecialchars($loginEmail); ?>" />  
        <?php if($errors['loginEmail']) print '<div class="invalid">' . $errors['loginEmail'] . '</div>'; ?>  
          
        <label for="password">Password <span class="info">5-12 chars</span></label>  
        <input type="password" name="password" value="" />  
        <?php if($errors['loginPassword']) print '<div class="invalid">' . $errors['loginPassword'] . '</div>'; ?>  
          
        <label for="loginSubmit">&nbsp;</label>  
        <input type="hidden" name="loginSubmit" id="loginSubmit" value="true" />  
        <input type="submit" value="Login" />  
    </form>  
      
    <form class="box400" name="registerForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">  
        <h2>Register</h2>  
        <?php if($success['register']) print '<div class="valid">' . $success['register'] . '</div>'; ?>  
        <?php if($errors['register']) print '<div class="invalid">' . $errors['register'] . '</div>'; ?>  
          
        <label for="email">Email Address</label>  
        <input type="text" name="email" value="<?php echo htmlspecialchars($registerEmail); ?>" />  
        <?php if($errors['registerEmail']) print '<div class="invalid">' . $errors['registerEmail'] . '</div>'; ?>  
          
        <label for="password">Password</label>  
        <input type="password" name="password" value="" />  
        <?php if($errors['registerPassword']) print '<div class="invalid">' . $errors['registerPassword'] . '</div>'; ?>  
          
        <label for="confirmPassword">Confirm Password</label>  
        <input type="password" name="confirmPassword" value="" />  
        <?php if($errors['registerConfirmPassword']) print '<div class="invalid">' . $errors['registerConfirmPassword'] . '</div>'; ?>  
          
        <label for="registerSubmit">&nbsp;</label>  
        <input type="hidden" name="registerSubmit" id="registerSubmit" value="true" />  
        <input type="submit" value="Register" />  
    </form> 

<?php
include(ROOT_PATH . 'inc/footer.php');
?>
