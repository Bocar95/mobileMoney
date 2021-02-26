<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210226171957 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agences ADD compte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agences ADD CONSTRAINT FK_B46015DDF2C56620 FOREIGN KEY (compte_id) REFERENCES comptes (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B46015DDF2C56620 ON agences (compte_id)');
        $this->addSql('ALTER TABLE comptes DROP FOREIGN KEY FK_56735801D725330D');
        $this->addSql('DROP INDEX UNIQ_56735801D725330D ON comptes');
        $this->addSql('ALTER TABLE comptes DROP agence_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agences DROP FOREIGN KEY FK_B46015DDF2C56620');
        $this->addSql('DROP INDEX UNIQ_B46015DDF2C56620 ON agences');
        $this->addSql('ALTER TABLE agences DROP compte_id');
        $this->addSql('ALTER TABLE comptes ADD agence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comptes ADD CONSTRAINT FK_56735801D725330D FOREIGN KEY (agence_id) REFERENCES agences (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_56735801D725330D ON comptes (agence_id)');
    }
}
