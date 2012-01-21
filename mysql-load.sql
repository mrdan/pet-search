DROP DATABASE petsearch;
CREATE DATABASE petsearch;
USE petsearch;

CREATE TABLE postings(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tags VARCHAR(256),
    photo VARCHAR(256),
    email VARCHAR(256),
    dateadded DATE,
    daterefreshed DATE,
    refreshed INT UNSIGNED
);
CREATE TABLE tags(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tagtext VARCHAR(256),
    category VARCHAR(256)
);

# postings
INSERT INTO postings(tags,photo,email,dateadded,daterefreshed,refreshed) VALUES("dog male microchipped black short-hair",NULL,"daniel.doyle@gmail.com",'2012-01-20','2012-01-20', 0);
INSERT INTO postings(tags,photo,email,dateadded,daterefreshed,refreshed) VALUES("cat male microchipped brown",NULL,"sandra.lyons@fakemail.com",'2012-01-20','2011-06-29', 0);
INSERT INTO postings(tags,photo,email,dateadded,daterefreshed,refreshed) VALUES("dog female not-microchipped short-hair",NULL,"daniel.doyle@gmail.com",'2012-01-20','2012-01-20', 0);
INSERT INTO postings(tags,photo,email,dateadded,daterefreshed,refreshed) VALUES("giraffe male microchipped yellow",NULL,"daniel.doyle@gmail.com",'2012-01-20','2012-01-20', 0);

# species
INSERT INTO tags(tagtext,category) VALUES("dog", "species");
INSERT INTO tags(tagtext,category) VALUES("cat", "species");
INSERT INTO tags(tagtext,category) VALUES("hamster", "species");
INSERT INTO tags(tagtext,category) VALUES("giraffe", "species");

# gender
INSERT INTO tags(tagtext,category) VALUES("male","gender");
INSERT INTO tags(tagtext,category) VALUES("female","gender");

# microchipped
INSERT INTO tags(tagtext,category) VALUES("microchipped","microchipped");
INSERT INTO tags(tagtext,category) VALUES("not-microchipped","microchipped");

# coat
INSERT INTO tags(tagtext,category) VALUES("black", "coat");
INSERT INTO tags(tagtext,category) VALUES("brown", "coat");
INSERT INTO tags(tagtext,category) VALUES("short-hair", "coat");
INSERT INTO tags(tagtext,category) VALUES("long-hair", "coat");
