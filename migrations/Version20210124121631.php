<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210124121631 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD telephone INT NOT NULL, ADD adresse LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD paiement LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE vendeur ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD raison_sociale VARCHAR(255) NOT NULL, ADD telephone INT NOT NULL, ADD adresse LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP telephone, DROP adresse, DROP paiement');
        $this->addSql('ALTER TABLE vendeur DROP nom, DROP prenom, DROP raison_sociale, DROP telephone, DROP adresse');
    }
}
