CREATE DATABASE IF NOT EXISTS moviedb;

\c moviedb

CREATE TABLE IF NOT EXISTS account (
    username VARCHAR(50) PRIMARY KEY, 
    password VARCHAR(50) NOT NULL, --need to figure out hashing
    joinDate Date NOT NULL
);

CREATE TABLE IF NOT EXISTS admin (

) INHERITS (account);

CREATE TABLE IF NOT EXISTS user ( 
    -- friendCount INT, derived attribute
    -- reviewCount INT, derived attribute
--postgresql allows for automatically computing values for derived attributes, maybe try that later
) INHERITS (account);

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
    --aggregateRating FLOAT, this is derived
    MPARating VARCHAR(5)
);

CREATE TABLE IF NOT EXISTS movie (
    length int, -- not sure if this should be an int
) INHERITS (media);

CREATE TABLE IF NOT EXISTS TVShow (
    episodeCount int
) INHERIIS (media);

CREATE TABLE IF NOT EXISTS castCrew (
    actorID INT PRIMARY KEY,
    name VARCHAR(50),
    biography VARCHAR(300) -- once again not sure on the length, check tmdb
);