<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<< HEAD:migrations/Version20210129090249.php
final class Version20210129090249 extends AbstractMigration
=======
final class Version20210129234613 extends AbstractMigration
>>>>>>> Mehdi:migrations/Version20210129234613.php
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<< HEAD:migrations/Version20210129090249.php
        $this->addSql('ALTER TABLE commande ADD stripe_session_id VARCHAR(255) DEFAULT NULL, ADD reference VARCHAR(255) DEFAULT NULL');
=======
        $this->addSql('ALTER TABLE commande ADD is_payed TINYINT(1) NOT NULL');
>>>>>>> Mehdi:migrations/Version20210129234613.php
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<< HEAD:migrations/Version20210129090249.php
        $this->addSql('ALTER TABLE commande DROP stripe_session_id, DROP reference');
=======
        $this->addSql('ALTER TABLE commande DROP is_payed');
>>>>>>> Mehdi:migrations/Version20210129234613.php
    }
}
