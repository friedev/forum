<!DOCTYPE html>
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

# Insert the new user details
# Database constraints ensure that a unique username is used
$username = $_POST['username'];
$password = $_POST['password'];
$displayname = $_POST['displayname'];
$stmt = $mysqli->prepare(
	'INSERT INTO `users` '
	. '(`username`, `password`, `displayname`) '
	. 'VALUES (?, ?, ?)'
);
$stmt->bind_param('sss', $username, $password, $displayname);

# If the insertion was successful, so is the registration
if ($stmt->execute()) {
	# Save the user's info into the session to avoid redundant queries
	$_SESSION['user_id'] = $mysqli->insert_id;
	$_SESSION['username'] = $username;
	$_SESSION['displayname'] = $displayname;
	# Redirect to the main index page
	header('Location: /');
# Else, redirect back to the registration page with an error
} else {
	header('Location: index.php?error=1');
}
$stmt->close();
$mysqli->close();
?>
