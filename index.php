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
			<div id="topic1" class="topic">
				<a href="topic/1"><h3 class="topic">An example topic</h3></a>
				<p class="detail"><span class="author">Example Author</span> on <span class="date">3/6/2022, 10:15:43 AM</span></p>
			</div>
			<div id="topic2" class="topic">
				<a href="topic/2"><h3 class="topic">Discussion about some obscure topic</h3></a>
				<p class="detail"><span class="author">Verbose Poster</span> on <span class="date">3/6/2022, 10:16:22 AM</span></p>
			</div>
			<div id="topic3" class="topic">
				<a href="topic/3"><h3 class="topic">De finibus bonorum et malorum</h3></a>
				<p class="detail"><span class="author">Cicero</span> on <span class="date">3/6/2022, 10:17:04 AM</span></p>
			</div>
		</main>
<!--#include virtual="/include/footer.html"-->
	</body>
</html>