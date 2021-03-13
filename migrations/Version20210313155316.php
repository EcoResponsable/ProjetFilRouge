<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210313155316 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE code_promo DROP FOREIGN KEY FK_5C4683B73256915B');
        $this->addSql('DROP INDEX IDX_5C4683B73256915B ON code_promo');
        $this->addSql('ALTER TABLE code_promo ADD nom VARCHAR(255) NOT NULL, CHANGE vendeur_id vendeur_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE code_promo ADD CONSTRAINT FK_5C4683B7B237AE82 FOREIGN KEY (vendeur_id_id) REFERENCES vendeur (id)');
        $this->addSql('CREATE INDEX IDX_5C4683B7B237AE82 ON code_promo (vendeur_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE code_promo DROP FOREIGN KEY FK_5C4683B7B237AE82');
        $this->addSql('DROP INDEX IDX_5C4683B7B237AE82 ON code_promo');
        $this->addSql('ALTER TABLE code_promo DROP nom, CHANGE vendeur_id_id vendeur_id INT NOT NULL');
        $this->addSql('ALTER TABLE code_promo ADD CONSTRAINT FK_5C4683B73256915B FOREIGN KEY (vendeur_id) REFERENCES vendeur (id)');
        $this->addSql('CREATE INDEX IDX_5C4683B73256915B ON code_promo (vendeur_id)');
    }
}
