<!DOCTYPE html>
<?php session_start() ?>
<html lang="en">
	<head>
		<title>Example Topic - Forum</title>
<!--#include virtual="/include/head.html"-->
	</head>
<!--#include virtual="/include/head.html"-->
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php' ?>
		<main>
			<div id="thread">
				<h1 class="topic">Example Topic</h1>
				<div class="post" onclick="collapse(this);">
					<img src="/user.png" />
					<div>
						<p class="detail"><span class="author">Example Author</span> on <span class="date">3/6/2022, 10:15:43 AM</span>:</p>
						<p class="content">This is a sentence in the body of this post. Eventually, it will be possible to submit topics and supply this text via a web form. Initially, the text will just be displayed on the client side. This will not allow any sort of actual discussion, but will nonetheless involve some JavaScript logic. Later, the post submissions will be stored persistently on the server side.</p>
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
