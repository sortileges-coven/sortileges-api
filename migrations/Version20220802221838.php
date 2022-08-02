<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220802221838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create sigil spells table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE sigil_spell_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE sigil_spell (id INT NOT NULL, target VARCHAR(255) NOT NULL, short_target VARCHAR(255) DEFAULT NULL, content VARCHAR(1500) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE sigil_spell_id_seq CASCADE');
        $this->addSql('DROP TABLE sigil_spell');
    }
}
