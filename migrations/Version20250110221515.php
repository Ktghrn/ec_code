<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250110221515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD rating DOUBLE PRECISION DEFAULT NULL, ADD completed TINYINT(1) NOT NULL, CHANGE category_id category_id INT NOT NULL');
        $this->addSql('ALTER TABLE book_read CHANGE book_id book_id INT NOT NULL');
        $this->addSql('ALTER TABLE book_read ADD CONSTRAINT FK_81CA0A6F16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_81CA0A6F16A2B381 ON book_read (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP rating, DROP completed, CHANGE category_id category_id BIGINT NOT NULL');
        $this->addSql('ALTER TABLE book_read DROP FOREIGN KEY FK_81CA0A6F16A2B381');
        $this->addSql('DROP INDEX IDX_81CA0A6F16A2B381 ON book_read');
        $this->addSql('ALTER TABLE book_read CHANGE book_id book_id BIGINT NOT NULL');
    }
}