<!DOCTYPE html>
<?php session_start() ?>
<?php
	function login_user() {
		if (!isset($_POST['submit'])) {
			return
				'No login details were received.'
				. '<br />'
				. '<a href="/login">Try again.</a>'
				. '<br />'
				. '<a href="/">Return to the main page.</a>';
		}

		$mysqli = new mysqli('localhost', 'forum', 'ah2BSrY3P3pprRrm', 'forum');
		if ($mysqli->connect_errno) {
			return
				'Could not connect to database:'
				. '<br />'
				. '<pre>'
				. $mysqli->connect_error
				. '</pre>'
				. '<br />'
				. '<a href="/login">Try again.</a>'
				. '<br />'
				. '<a href="/">Return to the main page.</a>';
		}

		$username = $_POST['username'];
		$password = $_POST['password'];
		$stmt = $mysqli->prepare(
			'SELECT `displayname` FROM `users` '
			. 'WHERE `username` = ? AND `password` = ?'
		);
		$stmt->bind_param('ss', $username, $password);
		$stmt->bind_result($displayname);

		if ($stmt->execute() && $stmt->store_result() && $stmt->fetch()) {
			if ($stmt->num_rows() == 1) {
				$_SESSION['username'] = $username;
				$_SESSION['displayname'] = $displayname;
				$msg =
					"You are now logged in as $username."
					. '<br />'
					. '<a href="/">Return to the main page.</a>';
			} else {
				$msg =
					'Incorrect username or password.'
					. '<br />'
					. '<a href="/login">Try again.</a>'
					. '<br />'
					. '<a href="/">Return to the main page.</a>';
			}
		} else {
			$msg =
				'There was an error handling your login:'
				. '<br />'
				. '<pre>'
				. $mysqli->error
				. '</pre>'
				. '<br />'
				. '<a href="/login">Try again.</a>'
				. '<br />'
				. '<a href="/">Return to the main page.</a>';
		}

		$stmt->close();
		$mysqli->close();
		return $msg;
	}
	$msg = login_user();
?>
<html lang="en">
	<head>
		<title>Login Submitted - Forum</title>
<!--#include virtual="/include/head.html"-->
	</head>
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php' ?>
		<main>
			<p>
				<?php echo $msg ?>
			</p>
		</main>
<!--#include virtual="/include/footer.html"-->
	</body>
</html>
