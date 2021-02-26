<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210226155950 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C67B3B43D');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CAB014612');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CDCED588B');
        $this->addSql('DROP INDEX IDX_EAA81A4C67B3B43D ON transactions');
        $this->addSql('DROP INDEX IDX_EAA81A4CAB014612 ON transactions');
        $this->addSql('DROP INDEX IDX_EAA81A4CDCED588B ON transactions');
        $this->addSql('ALTER TABLE transactions ADD users_depot_id INT DEFAULT NULL, ADD users_retrait_id INT DEFAULT NULL, ADD client_retrait_id INT DEFAULT NULL, ADD client_depot_id INT DEFAULT NULL, ADD compte_depot_id INT DEFAULT NULL, ADD compte_retrait_id INT DEFAULT NULL, DROP users_id, DROP clients_id, DROP comptes_id');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CFE51FF04 FOREIGN KEY (users_depot_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CA993EAEE FOREIGN KEY (users_retrait_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CEEAC783B FOREIGN KEY (client_retrait_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CABF6E41B FOREIGN KEY (client_depot_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C7A04723 FOREIGN KEY (compte_depot_id) REFERENCES comptes (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CB6EC9AC4 FOREIGN KEY (compte_retrait_id) REFERENCES comptes (id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CFE51FF04 ON transactions (users_depot_id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CA993EAEE ON transactions (users_retrait_id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CEEAC783B ON transactions (client_retrait_id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CABF6E41B ON transactions (client_depot_id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4C7A04723 ON transactions (compte_depot_id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CB6EC9AC4 ON transactions (compte_retrait_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CFE51FF04');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CA993EAEE');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CEEAC783B');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CABF6E41B');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C7A04723');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CB6EC9AC4');
        $this->addSql('DROP INDEX IDX_EAA81A4CFE51FF04 ON transactions');
        $this->addSql('DROP INDEX IDX_EAA81A4CA993EAEE ON transactions');
        $this->addSql('DROP INDEX IDX_EAA81A4CEEAC783B ON transactions');
        $this->addSql('DROP INDEX IDX_EAA81A4CABF6E41B ON transactions');
        $this->addSql('DROP INDEX IDX_EAA81A4C7A04723 ON transactions');
        $this->addSql('DROP INDEX IDX_EAA81A4CB6EC9AC4 ON transactions');
        $this->addSql('ALTER TABLE transactions ADD users_id INT DEFAULT NULL, ADD clients_id INT DEFAULT NULL, ADD comptes_id INT DEFAULT NULL, DROP users_depot_id, DROP users_retrait_id, DROP client_retrait_id, DROP client_depot_id, DROP compte_depot_id, DROP compte_retrait_id');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CAB014612 FOREIGN KEY (clients_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CDCED588B FOREIGN KEY (comptes_id) REFERENCES comptes (id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4C67B3B43D ON transactions (users_id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CAB014612 ON transactions (clients_id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CDCED588B ON transactions (comptes_id)');
    }
}
