<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511143313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flora ADD species_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE flora ADD CONSTRAINT FK_C597FBECB2A1D860 FOREIGN KEY (species_id) REFERENCES floraspecie (id)');
        $this->addSql('CREATE INDEX IDX_C597FBECB2A1D860 ON flora (species_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flora DROP FOREIGN KEY FK_C597FBECB2A1D860');
        $this->addSql('DROP INDEX IDX_C597FBECB2A1D860 ON flora');
        $this->addSql('ALTER TABLE flora DROP species_id');
    }
}
