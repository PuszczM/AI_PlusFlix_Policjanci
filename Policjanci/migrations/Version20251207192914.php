<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251207192914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AF346685E237E06 ON categories (name)');
        $this->addSql('CREATE TABLE movies (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, release_year INTEGER NOT NULL, poster_path VARCHAR(255) DEFAULT NULL, is_adult BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE movie_category (movie_id INTEGER NOT NULL, category_id INTEGER NOT NULL, PRIMARY KEY (movie_id, category_id), CONSTRAINT FK_DABA824C8F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DABA824C12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_DABA824C8F93B6FC ON movie_category (movie_id)');
        $this->addSql('CREATE INDEX IDX_DABA824C12469DE2 ON movie_category (category_id)');
        $this->addSql('CREATE TABLE movie_service (movie_id INTEGER NOT NULL, service_id INTEGER NOT NULL, PRIMARY KEY (movie_id, service_id), CONSTRAINT FK_C10BD8FC8F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C10BD8FCED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C10BD8FC8F93B6FC ON movie_service (movie_id)');
        $this->addSql('CREATE INDEX IDX_C10BD8FCED5CA9E6 ON movie_service (service_id)');
        $this->addSql('CREATE TABLE reviews (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, is_positive BOOLEAN NOT NULL, comment CLOB DEFAULT NULL, created_at DATETIME NOT NULL, movie_id INTEGER NOT NULL, CONSTRAINT FK_6970EB0F8F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6970EB0F8F93B6FC ON reviews (movie_id)');
        $this->addSql('CREATE TABLE services (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, short_name VARCHAR(100) NOT NULL, full_name VARCHAR(100) NOT NULL, logo_path VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7332E1693EE4B093 ON services (short_name)');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE movies');
        $this->addSql('DROP TABLE movie_category');
        $this->addSql('DROP TABLE movie_service');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
