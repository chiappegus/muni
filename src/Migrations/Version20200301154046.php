<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200301154046 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comida_preferidad ADD comida_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comida_preferidad ADD CONSTRAINT FK_E8E8591E399E35A6 FOREIGN KEY (comida_id) REFERENCES buffy (id)');
        $this->addSql('CREATE INDEX IDX_E8E8591E399E35A6 ON comida_preferidad (comida_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comida_preferidad DROP FOREIGN KEY FK_E8E8591E399E35A6');
        $this->addSql('DROP INDEX IDX_E8E8591E399E35A6 ON comida_preferidad');
        $this->addSql('ALTER TABLE comida_preferidad DROP comida_id');
    }
}
