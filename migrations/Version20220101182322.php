<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220101182322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat ADD id_achateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456AFF7852 FOREIGN KEY (id_achateur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_26A98456AFF7852 ON achat (id_achateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456AFF7852');
        $this->addSql('DROP INDEX IDX_26A98456AFF7852 ON achat');
        $this->addSql('ALTER TABLE achat DROP id_achateur_id');
    }
}
