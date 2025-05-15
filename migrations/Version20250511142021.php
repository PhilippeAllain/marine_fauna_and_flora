<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511142021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fauna ADD species_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fauna ADD CONSTRAINT FK_C03B58CAB2A1D860 FOREIGN KEY (species_id) REFERENCES faunaspecie (id)');
        $this->addSql('CREATE INDEX IDX_C03B58CAB2A1D860 ON fauna (species_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fauna DROP FOREIGN KEY FK_C03B58CAB2A1D860');
        $this->addSql('DROP INDEX IDX_C03B58CAB2A1D860 ON fauna');
        $this->addSql('ALTER TABLE fauna DROP species_id');
    }
}
