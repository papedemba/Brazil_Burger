<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714085342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_burger ADD burger_id INT DEFAULT NULL, ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_burger ADD CONSTRAINT FK_EDB7A1D817CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id)');
        $this->addSql('ALTER TABLE commande_burger ADD CONSTRAINT FK_EDB7A1D882EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_EDB7A1D817CE5090 ON commande_burger (burger_id)');
        $this->addSql('CREATE INDEX IDX_EDB7A1D882EA2E54 ON commande_burger (commande_id)');
        $this->addSql('ALTER TABLE commande_menu ADD menu_id INT DEFAULT NULL, ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_menu ADD CONSTRAINT FK_16693B70CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE commande_menu ADD CONSTRAINT FK_16693B7082EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_16693B70CCD7E912 ON commande_menu (menu_id)');
        $this->addSql('CREATE INDEX IDX_16693B7082EA2E54 ON commande_menu (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_burger DROP FOREIGN KEY FK_EDB7A1D817CE5090');
        $this->addSql('ALTER TABLE commande_burger DROP FOREIGN KEY FK_EDB7A1D882EA2E54');
        $this->addSql('DROP INDEX IDX_EDB7A1D817CE5090 ON commande_burger');
        $this->addSql('DROP INDEX IDX_EDB7A1D882EA2E54 ON commande_burger');
        $this->addSql('ALTER TABLE commande_burger DROP burger_id, DROP commande_id');
        $this->addSql('ALTER TABLE commande_menu DROP FOREIGN KEY FK_16693B70CCD7E912');
        $this->addSql('ALTER TABLE commande_menu DROP FOREIGN KEY FK_16693B7082EA2E54');
        $this->addSql('DROP INDEX IDX_16693B70CCD7E912 ON commande_menu');
        $this->addSql('DROP INDEX IDX_16693B7082EA2E54 ON commande_menu');
        $this->addSql('ALTER TABLE commande_menu DROP menu_id, DROP commande_id');
    }
}
