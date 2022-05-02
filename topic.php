<?php session_start() ?>
<?php
# Submit a post with the data found in $_POST
# If $topic_id is -1, create a new topic for this post
# Returns the topic ID of the post, which will have been auto-incremented for
# a new post
function submit_post($mysqli, $topic_id=-1) {
	$user_id = $_SESSION['user_id'];

	# Insert a new topic if no $topic_id was given
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

		# Retrive the auto-incremented topic ID
		$topic_id = $mysqli->insert_id;
	}

	# Insert the post
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

# Load topic and post data and generate the HTML content of the page
function load_posts($mysqli, $topic_id) {
	$msg = '<div id="thread">';

	# Expose $title for use in <title>
	global $title;
	# Select necessary data to generate the topic header
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

	# Generate the topic header
	$msg .= '<h1 class="topic">'
		. htmlentities($title)
		. '</h1>';

	$stmt->close();

	# Select all post data to display
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

	# Generate HTML for each post
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

# Main method for handling submission and retrieval of post data for a topic
function load_topic() {
	# Connect to the database
	# Since the password is stored in plain text, ensure that your MySQL
	# database is configured to only allow connections from localhost
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

	# No ID given: this must be a new topic submission
	if (!isset($_GET['id'])) {
		# No POST data: this is a malformed request
		if (!isset($_POST['submit'])) {
			$mysqli->close();
			return 'Post not found.';
		}
		# POST data found: submit the post and redirect to the created topic page
		$topic_id = submit_post($mysqli);
		header("Location: topic.php?id=$topic_id");
		$mysqli->close();
		die();
	}
	# ID found: load the specified topic
	$topic_id = $_GET['id'];
	# POST data found: submit the post before loading post data
	if (isset($_POST['submit'])) {
		submit_post($mysqli, $topic_id);
	}

	# Load posts and return generated HTML
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
