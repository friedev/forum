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
				. '<a href="/login">Try again.</a>'
				. '<br />'
				. '<a href="/">Return to the main page.</a>';
		}

		$username = $_POST['username'];
		$password = $_POST['password'];
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare(
			$stmt,
			'SELECT `displayname` FROM `users` WHERE `username` = ? AND `password` = ?'
		);
		mysqli_stmt_bind_param(
			$stmt,
			'ss',
			$username,
			$password
		);
		mysqli_stmt_bind_result($stmt, $displayname);

		if (
			mysqli_stmt_execute($stmt)
			&& mysqli_stmt_store_result($stmt)
			&& mysqli_stmt_fetch($stmt)
		) {
			if (mysqli_stmt_num_rows($stmt) == 1) {
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
				. mysqli_error($conn)
				. '</pre>'
				. '<br />'
				. '<a href="/login">Try again.</a>'
				. '<br />'
				. '<a href="/">Return to the main page.</a>';
		}

		mysqli_stmt_close($stmt);
		mysqli_close($conn);
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
