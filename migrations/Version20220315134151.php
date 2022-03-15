<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220315134151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mes_articles DROP FOREIGN KEY FK_86C1CFCEF77D927C');
        $this->addSql('DROP TABLE mes_articles');
        $this->addSql('DROP TABLE panier');
        $this->addSql('ALTER TABLE commande ADD articles JSON NOT NULL, ADD quantite JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mes_articles (id INT AUTO_INCREMENT NOT NULL, num_article_id INT DEFAULT NULL, panier_id INT DEFAULT NULL, quantite INT NOT NULL, achat INT DEFAULT NULL, INDEX IDX_86C1CFCEFD83C617 (num_article_id), INDEX IDX_86C1CFCEF77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_24CC0DF2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mes_articles ADD CONSTRAINT FK_86C1CFCEF77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE mes_articles ADD CONSTRAINT FK_86C1CFCEFD83C617 FOREIGN KEY (num_article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande DROP articles, DROP quantite');
    }
}
