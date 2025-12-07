<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251207172154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE services (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, short_name VARCHAR(100) NOT NULL, full_name VARCHAR(100) NOT NULL, logo_path VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7332E1693EE4B093 ON services (short_name)');
        $this->addSql('CREATE TABLE movie_service (service_id INTEGER NOT NULL, movie_id INTEGER NOT NULL, PRIMARY KEY (service_id, movie_id), CONSTRAINT FK_C10BD8FCED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C10BD8FC8F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C10BD8FCED5CA9E6 ON movie_service (service_id)');
        $this->addSql('CREATE INDEX IDX_C10BD8FC8F93B6FC ON movie_service (movie_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__categories AS SELECT id, name FROM categories');
        $this->addSql('DROP TABLE categories');
        $this->addSql('CREATE TABLE categories (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL)');
        $this->addSql('INSERT INTO categories (id, name) SELECT id, name FROM __temp__categories');
        $this->addSql('DROP TABLE __temp__categories');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AF346685E237E06 ON categories (name)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__movies AS SELECT id, title, description, release_year, poster_path, is_adult FROM movies');
        $this->addSql('DROP TABLE movies');
        $this->addSql('CREATE TABLE movies (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, release_year INTEGER NOT NULL, poster_path VARCHAR(255) DEFAULT NULL, is_adult BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO movies (id, title, description, release_year, poster_path, is_adult) SELECT id, title, description, release_year, poster_path, is_adult FROM __temp__movies');
        $this->addSql('DROP TABLE __temp__movies');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reviews AS SELECT id, movie_id, is_positive, comment, created_at FROM reviews');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('CREATE TABLE reviews (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, movie_id INTEGER NOT NULL, is_positive BOOLEAN NOT NULL, comment CLOB DEFAULT NULL, created_at DATETIME NOT NULL, FOREIGN KEY (movie_id) REFERENCES movies (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reviews (id, movie_id, is_positive, comment, created_at) SELECT id, movie_id, is_positive, comment, created_at FROM __temp__reviews');
        $this->addSql('DROP TABLE __temp__reviews');
        $this->addSql('CREATE INDEX IDX_6970EB0F8F93B6FC ON reviews (movie_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__users AS SELECT id, username, password, roles FROM users');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL)');
        $this->addSql('INSERT INTO users (id, username, password, roles) SELECT id, username, password, roles FROM __temp__users');
        $this->addSql('DROP TABLE __temp__users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE movie_service');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('CREATE TEMPORARY TABLE __temp__categories AS SELECT id, name FROM categories');
        $this->addSql('DROP TABLE categories');
        $this->addSql('CREATE TABLE categories (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, name VARCHAR(100) NOT NULL)');
        $this->addSql('INSERT INTO categories (id, name) SELECT id, name FROM __temp__categories');
        $this->addSql('DROP TABLE __temp__categories');
        $this->addSql('CREATE TEMPORARY TABLE __temp__movies AS SELECT id, title, description, release_year, poster_path, is_adult FROM movies');
        $this->addSql('DROP TABLE movies');
        $this->addSql('CREATE TABLE movies (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, release_year INTEGER NOT NULL, poster_path VARCHAR(255) DEFAULT NULL, is_adult BOOLEAN DEFAULT 0 NOT NULL)');
        $this->addSql('INSERT INTO movies (id, title, description, release_year, poster_path, is_adult) SELECT id, title, description, release_year, poster_path, is_adult FROM __temp__movies');
        $this->addSql('DROP TABLE __temp__movies');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reviews AS SELECT id, is_positive, comment, created_at, movie_id FROM reviews');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('CREATE TABLE reviews (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, is_positive BOOLEAN NOT NULL, comment CLOB DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, movie_id INTEGER NOT NULL, CONSTRAINT FK_6970EB0F8F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reviews (id, is_positive, comment, created_at, movie_id) SELECT id, is_positive, comment, created_at, movie_id FROM __temp__reviews');
        $this->addSql('DROP TABLE __temp__reviews');
        $this->addSql('CREATE INDEX IDX_6970EB0F8F93B6FC ON reviews (movie_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__users AS SELECT id, username, password, roles FROM users');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL)');
        $this->addSql('INSERT INTO users (id, username, password, roles) SELECT id, username, password, roles FROM __temp__users');
        $this->addSql('DROP TABLE __temp__users');
    }
}
