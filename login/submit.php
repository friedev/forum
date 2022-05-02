<?php session_start() ?>
<?php
		# No POST data found: assume the wrong link was used and redirect
		if (!isset($_POST['submit'])) {
			header('Location: index.php');
			die();
		}

		$mysqli = new mysqli('localhost', 'forum', 'ah2BSrY3P3pprRrm', 'forum');
		if ($mysqli->connect_errno) {
			header('Location: index.php?error=2');
			die();
		}

		# Query for the given credentials
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

		# If exactly 1 record was found, the login is successful
		if ($stmt->execute()
			&& $stmt->store_result()
			&& $stmt->fetch()
			&& $stmt->num_rows() == 1
		) {
			# Save the user's info into the session to avoid redundant queries
			$_SESSION['user_id'] = $user_id;
			$_SESSION['username'] = $username;
			$_SESSION['displayname'] = $displayname;
			# Redirect to the main index page
			header('Location: /');
		# Else, redirect back to the login page with an error
		} else {
			header('Location: index.php?error=1');
		}
		$stmt->close();
		$mysqli->close();
?>
