<!DOCTYPE html>
<?php session_start() ?>
<html lang="en">
	<head>
		<title>Log In - Forum</title>
<!--#include virtual="/include/head.html"-->
	</head>
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php' ?>
		<main>
			<h1>Login</h1>
			<?php
				if (isset($_GET['error'])) {
					switch ($_GET['error']) {
					case 1:
						echo '<p class="error">Incorrect username or password.</p>';
						break;
					case 2:
						echo '<p class="error">Database connection failed; try again later.</p>';
						break;
					default:
						echo '<p class="error">An internal error occurred during login.</p>';
						break;
					}
				}
			?>
			<form action="submit.php" method="post">
				<label>Username</label><br />
				<input class="text" type="text" name="username" required autofocus /><br />
				<label>Password</label><br />
				<input class="text" type="password" name="password" required /><br />
				<input class="submit" type="submit" name="submit" value="Log In" />
			</form>
			<p>Don't have an account? <a href="/register">Register.</a></p>
		</main>
<!--#include virtual="/include/footer.html"-->
	</body>
</html>
