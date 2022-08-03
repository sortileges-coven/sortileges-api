<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220803092919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add user / sigil spell relationship';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sigil_spell ADD witch_id INT NOT NULL');
        $this->addSql('ALTER TABLE sigil_spell ADD CONSTRAINT FK_71C05B7AF42ACF52 FOREIGN KEY (witch_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_71C05B7AF42ACF52 ON sigil_spell (witch_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE sigil_spell DROP CONSTRAINT FK_71C05B7AF42ACF52');
        $this->addSql('DROP INDEX IDX_71C05B7AF42ACF52');
        $this->addSql('ALTER TABLE sigil_spell DROP witch_id');
    }
}
