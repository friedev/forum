<!DOCTYPE html>
<?php session_start() ?>
<?php
	$_SESSION['username'] = '';
	$_SESSION['displayname'] = '';
?>
<html lang="en">
	<head>
		<title>Registered - Forum</title>
<!--#include virtual="/include/head.html"-->
	</head>
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php' ?>
		<main>
			<p>
				You have been logged out.
				<br />
				<a href="/">Return to the main page.</a>
			</p>
		</main>
<!--#include virtual="/include/footer.html"-->
	</body>
</html>
