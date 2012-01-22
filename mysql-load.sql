DROP DATABASE petsearch;
CREATE DATABASE petsearch;
USE petsearch;

CREATE TABLE postings(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    species VARCHAR(256) NOT NULL,
    tags VARCHAR(256) NOT NULL,
    photo VARCHAR(256) DEFAULT NULL,
    email VARCHAR(256) NOT NULL,
    daterefreshed TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    refreshed INT DEFAULT 0
);
CREATE TABLE tags(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tagtext VARCHAR(256),
    category VARCHAR(256)
);