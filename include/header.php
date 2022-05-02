		<header>
			<a class="title" href="/">
				<h1 class="title">Forum</h1>
			</a>
			<p>
				<?php
					if (empty($_SESSION['username'])) {
						echo
							'<a href="/login">'
							. 'Log In'
							. '</a> '
							. '<a class="button" href="/register">'
							. 'Register'
							. '</a>';
					} else {
						echo
							'Logged in as '
							. '<span class="user">'
							. $_SESSION['displayname']
							. '</span>'
							. ' ('
							. '<a href="/logout">'
							. 'Log Out'
							. '</a>'
							. ') '
							. '<a class="button" href="/new">'
							. 'New Topic'
							. '</a>';
					}
				?>
			</p>
		</header>
		<hr />
