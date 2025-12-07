DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS movie_category;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS movie_service;

CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(180) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    roles TEXT NOT NULL
);

CREATE TABLE movies (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    description CLOB,
    release_year INTEGER NOT NULL,
    poster_path VARCHAR(255),
    is_adult BOOLEAN NOT NULL DEFAULT 0
);

CREATE TABLE categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE reviews (
     id INTEGER PRIMARY KEY AUTOINCREMENT,
     movie_id INTEGER NOT NULL,
     is_positive BOOLEAN NOT NULL,
     comment CLOB,
     created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
     FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE
);

CREATE TABLE movie_category (
    movie_id INTEGER NOT NULL,
    category_id INTEGER NOT NULL,
    PRIMARY KEY(movie_id, category_id),
    FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE
);

CREATE TABLE services (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    short_name VARCHAR(100) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    logo_path VARCHAR(255)
);

CREATE TABLE movie_service (
   movie_id INTEGER NOT NULL,
   service_id INTEGER NOT NULL,
   PRIMARY KEY(movie_id, service_id),
   FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE,
   FOREIGN KEY (service_id) REFERENCES categories (id) ON DELETE CASCADE
);
