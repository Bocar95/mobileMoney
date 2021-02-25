<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225125533 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comptes ADD agence_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comptes ADD CONSTRAINT FK_56735801D725330D FOREIGN KEY (agence_id) REFERENCES agences (id)');
        $this->addSql('ALTER TABLE comptes ADD CONSTRAINT FK_56735801A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_56735801D725330D ON comptes (agence_id)');
        $this->addSql('CREATE INDEX IDX_56735801A76ED395 ON comptes (user_id)');
        $this->addSql('ALTER TABLE transactions ADD user_id INT DEFAULT NULL, ADD clients_id INT DEFAULT NULL, ADD comptes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CAB014612 FOREIGN KEY (clients_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CDCED588B FOREIGN KEY (comptes_id) REFERENCES comptes (id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CA76ED395 ON transactions (user_id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CAB014612 ON transactions (clients_id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CDCED588B ON transactions (comptes_id)');
        $this->addSql('ALTER TABLE user ADD agences_id INT DEFAULT NULL, ADD role_id INT DEFAULT NULL, DROP roles');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499917E4AB FOREIGN KEY (agences_id) REFERENCES agences (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6499917E4AB ON user (agences_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON user (role_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comptes DROP FOREIGN KEY FK_56735801D725330D');
        $this->addSql('ALTER TABLE comptes DROP FOREIGN KEY FK_56735801A76ED395');
        $this->addSql('DROP INDEX UNIQ_56735801D725330D ON comptes');
        $this->addSql('DROP INDEX IDX_56735801A76ED395 ON comptes');
        $this->addSql('ALTER TABLE comptes DROP agence_id, DROP user_id');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CA76ED395');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CAB014612');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CDCED588B');
        $this->addSql('DROP INDEX IDX_EAA81A4CA76ED395 ON transactions');
        $this->addSql('DROP INDEX IDX_EAA81A4CAB014612 ON transactions');
        $this->addSql('DROP INDEX IDX_EAA81A4CDCED588B ON transactions');
        $this->addSql('ALTER TABLE transactions DROP user_id, DROP clients_id, DROP comptes_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499917E4AB');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('DROP INDEX IDX_8D93D6499917E4AB ON user');
        $this->addSql('DROP INDEX IDX_8D93D649D60322AC ON user');
        $this->addSql('ALTER TABLE user ADD roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, DROP agences_id, DROP role_id');
    }
}
