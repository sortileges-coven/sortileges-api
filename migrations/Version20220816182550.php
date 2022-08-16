<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220816182550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add user pseudo field';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD pseudo VARCHAR(127)');
        $this->addSql('UPDATE "user" SET pseudo = email');
        $this->addSql('ALTER TABLE "user" ALTER COLUMN pseudo SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT unique_pseudo UNIQUE (pseudo)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP pseudo');
    }
}
