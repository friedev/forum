<?php session_start() ?>
<?php
	$_SESSION['username'] = '';
	$_SESSION['displayname'] = '';
	header('Location: /');
	die();
?>
