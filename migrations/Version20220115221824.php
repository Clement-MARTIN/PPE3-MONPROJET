<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220115221824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mes_articles DROP INDEX UNIQ_86C1CFCEFD83C617, ADD INDEX IDX_86C1CFCEFD83C617 (num_article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mes_articles DROP INDEX IDX_86C1CFCEFD83C617, ADD UNIQUE INDEX UNIQ_86C1CFCEFD83C617 (num_article_id)');
    }
}
