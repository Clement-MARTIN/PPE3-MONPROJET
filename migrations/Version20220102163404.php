<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220102163404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commannde');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commannde (id INT AUTO_INCREMENT NOT NULL, id_acheteur_id INT DEFAULT NULL, date_commande DATE NOT NULL, UNIQUE INDEX UNIQ_D58C29EA8EB576A8 (id_acheteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commannde ADD CONSTRAINT FK_D58C29EA8EB576A8 FOREIGN KEY (id_acheteur_id) REFERENCES user (id)');
    }
}
