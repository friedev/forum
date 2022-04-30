<!DOCTYPE html>
<?php session_start() ?>
<html lang="en">
	<head>
		<title>Discussion about some obscure topic - Forum</title>
<!--#include virtual="/include/head.html"-->
	</head>
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php' ?>
		<main>
			<div id="thread">
				<h1 class="topic">Discussion about some obscure topic</h1>
				<div class="post" onclick="collapse(this);">
					<img src="/user.png" />
					<div>
						<p class="detail"><span class="author">Verbose Poster</span> on <span class="date">3/6/2022, 10:16:22 AM</span>:</p>
						<p class="content">This is a thread for elaborate discussion about a random topic. The purpose of this topic is not only to show a thread with multiple replies, but also, in theory, to discuss some topic. But of course, that won't actually happen because this is just filler text.

						Here is a second paragraph to show that that works. This is probably enough content to demonstrate the point.

						Discuss away!</p>
					</div>
					<p class="collapsed" hidden>(expand)</p>
				</div>
				<hr />
				<div class="post" onclick="collapse(this);">
					<img src="/user.png" />
					<div>
						<p class="detail"><span class="author">Internet Troll</span> on <span class="date">3/6/2022, 10:19:31 AM</span>:</p>
						<p class="content">Your opinion is wrong!</p>
					</div>
					<p class="collapsed" hidden>(expand)</p>
				</div>
				<hr />
				<div class="post" onclick="collapse(this);">
					<img src="/user.png" />
					<div>
						<p class="detail"><span class="author">Verbose Poster</span> on <span class="date">3/6/2022, 10:23:55 AM</span>:</p>
						<p class="content">Thank you for the constructive criticism.</p>
					</div>
					<p class="collapsed" hidden>(expand)</p>
				</div>
				<hr />
			</div>
<!--#include virtual="/include/reply_form.html"-->
		</main>
<!--#include virtual="/include/footer.html"-->
	</body>
</html>