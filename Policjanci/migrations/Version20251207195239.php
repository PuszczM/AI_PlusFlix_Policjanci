<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251207195239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__categories AS SELECT id, name FROM categories');
        $this->addSql('DROP TABLE categories');
        $this->addSql('CREATE TABLE categories (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL COLLATE "NOCASE")');
        $this->addSql('INSERT INTO categories (id, name) SELECT id, name FROM __temp__categories');
        $this->addSql('DROP TABLE __temp__categories');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AF346685E237E06 ON categories (name)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__movies AS SELECT id, title, description, release_year, poster_path, is_adult FROM movies');
        $this->addSql('DROP TABLE movies');
        $this->addSql('CREATE TABLE movies (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE "NOCASE", description CLOB DEFAULT NULL, release_year INTEGER NOT NULL, poster_path VARCHAR(255) DEFAULT NULL, is_adult BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO movies (id, title, description, release_year, poster_path, is_adult) SELECT id, title, description, release_year, poster_path, is_adult FROM __temp__movies');
        $this->addSql('DROP TABLE __temp__movies');
        $this->addSql('CREATE TEMPORARY TABLE __temp__services AS SELECT id, short_name, full_name, logo_path FROM services');
        $this->addSql('DROP TABLE services');
        $this->addSql('CREATE TABLE services (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, short_name VARCHAR(100) NOT NULL COLLATE "NOCASE", full_name VARCHAR(100) NOT NULL, logo_path VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO services (id, short_name, full_name, logo_path) SELECT id, short_name, full_name, logo_path FROM __temp__services');
        $this->addSql('DROP TABLE __temp__services');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7332E1693EE4B093 ON services (short_name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
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
        $this->addSql('CREATE TEMPORARY TABLE __temp__services AS SELECT id, short_name, full_name, logo_path FROM services');
        $this->addSql('DROP TABLE services');
        $this->addSql('CREATE TABLE services (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, short_name VARCHAR(100) NOT NULL, full_name VARCHAR(100) NOT NULL, logo_path VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO services (id, short_name, full_name, logo_path) SELECT id, short_name, full_name, logo_path FROM __temp__services');
        $this->addSql('DROP TABLE __temp__services');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7332E1693EE4B093 ON services (short_name)');
    }
}
