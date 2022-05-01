CREATE TABLE `users` (
	`id` int NOT NULL AUTO_INCREMENT,
	`username` varchar(255) UNIQUE NOT NULL,
	`password` varchar(255) NOT NULL,
	`displayname` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `topics` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`date` datetime NOT NULL,
	`title` varchar(255) NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `posts` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`topic_id` int NOT NULL,
	`date` datetime NOT NULL,
	`content` text NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
	FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`)
);
