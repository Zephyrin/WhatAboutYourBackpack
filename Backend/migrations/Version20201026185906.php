<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201026185906 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE backpack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, equipments_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_C358569A76ED395 ON backpack (user_id)');
        $this->addSql('CREATE INDEX IDX_C358569BD251DD7 ON backpack (equipments_id)');
        $this->addSql('CREATE TABLE characteristic (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipment_id INTEGER NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(512) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_522FA950517FE9FE ON characteristic (equipment_id)');
        $this->addSql('CREATE INDEX IDX_522FA950727ACA70 ON characteristic (parent_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, gender VARCHAR(6) NOT NULL, email VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, created DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE equipment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, brand_id INTEGER DEFAULT NULL, created_by_id INTEGER NOT NULL, name VARCHAR(1024) NOT NULL, uri VARCHAR(1024) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_D338D58312469DE2 ON equipment (category_id)');
        $this->addSql('CREATE INDEX IDX_D338D58344F5D008 ON equipment (brand_id)');
        $this->addSql('CREATE INDEX IDX_D338D583B03A8386 ON equipment (created_by_id)');
        $this->addSql('CREATE TABLE brand (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, uri VARCHAR(1024) DEFAULT NULL)');
        $this->addSql('CREATE TABLE possess (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, equipment_id INTEGER NOT NULL, wish BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_CC5C24CFA76ED395 ON possess (user_id)');
        $this->addSql('CREATE INDEX IDX_CC5C24CF517FE9FE ON possess (equipment_id)');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_64C19C1727ACA70 ON category (parent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE backpack');
        $this->addSql('DROP TABLE characteristic');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE possess');
        $this->addSql('DROP TABLE category');
    }
}
