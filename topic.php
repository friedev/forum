<!DOCTYPE html>
<?php session_start() ?>
<html lang="en">
	<head>
		<title>Forum</title>
<!--#include virtual="/include/head.html"-->
	</head>
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php' ?>
		<main>
			<?php
				$mysqli = new mysqli('localhost', 'forum', 'ah2BSrY3P3pprRrm', 'forum');
				if ($mysqli->connect_errno) {
					return
						'Could not connect to database:'
						. '<br />'
						. '<pre>'
						. $mysqli->connect_error
						. '</pre>'
						. '<br />'
						. '<a href="/login">Try again.</a>'
						. '<br />'
						. '<a href="/">Return to the main page.</a>';
				}

				$id = $_GET['id'];

				echo '<div id="thread">';

				$stmt = $mysqli->prepare(
					'SELECT `topics`.`title`, '
					. '`topics`.`date`, '
					. '`users`.`displayname` '
					. 'FROM `topics` '
					. 'JOIN `users` ON `topics`.`user_id` = `users`.`id` '
					. 'WHERE `topics`.`id` = ?'
				);
				$stmt->bind_param('i', $id);
				$stmt->bind_result($title, $date, $displayname);
				$stmt->execute();
				$stmt->fetch();

				echo "<h1 class=\"topic\">$title</h1>";

				$stmt->close();

				$stmt = $mysqli->prepare(
					'SELECT `posts`.`content`, '
					. '`posts`.`date`, '
					. '`users`.`displayname` '
					. 'FROM `posts` '
					. 'JOIN `topics` ON `posts`.`topic_id` = `topics`.`id` '
					. 'JOIN `users` ON `posts`.`user_id` = `users`.`id` '
					. 'WHERE `posts`.`topic_id` = ?'
				);
				$stmt->bind_param('i', $id);
				$stmt->bind_result($content, $date, $displayname);
				$stmt->execute();

				while ($stmt->fetch()) {
					echo
						'<div class="post" onclick="collapse(this);">'
						. '<img src="/user.png">'
						. '<div>'
						. '<p class="detail">'
						. '<span class="author">'
						. $displayname
						. '</span>'
						. ' on '
						. '<span class="date">'
						. $date
						. '</span>'
						. ':'
						. '</p>'
						. '<p class="content">'
						. $content
						. '</p>'
						. '</div>'
						. '<p class="collapsed" hidden>'
						. '(expand)'
						. '</p>'
						. '</div>'
						. '<hr />';
				}

				$stmt->close();
				$mysqli->close();
			?>
<!--#include virtual="/include/reply_form.html"-->
		</main>
<!--#include virtual="/include/footer.html"-->
	</body>
</html>
