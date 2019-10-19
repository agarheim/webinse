<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191015114724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Users');
        $this->addSql('DROP TABLE chat');
        $this->addSql('ALTER TABLE users_w ADD message LONGTEXT NOT NULL, ADD date_add DATETIME NOT NULL, CHANGE last_name home_page VARCHAR(150) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Users (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL COLLATE latin1_swedish_ci, last_name VARCHAR(100) NOT NULL COLLATE latin1_swedish_ci, email VARCHAR(100) NOT NULL COLLATE latin1_swedish_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, date_pub DATETIME NOT NULL, text_chat VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, first_name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, last_name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE users_w DROP message, DROP date_add, CHANGE home_page last_name VARCHAR(150) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
