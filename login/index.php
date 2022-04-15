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
			<form action="submit.php" method="post">
				<label>Username</label><br />
				<input class="text" type="text" name="username" required autofocus /><br />
				<label>Password</label><br />
				<input class="text" type="password" name="password" required /><br />
				<input class="submit" type="submit" name="submit" value="Log In" />
			</form>
		</main>
<!--#include virtual="/include/footer.html"-->
	</body>
</html>
