
CREATE DATABASE moviedb IF NOT EXISTS;

USE moviedb;

CREATE TABLE IF NOT EXISTS account (
    username VARCHAR(50) PRIMARY KEY, 
    password VARCHAR(50) NOT NULL, --figure out hashing
    joinDate DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS admin (
    username VARCHAR(50) PRIMARY KEY, 
    FOREIGN KEY (username) REFERENCES account(username)
);

CREATE TABLE IF NOT EXISTS user (
    username VARCHAR(50) PRIMARY KEY, 
    -- friendCount INT, derived attribute
    -- reviewCount INT, derived attribute
--postgresql allows for automatically computing values for derived attributes, maybe try that later
    FOREIGN KEY (username) REFERENCES account(username)
);

CREATE TABLE IF NOT EXISTS bookmark (
    ratingID SERIAL PRIMARY KEY,
    watchStatus VARCHAR(10) NOT NULL,
    numberRating INT,
    description VARCHAR(300), -- not sure of the length, should manage max length on front end as well
    dateCreated DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS media (
    mediaID INT PRIMARY KEY,
    name VARCHAR(50),
    description VARCHAR(300), -- need to check max length of a description on tmdb
    MPARating VARCHAR(5)
);

CREATE TABLE IF NOT EXISTS movie (
    mediaID INT PRIMARY KEY,
    length int, -- not sure if this should be an int
    FOREIGN KEY (mediaID) REFERENCES media(mediaID)
);

CREATE TABLE IF NOT EXISTS TVShow (
    mediaID INT PRIMARY KEY,
    episodeCount int,
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
    ratingID INT,
    FOREIGN KEY (username) REFERENCES user(username),
    FOREIGN KEY (ratingID) REFERENCES bookmark(ratingID)
);

CREATE TABLE IF NOT EXISTS ABOUT (
    ratingID INT,
    mediaID INT,
    FOREIGN KEY (ratingID) REFERENCES bookmark(ratingID),
    FOREIGN KEY (mediaID) REFERENCES media(mediaID)
);

CREATE TABLE IF NOT EXISTS FRIENDS_WITH (
    username1 VARCHAR(50),
    username2 VARCHAR(50), 
    FOREIGN KEY (username1) REFERENCES user(username),
    FOREIGN KEY (username2) REFERENCES user(username)
)