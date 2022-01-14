<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211229173452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achat (id INT AUTO_INCREMENT NOT NULL, num_commande_id INT DEFAULT NULL, num_article_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_26A98456F80F63BC (num_commande_id), UNIQUE INDEX UNIQ_26A98456FD83C617 (num_article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commannde (id INT AUTO_INCREMENT NOT NULL, date_commande DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456F80F63BC FOREIGN KEY (num_commande_id) REFERENCES commannde (id)');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456FD83C617 FOREIGN KEY (num_article_id) REFERENCES article (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456F80F63BC');
        $this->addSql('DROP TABLE achat');
        $this->addSql('DROP TABLE commannde');
    }
}
