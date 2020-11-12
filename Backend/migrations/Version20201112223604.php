<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201112223604 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_C358569BD251DD7');
        $this->addSql('DROP INDEX IDX_C358569A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__backpack AS SELECT id, user_id, equipments_id, name FROM backpack');
        $this->addSql('DROP TABLE backpack');
        $this->addSql('CREATE TABLE backpack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, equipments_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_C358569A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C358569BD251DD7 FOREIGN KEY (equipments_id) REFERENCES equipment (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO backpack (id, user_id, equipments_id, name) SELECT id, user_id, equipments_id, name FROM __temp__backpack');
        $this->addSql('DROP TABLE __temp__backpack');
        $this->addSql('CREATE INDEX IDX_C358569BD251DD7 ON backpack (equipments_id)');
        $this->addSql('CREATE INDEX IDX_C358569A76ED395 ON backpack (user_id)');
        $this->addSql('DROP INDEX IDX_522FA950727ACA70');
        $this->addSql('DROP INDEX IDX_522FA950517FE9FE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__characteristic AS SELECT id, equipment_id, parent_id, name, value FROM characteristic');
        $this->addSql('DROP TABLE characteristic');
        $this->addSql('CREATE TABLE characteristic (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipment_id INTEGER NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, value VARCHAR(512) NOT NULL COLLATE BINARY, unit VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_522FA950517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_522FA950727ACA70 FOREIGN KEY (parent_id) REFERENCES characteristic (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO characteristic (id, equipment_id, parent_id, name, value) SELECT id, equipment_id, parent_id, name, value FROM __temp__characteristic');
        $this->addSql('DROP TABLE __temp__characteristic');
        $this->addSql('CREATE INDEX IDX_522FA950727ACA70 ON characteristic (parent_id)');
        $this->addSql('CREATE INDEX IDX_522FA950517FE9FE ON characteristic (equipment_id)');
        $this->addSql('DROP INDEX IDX_D338D583B03A8386');
        $this->addSql('DROP INDEX IDX_D338D58344F5D008');
        $this->addSql('DROP INDEX IDX_D338D58312469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__equipment AS SELECT id, category_id, brand_id, created_by_id, name, uri FROM equipment');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('CREATE TABLE equipment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, brand_id INTEGER DEFAULT NULL, created_by_id INTEGER NOT NULL, name VARCHAR(1024) NOT NULL COLLATE BINARY, uri VARCHAR(1024) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_D338D58312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D338D58344F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D338D583B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO equipment (id, category_id, brand_id, created_by_id, name, uri) SELECT id, category_id, brand_id, created_by_id, name, uri FROM __temp__equipment');
        $this->addSql('DROP TABLE __temp__equipment');
        $this->addSql('CREATE INDEX IDX_D338D583B03A8386 ON equipment (created_by_id)');
        $this->addSql('CREATE INDEX IDX_D338D58344F5D008 ON equipment (brand_id)');
        $this->addSql('CREATE INDEX IDX_D338D58312469DE2 ON equipment (category_id)');
        $this->addSql('DROP INDEX IDX_CC5C24CF517FE9FE');
        $this->addSql('DROP INDEX IDX_CC5C24CFA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__possess AS SELECT id, user_id, equipment_id, wish FROM possess');
        $this->addSql('DROP TABLE possess');
        $this->addSql('CREATE TABLE possess (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, equipment_id INTEGER NOT NULL, wish BOOLEAN NOT NULL, CONSTRAINT FK_CC5C24CFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CC5C24CF517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO possess (id, user_id, equipment_id, wish) SELECT id, user_id, equipment_id, wish FROM __temp__possess');
        $this->addSql('DROP TABLE __temp__possess');
        $this->addSql('CREATE INDEX IDX_CC5C24CF517FE9FE ON possess (equipment_id)');
        $this->addSql('CREATE INDEX IDX_CC5C24CFA76ED395 ON possess (user_id)');
        $this->addSql('DROP INDEX IDX_64C19C1727ACA70');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, parent_id, name FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category (id, parent_id, name) SELECT id, parent_id, name FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE INDEX IDX_64C19C1727ACA70 ON category (parent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_C358569A76ED395');
        $this->addSql('DROP INDEX IDX_C358569BD251DD7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__backpack AS SELECT id, user_id, equipments_id, name FROM backpack');
        $this->addSql('DROP TABLE backpack');
        $this->addSql('CREATE TABLE backpack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, equipments_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO backpack (id, user_id, equipments_id, name) SELECT id, user_id, equipments_id, name FROM __temp__backpack');
        $this->addSql('DROP TABLE __temp__backpack');
        $this->addSql('CREATE INDEX IDX_C358569A76ED395 ON backpack (user_id)');
        $this->addSql('CREATE INDEX IDX_C358569BD251DD7 ON backpack (equipments_id)');
        $this->addSql('DROP INDEX IDX_64C19C1727ACA70');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, parent_id, name FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO category (id, parent_id, name) SELECT id, parent_id, name FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE INDEX IDX_64C19C1727ACA70 ON category (parent_id)');
        $this->addSql('DROP INDEX IDX_522FA950517FE9FE');
        $this->addSql('DROP INDEX IDX_522FA950727ACA70');
        $this->addSql('CREATE TEMPORARY TABLE __temp__characteristic AS SELECT id, equipment_id, parent_id, name, value FROM characteristic');
        $this->addSql('DROP TABLE characteristic');
        $this->addSql('CREATE TABLE characteristic (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, equipment_id INTEGER NOT NULL, parent_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(512) NOT NULL)');
        $this->addSql('INSERT INTO characteristic (id, equipment_id, parent_id, name, value) SELECT id, equipment_id, parent_id, name, value FROM __temp__characteristic');
        $this->addSql('DROP TABLE __temp__characteristic');
        $this->addSql('CREATE INDEX IDX_522FA950517FE9FE ON characteristic (equipment_id)');
        $this->addSql('CREATE INDEX IDX_522FA950727ACA70 ON characteristic (parent_id)');
        $this->addSql('DROP INDEX IDX_D338D58312469DE2');
        $this->addSql('DROP INDEX IDX_D338D58344F5D008');
        $this->addSql('DROP INDEX IDX_D338D583B03A8386');
        $this->addSql('CREATE TEMPORARY TABLE __temp__equipment AS SELECT id, category_id, brand_id, created_by_id, name, uri FROM equipment');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('CREATE TABLE equipment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, brand_id INTEGER DEFAULT NULL, created_by_id INTEGER NOT NULL, name VARCHAR(1024) NOT NULL, uri VARCHAR(1024) DEFAULT NULL)');
        $this->addSql('INSERT INTO equipment (id, category_id, brand_id, created_by_id, name, uri) SELECT id, category_id, brand_id, created_by_id, name, uri FROM __temp__equipment');
        $this->addSql('DROP TABLE __temp__equipment');
        $this->addSql('CREATE INDEX IDX_D338D58312469DE2 ON equipment (category_id)');
        $this->addSql('CREATE INDEX IDX_D338D58344F5D008 ON equipment (brand_id)');
        $this->addSql('CREATE INDEX IDX_D338D583B03A8386 ON equipment (created_by_id)');
        $this->addSql('DROP INDEX IDX_CC5C24CFA76ED395');
        $this->addSql('DROP INDEX IDX_CC5C24CF517FE9FE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__possess AS SELECT id, user_id, equipment_id, wish FROM possess');
        $this->addSql('DROP TABLE possess');
        $this->addSql('CREATE TABLE possess (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, equipment_id INTEGER NOT NULL, wish BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO possess (id, user_id, equipment_id, wish) SELECT id, user_id, equipment_id, wish FROM __temp__possess');
        $this->addSql('DROP TABLE __temp__possess');
        $this->addSql('CREATE INDEX IDX_CC5C24CFA76ED395 ON possess (user_id)');
        $this->addSql('CREATE INDEX IDX_CC5C24CF517FE9FE ON possess (equipment_id)');
    }
}
