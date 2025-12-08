<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251208212505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reviews ADD COLUMN username CLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__reviews AS SELECT id, is_positive, comment, created_at, movie_id FROM reviews');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('CREATE TABLE reviews (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, is_positive BOOLEAN NOT NULL, comment CLOB DEFAULT NULL, created_at DATETIME NOT NULL, movie_id INTEGER NOT NULL, CONSTRAINT FK_6970EB0F8F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reviews (id, is_positive, comment, created_at, movie_id) SELECT id, is_positive, comment, created_at, movie_id FROM __temp__reviews');
        $this->addSql('DROP TABLE __temp__reviews');
        $this->addSql('CREATE INDEX IDX_6970EB0F8F93B6FC ON reviews (movie_id)');
    }
}
