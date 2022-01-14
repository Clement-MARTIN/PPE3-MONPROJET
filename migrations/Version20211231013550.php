<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211231013550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD is_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DB152555D FOREIGN KEY (is_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DB152555D ON commande (is_user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64982EA2E54');
        $this->addSql('DROP INDEX IDX_8D93D64982EA2E54 ON user');
        $this->addSql('ALTER TABLE user DROP commande_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DB152555D');
        $this->addSql('DROP INDEX IDX_6EEAA67DB152555D ON commande');
        $this->addSql('ALTER TABLE commande DROP is_user_id');
        $this->addSql('ALTER TABLE user ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64982EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64982EA2E54 ON user (commande_id)');
    }
}
