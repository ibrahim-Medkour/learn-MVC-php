CREATE DATABASE gestion_films CHARACTER
SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE gestion_films;

CREATE TABLE genres (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

INSERT INTO genres (nom)
VALUES ('Action'),
    ('Comedie'),
    ('Drame'),
    ('Science-fiction'),
    ('Horreur'),
    ('Romance'),
    ('Animation'),
    ('Documentaire'),
    ('Aventure'),
    ('Thriller');