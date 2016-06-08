<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160608000847 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE toto_game (id INT AUTO_INCREMENT NOT NULL, home_team_id INT DEFAULT NULL, away_team_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_1B24CB5D9C4C13F6 (home_team_id), INDEX IDX_1B24CB5D45185D02 (away_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE toto_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_9C2CA97D5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE toto_team (id INT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_FCEF5CCE5E237E06 (name), INDEX IDX_FCEF5CCEFE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE toto_game ADD CONSTRAINT FK_1B24CB5D9C4C13F6 FOREIGN KEY (home_team_id) REFERENCES toto_team (id)');
        $this->addSql('ALTER TABLE toto_game ADD CONSTRAINT FK_1B24CB5D45185D02 FOREIGN KEY (away_team_id) REFERENCES toto_team (id)');
        $this->addSql('ALTER TABLE toto_team ADD CONSTRAINT FK_FCEF5CCEFE54D947 FOREIGN KEY (group_id) REFERENCES toto_group (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE toto_team DROP FOREIGN KEY FK_FCEF5CCEFE54D947');
        $this->addSql('ALTER TABLE toto_game DROP FOREIGN KEY FK_1B24CB5D9C4C13F6');
        $this->addSql('ALTER TABLE toto_game DROP FOREIGN KEY FK_1B24CB5D45185D02');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE toto_game');
        $this->addSql('DROP TABLE toto_group');
        $this->addSql('DROP TABLE toto_team');
    }
}
