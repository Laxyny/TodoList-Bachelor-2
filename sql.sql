CREATE DATABASE mistigchat;
USE mistigchat;


CREATE TABLE `users` (
    `userId` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL,
    `user` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `gender` ENUM('male', 'female'),
    `birthday` DATE,
    `location` VARCHAR(255),
    `photoUrl` VARCHAR(255)NOT NULL DEFAULT 'https://sbcf.fr/wp-content/uploads/2018/03/sbcf-default-avatar.png',
    `online` ENUM('yes', 'no') DEFAULT 'no',
    `role` ENUM('admin', 'user') DEFAULT 'user'
);

CREATE TABLE `chatRooms` (
    `chatroomId` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `photoUrl` VARCHAR(255) NOT NULL DEFAULT 'https://sbcf.fr/wp-content/uploads/2018/03/sbcf-default-avatar.png',
    `totalUsers` INT,
    `private` ENUM('yes', 'no') DEFAULT 'no'
);

CREATE TABLE `chats` (
    `chatId` INT AUTO_INCREMENT PRIMARY KEY,
    `privateMessage` ENUM('yes', 'no'),
    `chatroomId` INT,
    `userId` INT,
    `message` VARCHAR(255),
    `image` VARCHAR(255),
    `date` DATE NOT NULL,
    FOREIGN KEY (`chatroomId`) REFERENCES `chatRooms`(`chatroomId`),
    FOREIGN KEY (`userId`) REFERENCES `users`(`userId`)
);

CREATE TABLE `bans` (
    `banId` INT AUTO_INCREMENT PRIMARY KEY,
    `userId` INT,
    `reason` VARCHAR(255),
    `date` DATE NOT NULL,
    FOREIGN KEY (`userId`) REFERENCES `users`(`userId`)
);

CREATE USER 'mistigchat'@'localhost' IDENTIFIED BY 'GxQPTyZ3RpTNMsMpS5';
GRANT ALL PRIVILEGES ON `mistigchat`.* TO 'mistigchat'@'localhost';
FLUSH PRIVILEGES;
