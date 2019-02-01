<?php 
	include("../includes/adminheader.php");

	$username = $_POST['username'];
	$pw = $_POST['password'];

	if (isset($_POST['submit'])) {
		if (($username != "") && ($pw != "")) {
			if (($username == "username") && ($pw == "user_password")) {
				// Success: user has logged in
				session_start();

				$_SESSION['guitar_catalog'] = session_id();

				header("Location:insert.php");

			} else {
				// Failure: user hasn't logged in
				if ($username != "username" || $username == "") {
					$username_errors = "Please enter in a valid username.";
				}
				if ($pw != "user_password" || $pw == "") {
					$pw_errors = "Please enter in a valid password.";
				}
			}
		} else { // \ if username != "" 
			if ($username == "") {
				$username_errors = "Please enter in a valid username.";
			}
			if ($pw == "") {
				$pw_errors = "Please enter in a valid password.";
			}
		}
		
	} // \ if isset submit
?>

		<div class="container">
			<div class="col-md-12">

				<h1>Login</h1>

				<!-- htmlspecialchars() php statement is a security feature   -->
				<form name="loginform" id="loginform" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
					<p>
						<label for="username">Username*:</label>
						<input type="text" name="username" id="username" value="<?php echo $_POST['username']; ?>" class="form-control">
						<?php echo "<p class=\"errorMessage\">$username_errors</p>"; ?>
					</p>
					<p>
						<label for="password">Password*:</label>
						<input type="password" name="password" id="password" value="<?php echo $_POST['password']; ?>" class="form-control">
						<?php echo "<p class=\"errorMessage\">$pw_errors</p>"; ?>
					</p>
					<p>
						<input type="submit" name="submit" class="btn btn-primary login-button" value="Login" />
					</p>
				</form>

			</div>

		</div>



<?php 
	include("../includes/footer.php");
?>