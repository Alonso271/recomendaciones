CREATE DATABASE IF NOT EXISTS movie_recommendations;
USE movie_recommendations;

CREATE TABLE IF NOT EXISTS users(
id              int(255) auto_increment not null,
name            varchar(100),
role            varchar(20),
email           varchar(255),
password        varchar(255),
image           varchar(255),
created_at      datetime,
updated_at      datetime,
remember_token  varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS movies(
id              int(255) auto_increment not null,
title           varchar(100),
image           varchar(20),
description     text,
rate            int(10),
duration        time,
release_year    year,
video           varchar(255),
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_movies PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS genres(
id              int(255) auto_increment not null,
name            varchar(100),
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_genre PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS genre_user(
user_id         int(255),
genre_id        int(255),
created_at      datetime,
updated_at      datetime,
PRIMARY KEY (user_id, genre_id),
FOREIGN KEY (user_id) REFERENCES users(id),
FOREIGN KEY (genre_id) REFERENCES genres(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS genre_movie(
movie_id         int(255),
genre_id         int(255),
created_at       datetime,
updated_at       datetime,
PRIMARY KEY (movie_id, genre_id),
FOREIGN KEY (movie_id) REFERENCES movies(id),
FOREIGN KEY (genre_id) REFERENCES genres(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS recommendations(
id               int(255) auto_increment not null,
user_id          int(255),
movie_id         int(255),
viewed           TINYINT(1) DEFAULT 0,
pending          TINYINT(1) DEFAULT 0,           
created_at       datetime,
updated_at       datetime,
PRIMARY KEY (id),
FOREIGN KEY (movie_id) REFERENCES movies(id),
FOREIGN KEY (user_id) REFERENCES users(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS reviews(
id               int(255) auto_increment not null,
user_id          int(255),
movie_id         int(255),
title            varchar(100),
description      text,
created_at       datetime,
updated_at       datetime,
PRIMARY KEY (id),
FOREIGN KEY (movie_id) REFERENCES movies(id),
FOREIGN KEY (user_id) REFERENCES users(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS providers_link(
id               int(255) auto_increment not null,
movie_id         int(255) not null,
name             varchar(255),
link             varchar(255),
created_at       datetime,
updated_at       datetime,
PRIMARY KEY (id),
FOREIGN KEY (movie_id) REFERENCES movies(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS review_likes(
id               int(255) auto_increment not null,
user_id          int(255) not null,
review_id        int(255) not null,
is_like          TINYINT(1) DEFAULT NULL,
created_at       datetime,
updated_at       datetime,
PRIMARY KEY (id),
FOREIGN KEY (user_id) REFERENCES users(id),
FOREIGN KEY (review_id) REFERENCES reviews(id)
)ENGINE=InnoDb;