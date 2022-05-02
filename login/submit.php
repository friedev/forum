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
		$stmt = $mysqli->prepare(
			'SELECT `id`, `displayname` '
			. 'FROM `users` '
			. 'WHERE `username` = ? '
			. 'AND `password` = ?'
		);
		$stmt->bind_param('ss', $username, $password);
		$stmt->bind_result($user_id, $displayname);

		if ($stmt->execute()
			&& $stmt->store_result()
			&& $stmt->fetch()
			&& $stmt->num_rows() == 1
		) {
			$_SESSION['user_id'] = $user_id;
			$_SESSION['username'] = $username;
			$_SESSION['displayname'] = $displayname;
			header('Location: /');
		} else {
			header('Location: index.php?error=1');
		}
		$stmt->close();
		$mysqli->close();
?>
