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
			<div id="thread">
			</div>
			<div id="topicFormWrapper">
<!--#include virtual="/include/topic_form.html"-->
			</div>
			<div id="replyFormWrapper" hidden>
<!--#include virtual="/include/reply_form.html"-->
			</div>
		</main>
<!--#include virtual="/include/footer.html"-->
	</body>
</html>
