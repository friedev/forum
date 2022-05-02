<!DOCTYPE html>
<?php session_start() ?>
<html lang="en">
	<head>
		<title>Register - Forum</title>
<!--#include virtual="/include/head.html"-->
	</head>
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php' ?>
		<main>
			<h1>Register</h1>
			<?php
				if (isset($_GET['error'])) {
					switch ($_GET['error']) {
					case 1:
						echo '<p class="error">That username has been taken.</p>';
						break;
					case 2:
						echo '<p class="error">Database connection failed; try again later.</p>';
						break;
					default:
						echo '<p class="error">An internal error occurred during registration.</p>';
						break;
					}
				}
			?>
			<form action="submit.php" method="post">
				<label>Username</label><br />
				<input class="text" type="text" name="username" required autofocus /><br />
				<label>Password</label><br />
				<input class="text" type="password" name="password" required /><br />
				<label>Display Name</label><br />
				<input class="text" type="text" name="displayname" required /><br />
				<input class="submit" type="submit" name="submit" value="Register" />
			</form>
			<p>Already have an account? <a href="/login">Log in.</a></p>
		</main>
<!--#include virtual="/include/footer.html"-->
	</body>
</html>
