<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210228165953 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agences (id INT AUTO_INCREMENT NOT NULL, compte_id INT DEFAULT NULL, telephone VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, lattitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_B46015DDF2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, nom_complet VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, num_cni VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comptes (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, numero_compte VARCHAR(255) NOT NULL, solde INT NOT NULL, date_creation DATE NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_5673580167B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transactions (id INT AUTO_INCREMENT NOT NULL, users_depot_id INT DEFAULT NULL, users_retrait_id INT DEFAULT NULL, client_retrait_id INT DEFAULT NULL, client_depot_id INT DEFAULT NULL, compte_depot_id INT DEFAULT NULL, compte_retrait_id INT DEFAULT NULL, montant INT NOT NULL, date_depot DATE NOT NULL, date_retrait DATE DEFAULT NULL, code_trans VARCHAR(255) NOT NULL, frais INT NOT NULL, frais_depot INT NOT NULL, frais_retrait INT NOT NULL, frais_etat INT NOT NULL, frais_systeme INT NOT NULL, INDEX IDX_EAA81A4CFE51FF04 (users_depot_id), INDEX IDX_EAA81A4CA993EAEE (users_retrait_id), INDEX IDX_EAA81A4CEEAC783B (client_retrait_id), INDEX IDX_EAA81A4CABF6E41B (client_depot_id), INDEX IDX_EAA81A4C7A04723 (compte_depot_id), INDEX IDX_EAA81A4CB6EC9AC4 (compte_retrait_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, agences_id INT DEFAULT NULL, role_id INT DEFAULT NULL, telephone VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9450FF010 (telephone), INDEX IDX_1483A5E99917E4AB (agences_id), INDEX IDX_1483A5E9D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agences ADD CONSTRAINT FK_B46015DDF2C56620 FOREIGN KEY (compte_id) REFERENCES comptes (id)');
        $this->addSql('ALTER TABLE comptes ADD CONSTRAINT FK_5673580167B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CFE51FF04 FOREIGN KEY (users_depot_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CA993EAEE FOREIGN KEY (users_retrait_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CEEAC783B FOREIGN KEY (client_retrait_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CABF6E41B FOREIGN KEY (client_depot_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C7A04723 FOREIGN KEY (compte_depot_id) REFERENCES comptes (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CB6EC9AC4 FOREIGN KEY (compte_retrait_id) REFERENCES comptes (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E99917E4AB FOREIGN KEY (agences_id) REFERENCES agences (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E99917E4AB');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CEEAC783B');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CABF6E41B');
        $this->addSql('ALTER TABLE agences DROP FOREIGN KEY FK_B46015DDF2C56620');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C7A04723');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CB6EC9AC4');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9D60322AC');
        $this->addSql('ALTER TABLE comptes DROP FOREIGN KEY FK_5673580167B3B43D');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CFE51FF04');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CA993EAEE');
        $this->addSql('DROP TABLE agences');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE comptes');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP TABLE users');
    }
}
