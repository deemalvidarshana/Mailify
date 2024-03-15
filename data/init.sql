CREATE DATABASE msg;

USE msg;

CREATE TABLE message (
	reciver VARCHAR(30) NOT NULL,
	email VARCHAR(50) NOT NULL, 
	nameSender VARCHAR(30) NOT NULL,
	nameReciver VARCHAR(30) NOT NULL,
	date TIMESTAMP
);

ALTER TABLE message
	ADD COLUMN id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	ADD COLUMN sender VARCHAR(30) NOT NULL;

CREATE TABLE files  (
	filesId INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(30), 
	description VARCHAR(50),
	CreatedDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create an index on the "title" column of the "files" table
CREATE INDEX idx_title ON files (title);

CREATE TABLE  message_files(
	messagefilesId INT PRIMARY KEY AUTO_INCREMENT,
	filesId INT(11) UNSIGNED,
	FOREIGN KEY (filesId) REFERENCES files(filesId),
	id INT(11) UNSIGNED,
	FOREIGN KEY (id) REFERENCES message(id)
);
