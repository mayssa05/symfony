<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231028190235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `primary` ON book');
        $this->addSql('ALTER TABLE book CHANGE id ref INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD PRIMARY KEY (ref)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `PRIMARY` ON book');
        $this->addSql('ALTER TABLE book CHANGE ref id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD PRIMARY KEY (id)');
    }
}
