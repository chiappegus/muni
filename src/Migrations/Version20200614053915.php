<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200614053915 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE persona (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, dni INT NOT NULL, slug VARCHAR(40) NOT NULL, image_filename VARCHAR(255) DEFAULT NULL, email VARCHAR(191) NOT NULL, UNIQUE INDEX UNIQ_51E5B69B989D9B62 (slug), UNIQUE INDEX UNIQ_51E5B69BE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE buffy (id INT AUTO_INCREMENT NOT NULL, pepe_id INT NOT NULL, name VARCHAR(255) NOT NULL, quote LONGTEXT NOT NULL, slug VARCHAR(32) NOT NULL, UNIQUE INDEX UNIQ_2F1531B5989D9B62 (slug), INDEX IDX_2F1531B545176A60 (pepe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comida_preferidad (id INT AUTO_INCREMENT NOT NULL, nombre_buffy_id INT DEFAULT NULL, comida_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_E8E8591E787C426C (nombre_buffy_id), INDEX IDX_E8E8591E399E35A6 (comida_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intendente (id INT AUTO_INCREMENT NOT NULL, relation_id INT NOT NULL, estado VARCHAR(255) NOT NULL, fecha_inicio DATE NOT NULL, fin_funcion DATE DEFAULT NULL, UNIQUE INDEX UNIQ_CD3B964B3256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE buffy ADD CONSTRAINT FK_2F1531B545176A60 FOREIGN KEY (pepe_id) REFERENCES comida_preferidad (id)');
        $this->addSql('ALTER TABLE comida_preferidad ADD CONSTRAINT FK_E8E8591E787C426C FOREIGN KEY (nombre_buffy_id) REFERENCES buffy (id)');
        $this->addSql('ALTER TABLE comida_preferidad ADD CONSTRAINT FK_E8E8591E399E35A6 FOREIGN KEY (comida_id) REFERENCES buffy (id)');
        $this->addSql('ALTER TABLE intendente ADD CONSTRAINT FK_CD3B964B3256915B FOREIGN KEY (relation_id) REFERENCES persona (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE intendente DROP FOREIGN KEY FK_CD3B964B3256915B');
        $this->addSql('ALTER TABLE comida_preferidad DROP FOREIGN KEY FK_E8E8591E787C426C');
        $this->addSql('ALTER TABLE comida_preferidad DROP FOREIGN KEY FK_E8E8591E399E35A6');
        $this->addSql('ALTER TABLE buffy DROP FOREIGN KEY FK_2F1531B545176A60');
        $this->addSql('DROP TABLE persona');
        $this->addSql('DROP TABLE buffy');
        $this->addSql('DROP TABLE comida_preferidad');
        $this->addSql('DROP TABLE intendente');
    }
}
