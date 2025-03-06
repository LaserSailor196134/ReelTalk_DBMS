IF NOT EXISTS CREATE DATABASE moviedb;

USE moviedb;

IF NOT EXISTS CREATE TABLE account {
    username VARCHAR(50) PRIMARY KEY, 
    password VARCHAR(50) NOT NULL, --need to figure out hashing
    joinDate Date NOT NULL
};

IF NOT EXISTS CREATE TABLE admin : account {

};

IF NOT EXISTS CREATE TABLE user : account {
    friendCount INT NOT NULL,
    reviewCount INT NOT NULL
};

IF NOT EXISTS CREATE TABLE bookmark {
    ratingID INT PRIMARY KEY,
    watchStatus VARCHAR(10) NOT NULL,
    numberRating INT,
    description VARCHAR(300), -- not sure of the length, should manage max length on front end as well
    dateCreated DATE NOT NULL
};

IF NOT EXISTS CREATE TABLE media {
    mediaID INT PRIMARY KEY,
    name VARCHAR(50),
    description VARCHAR(300), -- need to check max length of a description on tmdb
    aggregateRating FLOAT,
    MPARating VARCHAR(5)
};

IF NOT EXISTS CREATE TABLE movie : media {
    length int, -- not sure if this should be an int
};

IF NOT EXISTS CREATE TABLE TVShow : media {
    episodeCount int
};

IF NOT EXISTS CREATE TABLE castCrew {
    actorID INT PRIMARY KEY,
    name VARCHAR(50),
    biography VARCHAR(300) -- once again not sure on the length, check tmdb
};