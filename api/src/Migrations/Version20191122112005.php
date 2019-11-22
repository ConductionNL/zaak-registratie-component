<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191122112005 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE nlxrequest_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ext_log_entries_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE status (id UUID NOT NULL, zaak_id UUID NOT NULL, status_type VARCHAR(1000) NOT NULL, datum_status_gezet TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status_toelichting VARCHAR(1000) DEFAULT NULL, url VARCHAR(1000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7B00651CC7A9BE39 ON status (zaak_id)');
        $this->addSql('COMMENT ON COLUMN status.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN status.zaak_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE nlxrequest_log (id INT NOT NULL, application_id VARCHAR(255) DEFAULT NULL, request_id VARCHAR(255) DEFAULT NULL, user_id VARCHAR(255) DEFAULT NULL, subject_id VARCHAR(255) DEFAULT NULL, process_id VARCHAR(255) DEFAULT NULL, data_elements TEXT DEFAULT NULL, data_subjects TEXT DEFAULT NULL, object_id VARCHAR(255) DEFAULT NULL, object_class VARCHAR(255) NOT NULL, route VARCHAR(255) NOT NULL, endpoint VARCHAR(255) NOT NULL, method VARCHAR(10) NOT NULL, content_type VARCHAR(255) NOT NULL, content TEXT DEFAULT NULL, session VARCHAR(255) NOT NULL, logged_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN nlxrequest_log.data_elements IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN nlxrequest_log.data_subjects IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE zaak_object (id UUID NOT NULL, zaak_id UUID NOT NULL, object VARCHAR(1000) DEFAULT NULL, object_type VARCHAR(255) NOT NULL, object_type_overige VARCHAR(100) DEFAULT NULL, relatie_omschrijving VARCHAR(80) DEFAULT NULL, object_identificatie TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_43446ECEC7A9BE39 ON zaak_object (zaak_id)');
        $this->addSql('COMMENT ON COLUMN zaak_object.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN zaak_object.zaak_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN zaak_object.object_identificatie IS \'(DC2Type:object)\'');
        $this->addSql('CREATE TABLE zaak (id UUID NOT NULL, url VARCHAR(1000) NOT NULL, bronorganisatie VARCHAR(9) NOT NULL, omschrijving VARCHAR(80) DEFAULT NULL, toelichting VARCHAR(1000) DEFAULT NULL, zaak_type VARCHAR(1000) NOT NULL, registratie_datum DATE DEFAULT NULL, verantwoordelijke_organisatie VARCHAR(9) NOT NULL, start_datum DATE NOT NULL, einddatum_gepland DATE DEFAULT NULL, uiterlijke_einddatum_afdoening DATE DEFAULT NULL, publicatie_datum DATE DEFAULT NULL, communicatie_kanaal VARCHAR(1000) DEFAULT NULL, producten_of_diensten TEXT DEFAULT NULL, vertrouwelijkheid_aanduiding VARCHAR(255) DEFAULT NULL, betalingsindicatie VARCHAR(255) DEFAULT NULL, laatste_betaaldatum TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, zaak_geometrie TEXT DEFAULT NULL, verlenging TEXT DEFAULT NULL, opschorting TEXT DEFAULT NULL, selectielijstklasse VARCHAR(1000) DEFAULT NULL, hoofdzaak VARCHAR(1000) DEFAULT NULL, relevante_andere_zaken TEXT DEFAULT NULL, kenmerken TEXT DEFAULT NULL, archief_nominatie VARCHAR(255) DEFAULT NULL, archief_status VARCHAR(255) DEFAULT NULL, archief_actiedatum DATE DEFAULT NULL, identificatie VARCHAR(40) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN zaak.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN zaak.producten_of_diensten IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN zaak.zaak_geometrie IS \'(DC2Type:object)\'');
        $this->addSql('COMMENT ON COLUMN zaak.verlenging IS \'(DC2Type:object)\'');
        $this->addSql('COMMENT ON COLUMN zaak.opschorting IS \'(DC2Type:object)\'');
        $this->addSql('COMMENT ON COLUMN zaak.relevante_andere_zaken IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN zaak.kenmerken IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE klant_contact (id UUID NOT NULL, zaak_id UUID NOT NULL, datumtijd TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, kanaal VARCHAR(20) DEFAULT NULL, onderwerp VARCHAR(200) DEFAULT NULL, toelichting VARCHAR(1000) DEFAULT NULL, url VARCHAR(1000) NOT NULL, identificatie VARCHAR(14) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_65253538C7A9BE39 ON klant_contact (zaak_id)');
        $this->addSql('COMMENT ON COLUMN klant_contact.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN klant_contact.zaak_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE example_entity (id UUID NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN example_entity.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE resultaat (id UUID NOT NULL, zaak_id UUID NOT NULL, resultaat_type VARCHAR(1000) NOT NULL, toelichting VARCHAR(1000) DEFAULT NULL, url VARCHAR(1000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FC3CE4B5C7A9BE39 ON resultaat (zaak_id)');
        $this->addSql('COMMENT ON COLUMN resultaat.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN resultaat.zaak_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE rol (id UUID NOT NULL, zaak_id UUID NOT NULL, betrokkene VARCHAR(1000) DEFAULT NULL, betrokkene_type VARCHAR(255) NOT NULL, rol_type VARCHAR(1000) NOT NULL, rol_toelichting VARCHAR(1000) NOT NULL, indicatie_machtiging VARCHAR(255) DEFAULT NULL, betrokkene_identificatie TEXT DEFAULT NULL, url VARCHAR(1000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E553F37C7A9BE39 ON rol (zaak_id)');
        $this->addSql('COMMENT ON COLUMN rol.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN rol.zaak_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN rol.betrokkene_identificatie IS \'(DC2Type:object)\'');
        $this->addSql('CREATE TABLE zaak_informatie_object (id UUID NOT NULL, zaak_id UUID NOT NULL, informatie_object VARCHAR(1000) NOT NULL, titel VARCHAR(200) DEFAULT NULL, beschrijving VARCHAR(1000) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D62FCCFAC7A9BE39 ON zaak_informatie_object (zaak_id)');
        $this->addSql('COMMENT ON COLUMN zaak_informatie_object.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN zaak_informatie_object.zaak_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE ext_log_entries (id INT NOT NULL, action VARCHAR(8) NOT NULL, logged_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(255) NOT NULL, version INT NOT NULL, data TEXT DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class)');
        $this->addSql('CREATE INDEX log_date_lookup_idx ON ext_log_entries (logged_at)');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username)');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class, version)');
        $this->addSql('COMMENT ON COLUMN ext_log_entries.data IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651CC7A9BE39 FOREIGN KEY (zaak_id) REFERENCES zaak (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE zaak_object ADD CONSTRAINT FK_43446ECEC7A9BE39 FOREIGN KEY (zaak_id) REFERENCES zaak (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE klant_contact ADD CONSTRAINT FK_65253538C7A9BE39 FOREIGN KEY (zaak_id) REFERENCES zaak (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resultaat ADD CONSTRAINT FK_FC3CE4B5C7A9BE39 FOREIGN KEY (zaak_id) REFERENCES zaak (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rol ADD CONSTRAINT FK_E553F37C7A9BE39 FOREIGN KEY (zaak_id) REFERENCES zaak (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE zaak_informatie_object ADD CONSTRAINT FK_D62FCCFAC7A9BE39 FOREIGN KEY (zaak_id) REFERENCES zaak (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE status DROP CONSTRAINT FK_7B00651CC7A9BE39');
        $this->addSql('ALTER TABLE zaak_object DROP CONSTRAINT FK_43446ECEC7A9BE39');
        $this->addSql('ALTER TABLE klant_contact DROP CONSTRAINT FK_65253538C7A9BE39');
        $this->addSql('ALTER TABLE resultaat DROP CONSTRAINT FK_FC3CE4B5C7A9BE39');
        $this->addSql('ALTER TABLE rol DROP CONSTRAINT FK_E553F37C7A9BE39');
        $this->addSql('ALTER TABLE zaak_informatie_object DROP CONSTRAINT FK_D62FCCFAC7A9BE39');
        $this->addSql('DROP SEQUENCE nlxrequest_log_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ext_log_entries_id_seq CASCADE');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE nlxrequest_log');
        $this->addSql('DROP TABLE zaak_object');
        $this->addSql('DROP TABLE zaak');
        $this->addSql('DROP TABLE klant_contact');
        $this->addSql('DROP TABLE example_entity');
        $this->addSql('DROP TABLE resultaat');
        $this->addSql('DROP TABLE rol');
        $this->addSql('DROP TABLE zaak_informatie_object');
        $this->addSql('DROP TABLE ext_log_entries');
    }
}
