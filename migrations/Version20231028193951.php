<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231028193951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33116A2B381');
        $this->addSql('DROP INDEX IDX_CBE5A33116A2B381 ON book');
        $this->addSql('ALTER TABLE book CHANGE book_id author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331F675F31B ON book (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331F675F31B');
        $this->addSql('DROP INDEX IDX_CBE5A331F675F31B ON book');
        $this->addSql('ALTER TABLE book CHANGE author_id book_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33116A2B381 FOREIGN KEY (book_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A33116A2B381 ON book (book_id)');
    }
}
