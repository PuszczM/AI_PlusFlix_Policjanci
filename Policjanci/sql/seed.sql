PRAGMA foreign_keys = OFF;

DELETE FROM reviews;
DELETE FROM movie_category;
DELETE FROM movies;
DELETE FROM categories;
DELETE FROM users;
DELETE FROM services;
DELETE FROM movie_service;

DELETE FROM sqlite_sequence WHERE name='reviews';
DELETE FROM sqlite_sequence WHERE name='movie_category';
DELETE FROM sqlite_sequence WHERE name='movies';
DELETE FROM sqlite_sequence WHERE name='categories';
DELETE FROM sqlite_sequence WHERE name='users';
DELETE FROM sqlite_sequence WHERE name='services';
DELETE FROM sqlite_sequence WHERE name='movie_service';

PRAGMA foreign_keys = ON;

INSERT INTO categories (name) VALUES
    ('Horror'),
    ('Drama'),
    ('Crime'),
    ('Thriller'),
    ('Comedy'),
    ('Sci-Fi'),
    ('Action'),
    ('Series');

INSERT INTO movies (title, description, release_year, poster_path, is_adult) VALUES
     ('The Human Centipede', 'A mad scientist surgically joins people together.', 2009, "/img/posters/human_centipide.png", 1),
     ('Breaking Bad', 'A chemistry teacher turns to making drugs after cancer diagnosis.', 2008, "/img/posters/breaking_bad.png", 0),
     ('Better Call Saul', 'The story of Jimmy McGill becoming Saul Goodman.', 2015, "/img/posters/better_call_saul.png", 0),
     ('Inception', 'A skilled thief enters dreams to steal secrets.', 2010, "/img/posters/inception.png", 0),
     ('The Dark Knight', 'Batman faces the Joker in Gotham.', 2008, "/img/posters/dark_knight.png", 0),
     ('Interstellar', 'A team travels through a wormhole to save humanity.', 2014, "/img/posters/interstellar.png", 0),
     ('The Matrix', 'A hacker discovers reality is a simulation.', 1999, "/img/posters/matrix.png", 0),
     ('Pulp Fiction', 'Intersecting stories of crime in Los Angeles.', 1994, "/img/posters/pulp_fiction.png", 1),
     ('The Shawshank Redemption', 'A man wrongly imprisoned seeks hope and freedom.', 1994, "/img/posters/shawshank_redemption.png", 0),
     ('Stranger Things', 'Kids uncover mysterious events in their town.', 2016, "/img/posters/stranger_things.png", 0);

-- The Human Centipede
INSERT INTO movie_category (movie_id, category_id) VALUES
    ((SELECT id FROM movies WHERE title='The Human Centipede'), (SELECT id FROM categories WHERE name='Horror')),
    ((SELECT id FROM movies WHERE title='The Human Centipede'), (SELECT id FROM categories WHERE name='Thriller'));

-- Breaking Bad
INSERT INTO movie_category (movie_id, category_id) VALUES
   ((SELECT id FROM movies WHERE title='Breaking Bad'), (SELECT id FROM categories WHERE name='Drama')),
   ((SELECT id FROM movies WHERE title='Breaking Bad'), (SELECT id FROM categories WHERE name='Crime')),
   ((SELECT id FROM movies WHERE title='Breaking Bad'), (SELECT id FROM categories WHERE name='Series'));

-- Better Call Saul
INSERT INTO movie_category (movie_id, category_id) VALUES
   ((SELECT id FROM movies WHERE title='Better Call Saul'), (SELECT id FROM categories WHERE name='Drama')),
   ((SELECT id FROM movies WHERE title='Better Call Saul'), (SELECT id FROM categories WHERE name='Crime')),
   ((SELECT id FROM movies WHERE title='Better Call Saul'), (SELECT id FROM categories WHERE name='Series'));

-- Inception
INSERT INTO movie_category (movie_id, category_id) VALUES
   ((SELECT id FROM movies WHERE title='Inception'), (SELECT id FROM categories WHERE name='Sci-Fi')),
   ((SELECT id FROM movies WHERE title='Inception'), (SELECT id FROM categories WHERE name='Action')),
   ((SELECT id FROM movies WHERE title='Inception'), (SELECT id FROM categories WHERE name='Thriller'));

-- The Dark Knight
INSERT INTO movie_category (movie_id, category_id) VALUES
   ((SELECT id FROM movies WHERE title='The Dark Knight'), (SELECT id FROM categories WHERE name='Action')),
   ((SELECT id FROM movies WHERE title='The Dark Knight'), (SELECT id FROM categories WHERE name='Crime')),
   ((SELECT id FROM movies WHERE title='The Dark Knight'), (SELECT id FROM categories WHERE name='Drama'));

-- Interstellar
INSERT INTO movie_category (movie_id, category_id) VALUES
   ((SELECT id FROM movies WHERE title='Interstellar'), (SELECT id FROM categories WHERE name='Sci-Fi')),
   ((SELECT id FROM movies WHERE title='Interstellar'), (SELECT id FROM categories WHERE name='Drama'));

-- The Matrix
INSERT INTO movie_category (movie_id, category_id) VALUES
    ((SELECT id FROM movies WHERE title='The Matrix'), (SELECT id FROM categories WHERE name='Sci-Fi')),
    ((SELECT id FROM movies WHERE title='The Matrix'), (SELECT id FROM categories WHERE name='Action'));

-- Pulp Fiction
INSERT INTO movie_category (movie_id, category_id) VALUES
    ((SELECT id FROM movies WHERE title='Pulp Fiction'), (SELECT id FROM categories WHERE name='Crime')),
    ((SELECT id FROM movies WHERE title='Pulp Fiction'), (SELECT id FROM categories WHERE name='Drama'));

-- The Shawshank Redemption
INSERT INTO movie_category (movie_id, category_id) VALUES
    ((SELECT id FROM movies WHERE title='The Shawshank Redemption'), (SELECT id FROM categories WHERE name='Drama'));

-- Stranger Things
INSERT INTO movie_category (movie_id, category_id) VALUES
    ((SELECT id FROM movies WHERE title='Stranger Things'), (SELECT id FROM categories WHERE name='Series')),
    ((SELECT id FROM movies WHERE title='Stranger Things'), (SELECT id FROM categories WHERE name='Sci-Fi')),
    ((SELECT id FROM movies WHERE title='Stranger Things'), (SELECT id FROM categories WHERE name='Thriller'));

-- Breaking Bad
INSERT INTO reviews (movie_id, is_positive, comment) VALUES
    ((SELECT id FROM movies WHERE title='Breaking Bad'), 1,
    'Walter White cooked Heisenburger.'),
    ((SELECT id FROM movies WHERE title='Breaking Bad'), 1,
    'Vravo Bince!');

-- Better Call Saul
INSERT INTO reviews (movie_id, is_positive, comment) VALUES
     ((SELECT id FROM movies WHERE title='Better Call Saul'), 1,
      'I would let Saul Goodman represent me even if I was guilty. Especially if I was guilty.'),
     ((SELECT id FROM movies WHERE title='Better Call Saul'), 1,
      'Best CRIMINAL lawyer ever');

-- The Matrix
INSERT INTO reviews (movie_id, is_positive, comment) VALUES
     ((SELECT id FROM movies WHERE title='The Matrix'), 1,
      'The Matrix is the most accidentally-trans-then-intentionally-trans masterpiece ever. Slay, Neo!'),
     ((SELECT id FROM movies WHERE title='The Matrix'), 1,
      'This movie invented red pills BEFORE the internet ruined the metaphor');

-- The Dark Knight
INSERT INTO reviews (movie_id, is_positive, comment) VALUES
     ((SELECT id FROM movies WHERE title='The Dark Knight'), 1,
      'We live in a society% world record attempt.'),
     ((SELECT id FROM movies WHERE title='The Dark Knight'), 0,
      'I tried to become the Joker after watching this. Did not work. Landlord still wants rent...');

-- Inception
INSERT INTO reviews (movie_id, is_positive, comment) VALUES
    ((SELECT id FROM movies WHERE title='Inception'), 1,
     'Was dreaming that I understood the plot. Woke up confused again 10/10');

-- Interstellar
INSERT INTO reviews (movie_id, is_positive, comment) VALUES
     ((SELECT id FROM movies WHERE title='Interstellar'), 1,
      'Cried at the bookshelf scene'),
     ((SELECT id FROM movies WHERE title='Interstellar'), 0,
      'No amogus :(');

-- Pulp Fiction
INSERT INTO reviews (movie_id, is_positive, comment) VALUES
    ((SELECT id FROM movies WHERE title='Pulp Fiction'), 0,
     'I did not watch this');

-- Stranger Things
INSERT INTO reviews (movie_id, is_positive, comment) VALUES
     ((SELECT id FROM movies WHERE title='Stranger Things'), 1,
      'Kids fighting monsters while adults argue. Peak parenting.'),
     ((SELECT id FROM movies WHERE title='Stranger Things'), 0,
      'Ohio irl is better');

-- The Human Centipede
INSERT INTO reviews (movie_id, is_positive, comment) VALUES
    ((SELECT id FROM movies WHERE title='The Human Centipede'), 0,
    'I wish I could uninstall this movie from my brain'),
    ((SELECT id FROM movies WHERE title='The Human Centipede'), 0,
    'Woke');

INSERT INTO users (id, username, password, roles)
VALUES (NULL, 'admin', '$2y$10$bgac6DAFHPSbhXfYFwqcheLCc3RYGvV8Z7PGzoPFx/KzCGY02J0NK', '["ROLE_ADMIN"]');

INSERT INTO services (short_name, full_name, logo_path) VALUES
   ('apple', 'Apple TV+', "/img/service/apple.png"),
   ('disney', 'Disney Plus', "/img/service/disney.png"),
   ('hbo', 'HBO Max', "/img/service/hbo.png"),
   ('netflix', 'Netflix', "/img/service/netflix.png"),
   ('prime', 'Prime Video', "/img/service/prime.png"),
   ('skyshowtime', 'SkyShowtime', "/img/service/skyshowtime.png");

-- The Human Centipede
INSERT INTO movie_service (movie_id, service_id) VALUES
    ((SELECT id FROM movies WHERE title='The Human Centipede'),
    (SELECT id FROM services WHERE short_name='hbo'));

-- Breaking Bad
INSERT INTO movie_service (movie_id, service_id) VALUES
    ((SELECT id FROM movies WHERE title='Breaking Bad'),
    (SELECT id FROM services WHERE short_name='netflix'));

-- Better Call Saul
INSERT INTO movie_service (movie_id, service_id) VALUES
    ((SELECT id FROM movies WHERE title='Better Call Saul'),
    (SELECT id FROM services WHERE short_name='netflix')),
    ((SELECT id FROM movies WHERE title='Better Call Saul'),
    (SELECT id FROM services WHERE short_name='prime'));

-- Inception
INSERT INTO movie_service (movie_id, service_id) VALUES
    ((SELECT id FROM movies WHERE title='Inception'),
    (SELECT id FROM services WHERE short_name='apple')),
    ((SELECT id FROM movies WHERE title='Inception'),
    (SELECT id FROM services WHERE short_name='prime'));

-- The Dark Knight
INSERT INTO movie_service (movie_id, service_id) VALUES
    ((SELECT id FROM movies WHERE title='The Dark Knight'),
    (SELECT id FROM services WHERE short_name='hbo')),
    ((SELECT id FROM movies WHERE title='The Dark Knight'),
    (SELECT id FROM services WHERE short_name='apple'));

-- Interstellar
INSERT INTO movie_service (movie_id, service_id) VALUES
    ((SELECT id FROM movies WHERE title='Interstellar'),
    (SELECT id FROM services WHERE short_name='prime')),
    ((SELECT id FROM movies WHERE title='Interstellar'),
    (SELECT id FROM services WHERE short_name='skyshowtime'));

-- The Matrix
INSERT INTO movie_service (movie_id, service_id) VALUES
    ((SELECT id FROM movies WHERE title='The Matrix'),
    (SELECT id FROM services WHERE short_name='hbo')),
    ((SELECT id FROM movies WHERE title='The Matrix'),
    (SELECT id FROM services WHERE short_name='prime'));

-- Pulp Fiction
INSERT INTO movie_service (movie_id, service_id) VALUES
     ((SELECT id FROM movies WHERE title='Pulp Fiction'),
      (SELECT id FROM services WHERE short_name='prime')),
     ((SELECT id FROM movies WHERE title='Pulp Fiction'),
      (SELECT id FROM services WHERE short_name='hbo'));

-- The Shawshank Redemption
INSERT INTO movie_service (movie_id, service_id) VALUES
    ((SELECT id FROM movies WHERE title='The Shawshank Redemption'),
    (SELECT id FROM services WHERE short_name='netflix')),
    ((SELECT id FROM movies WHERE title='The Shawshank Redemption'),
    (SELECT id FROM services WHERE short_name='prime'));

-- Stranger Things
INSERT INTO movie_service (movie_id, service_id) VALUES
    ((SELECT id FROM movies WHERE title='Stranger Things'),
     (SELECT id FROM services WHERE short_name='netflix'));
