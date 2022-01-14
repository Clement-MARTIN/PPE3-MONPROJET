<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211231013846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456F80F63BC');
        $this->addSql('DROP INDEX IDX_26A98456F80F63BC ON achat');
        $this->addSql('ALTER TABLE achat DROP num_commande_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat ADD num_commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456F80F63BC FOREIGN KEY (num_commande_id) REFERENCES commannde (id)');
        $this->addSql('CREATE INDEX IDX_26A98456F80F63BC ON achat (num_commande_id)');
    }
}
