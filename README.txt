Run this SQL Query to create the table on a database called 'eoj'

CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `email` varchar(255) NOT NULL,
 `username` varchar(50) NOT NULL,
 `password` varchar(255) NOT NULL,
 `created_at` datetime DEFAULT current_timestamp(),
 `otp` int(11) NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4