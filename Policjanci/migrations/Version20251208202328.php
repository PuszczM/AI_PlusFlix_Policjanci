<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251208202328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movies ADD COLUMN positive_reviews_count INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE movies ADD COLUMN all_reviews_count INTEGER DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__movies AS SELECT id, title, description, release_year, country, is_series, poster_path, is_adult FROM movies');
        $this->addSql('DROP TABLE movies');
        $this->addSql('CREATE TABLE movies (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE "NOCASE", description CLOB DEFAULT NULL, release_year INTEGER NOT NULL, country VARCHAR(255) DEFAULT NULL COLLATE "NOCASE", is_series BOOLEAN DEFAULT NULL, poster_path VARCHAR(255) DEFAULT NULL, is_adult BOOLEAN DEFAULT NULL)');
        $this->addSql('INSERT INTO movies (id, title, description, release_year, country, is_series, poster_path, is_adult) SELECT id, title, description, release_year, country, is_series, poster_path, is_adult FROM __temp__movies');
        $this->addSql('DROP TABLE __temp__movies');
    }
}
