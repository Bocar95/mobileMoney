<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225134824 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comptes DROP FOREIGN KEY FK_56735801A76ED395');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CA76ED395');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, agences_id INT DEFAULT NULL, role_id INT DEFAULT NULL, telephone VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9450FF010 (telephone), INDEX IDX_1483A5E99917E4AB (agences_id), INDEX IDX_1483A5E9D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E99917E4AB FOREIGN KEY (agences_id) REFERENCES agences (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_56735801A76ED395 ON comptes');
        $this->addSql('ALTER TABLE comptes CHANGE user_id users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comptes ADD CONSTRAINT FK_5673580167B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_5673580167B3B43D ON comptes (users_id)');
        $this->addSql('DROP INDEX IDX_EAA81A4CA76ED395 ON transactions');
        $this->addSql('ALTER TABLE transactions CHANGE user_id users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4C67B3B43D ON transactions (users_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comptes DROP FOREIGN KEY FK_5673580167B3B43D');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C67B3B43D');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, agences_id INT DEFAULT NULL, role_id INT DEFAULT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, telephone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, statut TINYINT(1) NOT NULL, INDEX IDX_8D93D649D60322AC (role_id), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6499917E4AB (agences_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499917E4AB FOREIGN KEY (agences_id) REFERENCES agences (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP INDEX IDX_5673580167B3B43D ON comptes');
        $this->addSql('ALTER TABLE comptes CHANGE users_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comptes ADD CONSTRAINT FK_56735801A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_56735801A76ED395 ON comptes (user_id)');
        $this->addSql('DROP INDEX IDX_EAA81A4C67B3B43D ON transactions');
        $this->addSql('ALTER TABLE transactions CHANGE users_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CA76ED395 ON transactions (user_id)');
    }
}
