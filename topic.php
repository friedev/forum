<!DOCTYPE html>
<?php session_start() ?>
<?php
	function submit_post($mysqli, $topic_id=-1) {
		$stmt = $mysqli->prepare(
			'SELECT `id` '
			. 'FROM `users` '
			. 'WHERE `username` = ?'
		);
		$stmt->bind_param('s', $_SESSION['username']);
		$stmt->bind_result($user_id);
		$stmt->execute();
		$stmt->fetch();
		$stmt->close();

		if ($topic_id == -1) {
			$title = $_POST['title'];
			$stmt = $mysqli->prepare(
				'INSERT INTO `topics` '
				. '(`user_id`, `date`, `title`) '
				. 'VALUES (?, NOW(), ?)'
			);
			$stmt->bind_param('is', $user_id, $title);
			$stmt->execute();
			$stmt->close();

			$topic_id = $mysqli->insert_id;
		}

		$content = $_POST['content'];
		$stmt = $mysqli->prepare(
			'INSERT INTO `posts` '
			. '(`user_id`, `topic_id`, `date`, `content`) '
			. 'VALUES (?, ?, NOW(), ?)'
		);
		$stmt->bind_param('iis', $user_id, $topic_id, $content);
		$stmt->execute();
		$stmt->close();
		return $topic_id;
	}

	function load_posts($mysqli, $topic_id) {
		$msg = '<div id="thread">';

		$stmt = $mysqli->prepare(
			'SELECT `topics`.`title`, '
			. '`topics`.`date`, '
			. '`users`.`displayname` '
			. 'FROM `topics` '
			. 'JOIN `users` ON `topics`.`user_id` = `users`.`id` '
			. 'WHERE `topics`.`id` = ?'
		);
		$stmt->bind_param('i', $topic_id);
		$stmt->bind_result($title, $date, $displayname);
		$stmt->execute();
		$stmt->fetch();

		$msg .= "<h1 class=\"topic\">$title</h1>";

		$stmt->close();

		$stmt = $mysqli->prepare(
			'SELECT `posts`.`content`, '
			. '`posts`.`date`, '
			. '`users`.`displayname` '
			. 'FROM `posts` '
			. 'JOIN `topics` ON `posts`.`topic_id` = `topics`.`id` '
			. 'JOIN `users` ON `posts`.`user_id` = `users`.`id` '
			. 'WHERE `posts`.`topic_id` = ? '
			. 'ORDER BY `posts`.`date`'
		);
		$stmt->bind_param('i', $topic_id);
		$stmt->bind_result($content, $date, $displayname);
		$stmt->execute();

		while ($stmt->fetch()) {
			$msg .=
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
		return $msg;
	}

	function load_topic() {
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

		if (!isset($_GET['id'])) {
			if (!isset($_POST['submit'])) {
				return 'Post not found.';
			}
			$topic_id = submit_post($mysqli);
			header("Location: topic.php?id=$topic_id");
		} else {
			$topic_id = $_GET['id'];
			if (isset($_POST['submit'])) {
				submit_post($mysqli, $topic_id);
			}
		}

		$msg = load_posts($mysqli, $topic_id);
		$mysqli->close();
		return $msg;
	}

	$msg = load_topic();
?>
<html lang="en">
	<head>
		<title>Forum</title>
<!--#include virtual="/include/head.html"-->
	</head>
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php' ?>
		<main>
			<?php echo $msg ?>
<!--#include virtual="/include/reply_form.html"-->
		</main>
<!--#include virtual="/include/footer.html"-->
	</body>
</html>
