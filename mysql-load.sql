DROP DATABASE petsearch;
CREATE DATABASE petsearch;
USE petsearch;

CREATE TABLE postings(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tags VARCHAR(256) NOT NULL,
    photo VARCHAR(256) DEFAULT "default.png",
    email VARCHAR(256) NOT NULL,
    daterefreshed TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    refreshed INT DEFAULT 0
);
CREATE TABLE tags(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tag VARCHAR(256) UNIQUE,
    category VARCHAR(256) DEFAULT NULL,
    approved BOOLEAN DEFAULT 0
);
CREATE TABLE flagged(
    id INT UNSIGNED PRIMARY KEY UNIQUE,
    flags INT DEFAULT 0,
    lastflag TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    protected INT DEFAULT 0
);
CREATE TABLE messages(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,
    datesent TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    postingid INT UNSIGNED NOT NULL,
    content VARCHAR(1000) NOT NULL,
    sender VARCHAR(256) NOT NULL
);