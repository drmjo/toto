<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160609221031 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE toto_toto_entry (id INT AUTO_INCREMENT NOT NULL, toto_id INT DEFAULT NULL, game_id INT DEFAULT NULL, home_score INT DEFAULT NULL, away_score INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_733053C08AFE2BB1 (toto_id), INDEX IDX_733053C0E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE toto_toto (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE toto_toto_entry ADD CONSTRAINT FK_733053C08AFE2BB1 FOREIGN KEY (toto_id) REFERENCES toto_toto (id)');
        $this->addSql('ALTER TABLE toto_toto_entry ADD CONSTRAINT FK_733053C0E48FD905 FOREIGN KEY (game_id) REFERENCES toto_game (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE toto_toto_entry DROP FOREIGN KEY FK_733053C08AFE2BB1');
        $this->addSql('DROP TABLE toto_toto_entry');
        $this->addSql('DROP TABLE toto_toto');
    }
}
