<!DOCTYPE html>
<?php session_start() ?>
<html lang="en">
	<head>
		<title>New Topic - Forum</title>
<!--#include virtual="/include/head.html"-->
	</head>
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php' ?>
		<main>
			<?php if (isset($_SESSION['username'])): ?>
			<h2 id="formName">New Topic</h2>
			<form id="topicForm" name="topicForm" action="/topic.php" method="post">
				<label for="title">Title:</label><br />
				<input class="text" type="text" name="title" required autofocus /><br />
				<label for="content">Content:</label><br />
				<textarea class="text" name="content" rows="8" required></textarea><br />
				<input class="submit" type="submit" name="submit" value="Post" />
			</form>
			<?php else: ?>
			<p><a href="/login">Log in</a> or <a href="/register">register</a> to post a topic.</p>
			<?php endif; ?>
		</main>
<!--#include virtual="/include/footer.html"-->
	</body>
</html>
