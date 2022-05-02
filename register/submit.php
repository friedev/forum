<!DOCTYPE html>
<?php session_start() ?>
<?php
		if (!isset($_POST['submit'])) {
			header('Location: index.php');
			die();
		}

		$mysqli = new mysqli('localhost', 'forum', 'ah2BSrY3P3pprRrm', 'forum');
		if ($mysqli->connect_errno) {
			header('Location: index.php?error=2');
			die();
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
			header('Location: /');
		} else {
			header('Location: index.php?error=1');
		}
		$stmt->close();
		$mysqli->close();
?>
