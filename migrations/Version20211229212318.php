<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211229212318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commannde ADD id_acheteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commannde ADD CONSTRAINT FK_D58C29EA8EB576A8 FOREIGN KEY (id_acheteur_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D58C29EA8EB576A8 ON commannde (id_acheteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commannde DROP FOREIGN KEY FK_D58C29EA8EB576A8');
        $this->addSql('DROP INDEX UNIQ_D58C29EA8EB576A8 ON commannde');
        $this->addSql('ALTER TABLE commannde DROP id_acheteur_id');
    }
}
