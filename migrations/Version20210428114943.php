<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210428114943 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, mention VARCHAR(255) NOT NULL, publication_date DATETIME NOT NULL, paging VARCHAR(255) NOT NULL, volume_number INT DEFAULT NULL, summary LONGTEXT DEFAULT NULL, issn_isbn VARCHAR(255) NOT NULL, support VARCHAR(255) NOT NULL, source_address VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, cote VARCHAR(255) NOT NULL, access VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE publication');
    }
}
