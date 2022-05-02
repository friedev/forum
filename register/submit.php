<!DOCTYPE html>
<?php session_start() ?>
<?php
	function register_user() {
		if (!isset($_POST['submit'])) {
			return
				'No registration details were received.'
				. '<br />'
				. '<a href="/register">Try again.</a>'
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
				. '<a href="/register">Try again.</a>'
				. '<br />'
				. '<a href="/">Return to the main page.</a>';
		}

		$username = $_POST['username'];
		$password = $_POST['password'];
		$displayname = $_POST['displayname'];
		$stmt = $mysqli->prepare(
			'INSERT INTO `users` '
			. '(`username`, `password`, `displayname`) '
			. 'VALUES (?, ?, ?)'
		);
		$stmt->bind_param('sss', $username, $password, $displayname);

		if ($stmt->execute()) {
			$_SESSION['user_id'] = $mysqli->insert_id;
			$_SESSION['username'] = $username;
			$_SESSION['displayname'] = $displayname;
			$msg =
				'Welcome, '
				. htmlentities($displayname)
				. '! You are now registered as '
				. htmlentities($username)
				. '.'
				. '<br />'
				. '<a href="/">Return to the main page.</a>';
		} else {
			$msg =
				'There was an error handling your registration:'
				. '<br />'
				. $mysqli->error
				. '<br />'
				. '<a href="/register">Try again.</a>'
				. '<br />'
				. '<a href="/">Return to the main page.</a>';
		}

		$stmt->close();
		$mysqli->close();
		return $msg;
	}
	$msg = register_user();
?>
<html lang="en">
	<head>
		<title>Registration Submitted - Forum</title>
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
