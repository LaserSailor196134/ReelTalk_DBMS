CREATE DATABASE IF NOT EXISTS moviedb;

USE moviedb;

CREATE TABLE IF NOT EXISTS account (
    username VARCHAR(50) PRIMARY KEY, 
    password VARCHAR(72) NOT NULL, -- bcrypt hash
    joinDate DATETIME DEFAULT NOW(), -- automatically generated
    adminStatus BOOLEAN DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS bookmark (
    ratingID INT AUTO_INCREMENT PRIMARY KEY,
    watchStatus VARCHAR(10) NOT NULL,
    numberRating INT,
    description VARCHAR(300), -- not sure of the length, should manage max length on front end as well
    dateCreated DATETIME DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS media (
    mediaID INT PRIMARY KEY,
    name VARCHAR(50),
    description VARCHAR(300), -- need to check max length of a description on tmdb
    MPARating VARCHAR(5)
);

CREATE TABLE IF NOT EXISTS movie (
    mediaID INT PRIMARY KEY,
    length INT, -- not sure if this should be an int
    FOREIGN KEY (mediaID) REFERENCES media(mediaID)
);

CREATE TABLE IF NOT EXISTS TVShow (
    mediaID INT PRIMARY KEY,
    episodeCount INT,
    FOREIGN KEY (mediaID) REFERENCES media(mediaID)
);

CREATE TABLE IF NOT EXISTS castCrew (
    actorID INT PRIMARY KEY,
    name VARCHAR(50),
    biography VARCHAR(300) -- once again not sure on the length, check tmdb
);

-- relationships being defined here
CREATE TABLE IF NOT EXISTS CONTRIBUTED (
    mediaID INT,
    actorID INT,
    role VARCHAR(50),
    FOREIGN KEY (mediaID) REFERENCES media(mediaID),
    FOREIGN KEY (actorID) REFERENCES castCrew(actorID)
);

CREATE TABLE IF NOT EXISTS CREATES (
    username VARCHAR(50),
    ratingID INT AUTO_INCREMENT,
    FOREIGN KEY (username) REFERENCES account(username),
    FOREIGN KEY (ratingID) REFERENCES bookmark(ratingID)
);

CREATE TABLE IF NOT EXISTS ABOUT (
    ratingID INT AUTO_INCREMENT,
    mediaID INT,
    FOREIGN KEY (ratingID) REFERENCES bookmark(ratingID),
    FOREIGN KEY (mediaID) REFERENCES media(mediaID)
);

CREATE TABLE IF NOT EXISTS FRIENDS_WITH (

    username1 VARCHAR(50),
    username2 VARCHAR(50), 
    PRIMARY KEY (username1, username2),
    FOREIGN KEY (username1) REFERENCES account(username),
    FOREIGN KEY (username2) REFERENCES account(username)
);