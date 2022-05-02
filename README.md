# Forum

A basic PHP web forum for the CSCE 464 course project.

## Installation

This site requires SSI support, MariaDB/MySQL, PHP 7, and mysqli.

On Debian, this should get you most of the packages you need:

```sh
apt install php php-fpm php-mysql mariadb
```

Make sure to enable/reload the relevant services in your init system.

### nginx

I recommend nginx as a web server.
To enable PHP and SSI on nginx (based on the default site config file):

- Point nginx's site root to your clone of this repository and check the file permissions
- Uncomment the `location ~ \.php$` block in your site config file
	- Uncomment the first `fastcgi_pass` (for php-fpm)
	- Add `ssi on;`
- Add `index.php` to the `index` directive

### Database

- Create a database named `forum`
- Create a user named `forum` at `localhost` with the password `ah2BSrY3P3pprRrm`
- Give the `forum` user access to the `forum` database
- Import the database schema from this repo: `mysql forum < forum.sql`

For security, make sure to use `forum@localhost` and ensure that logging in from an external client is blocked.

## Features

- Topics and posts submitted by users and persisted with MySQL
- User accounts with a username, password, and display name
- Responsive interface
	- Scales for desktop and mobile use
	- Respects `prefers-color-scheme`
	- Expand and collapse posts
- Localized dates
- Error handling
- Security measures
	- mysqli prepared statements to prevent SQL injection
	- `htmlentities` to sanitize HTML input and prevent cross-site scripting (XSS)
- No frameworks

## Non-Features

As a course project, this forum has very limited scope.
Below are some features that could be added but are not present in this implementation.

- Search
- Email verification of accounts
- User profiles (avatars, bios, etc.)
- Moderation features
- Voting on posts/topics
- Replies to specific posts
- Categories/subforums

## License

All rights reserved until further notice.
