<?php session_start() ?>
<?php
# Loads all topic data to display on the index page
function load_topics() {
	# Connect to the database
	# Since the password is stored in plain text, ensure that your MySQL
	# database is configured to only allow connections from localhost
	$mysqli = new mysqli('localhost', 'forum', 'ah2BSrY3P3pprRrm', 'forum');
	if ($mysqli->connect_errno) {
		return '<p class="error">Database connection failed; try again later.</p>';
	}

	# Get all necessary topic metadata to display the index
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

	# Generate the index and store it to the $msg buffer
	$msg = '';
	while ($stmt->fetch()) {
		$msg .=
			'<div class="topic">'
			. "<a href=\"topic.php?id=$id\">"
			. '<h3 class="topic">'
			. htmlentities($title)
			. '</h3>'
			. '</a>'
			. '<p class="detail">'
			. '<span class="user">'
			. htmlentities($displayname)
			. '</span>'
			. ' on '
			. '<span class="date">'
			. date_format(date_create($date), 'c')
			. '</span>'
			. '</p>'
			. '</div>';
	}

	$stmt->close();
	$mysqli->close();
	return $msg;
}
$msg = load_topics();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Forum</title>
<!--#include virtual="/include/head.html"-->
	</head>
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php' ?>
		<main>
			<?php echo $msg ?>
		</main>
<!--#include virtual="/include/footer.html"-->
	</body>
</html>
