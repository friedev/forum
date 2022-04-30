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

				$stmt = $mysqli->prepare(
					'SELECT `topics`.`id`, '
					. '`topics`.`title`, '
					. '`topics`.`date`, '
					. '`users`.`displayname` '
					. 'FROM `topics` '
					. 'JOIN `users` ON `topics`.`user_id`=`users`.`id`'
				);
				$stmt->bind_result($id, $title, $date, $displayname);
				$stmt->execute();

				while ($stmt->fetch()) {
					echo
						'<div class="topic">'
						. "<a href=\"topic.php?id=$id\">"
						. '<h3 class="topic">'
						. $title
						. '</h3>'
						. '</a>'
						. '<p class="detail">'
						. '<span class="author">'
						. $displayname
						. '</span>'
						. ' on '
						. '<span class="date">'
						. $date
						. '</span>'
						. '</p>'
						. '</div>';
				}

				$stmt->close();
				$mysqli->close();
			?>
		</main>
<!--#include virtual="/include/footer.html"-->
	</body>
</html>
