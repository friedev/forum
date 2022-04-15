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

		$server = 'localhost';
		$username = 'forum';
		$password = 'ah2BSrY3P3pprRrm';
		$dbname = 'forum';
		$conn = mysqli_connect(
			$server,
			$username,
			$password,
			$dbname
		);
		if (!$conn) {
			return
				'Could not connect to database:'
				. '<br />'
				. '<pre>'
				. mysqli_connect_error()
				. '</pre>'
				. '<br />'
				. '<a href="/register">Try again.</a>'
				. '<br />'
				. '<a href="/">Return to the main page.</a>';
		}

		$username = $_POST['username'];
		$password = $_POST['password'];
		$displayname = $_POST['displayname'];
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare(
			$stmt,
			'INSERT INTO `users` '
			. '(`username`, `password`, `displayname`) '
			. 'VALUES (?, ?, ?)'
		);
		mysqli_stmt_bind_param(
			$stmt,
			'sss',
			$username,
			$password,
			$displayname
		);

		if (mysqli_stmt_execute($stmt)) {
			$_SESSION['username'] = $username;
			$_SESSION['displayname'] = $displayname;
			$msg =
				"Welcome, $displayname! You are now registered as $username."
				. '<br />'
				. '<a href="/">Return to the main page.</a>';
		} else {
			$msg =
				'There was an error handling your registration:'
				. '<br />'
				. mysqli_error($conn)
				. '<br />'
				. '<a href="/register">Try again.</a>'
				. '<br />'
				. '<a href="/">Return to the main page.</a>';
		}

		mysqli_stmt_close($stmt);
		mysqli_close($conn);
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
