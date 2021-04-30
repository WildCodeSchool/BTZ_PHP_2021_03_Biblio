<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210429150114 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE publication_editor (publication_id INT NOT NULL, editor_id INT NOT NULL, INDEX IDX_281AE0F738B217A7 (publication_id), INDEX IDX_281AE0F76995AC4C (editor_id), PRIMARY KEY(publication_id, editor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE publication_editor ADD CONSTRAINT FK_281AE0F738B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publication_editor ADD CONSTRAINT FK_281AE0F76995AC4C FOREIGN KEY (editor_id) REFERENCES editor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publication ADD type_id INT NOT NULL, ADD localisation_id INT DEFAULT NULL, ADD thematic_id INT NOT NULL, ADD language_id INT NOT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779C54C8C93 FOREIGN KEY (type_id) REFERENCES publication_type (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67792395FCED FOREIGN KEY (thematic_id) REFERENCES thematic (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C677982F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_AF3C6779C54C8C93 ON publication (type_id)');
        $this->addSql('CREATE INDEX IDX_AF3C6779C68BE09C ON publication (localisation_id)');
        $this->addSql('CREATE INDEX IDX_AF3C67792395FCED ON publication (thematic_id)');
        $this->addSql('CREATE INDEX IDX_AF3C677982F1BAF4 ON publication (language_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE publication_editor');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779C54C8C93');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779C68BE09C');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67792395FCED');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C677982F1BAF4');
        $this->addSql('DROP INDEX IDX_AF3C6779C54C8C93 ON publication');
        $this->addSql('DROP INDEX IDX_AF3C6779C68BE09C ON publication');
        $this->addSql('DROP INDEX IDX_AF3C67792395FCED ON publication');
        $this->addSql('DROP INDEX IDX_AF3C677982F1BAF4 ON publication');
        $this->addSql('ALTER TABLE publication DROP type_id, DROP localisation_id, DROP thematic_id, DROP language_id');
    }
}
