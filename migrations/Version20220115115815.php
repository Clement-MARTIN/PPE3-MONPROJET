<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220115115815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mes_articles ADD panier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mes_articles ADD CONSTRAINT FK_86C1CFCEF77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('CREATE INDEX IDX_86C1CFCEF77D927C ON mes_articles (panier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mes_articles DROP FOREIGN KEY FK_86C1CFCEF77D927C');
        $this->addSql('DROP INDEX IDX_86C1CFCEF77D927C ON mes_articles');
        $this->addSql('ALTER TABLE mes_articles DROP panier_id');
    }
}
