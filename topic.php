<?php session_start() ?>
<?php
	function submit_post($mysqli, $topic_id=-1) {
		$user_id = $_SESSION['user_id'];
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

		# Expose $title for use in <title>
		global $title;
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

		$msg .= '<h1 class="topic">'
			. htmlentities($title)
			. '</h1>';

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
				. '<div class="content">'
				. '<p class="detail">'
				. '<span class="user">'
				. htmlentities($displayname)
				. '</span>'
				. ' on '
				. '<span class="date">'
				. date_format(date_create($date), 'c')
				. '</span>'
				. ':'
				. '</p>'
				. '<p class="content">'
				. htmlentities($content)
				. '</p>'
				. '</div>'
				. '<p class="collapsed" hidden>'
				. '(expand)'
				. '</p>'
				. '</div>';
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
			$mysqli->close();
			die();
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
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo htmlentities($title) ?> - Forum</title>
<!--#include virtual="/include/head.html"-->
	</head>
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php' ?>
		<main>
			<?php echo $msg ?>
			<?php if (isset($_SESSION['username'])): ?>
			<h2 id="formName">Reply</h2>
			<form id="replyForm" name="replyForm" method="post">
				<textarea class="text" name="content" rows="8" required></textarea><br />
				<input class="submit" type="submit" name="submit" value="Post" />
			</form>
			<?php else: ?>
			<p><a href="/login">Log in</a> or <a href="/register">register</a> to post a reply.</p>
			<?php endif; ?>
		</main>
<!--#include virtual="/include/footer.html"-->
	</body>
</html>
