<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260206184248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actualite_post (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, contenu LONGTEXT NOT NULL, statut VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_112CC206FB88E14F (utilisateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, contenu LONGTEXT NOT NULL, statut VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, utilisateur_id INT NOT NULL, actualite_post_id INT NOT NULL, INDEX IDX_67F068BCFB88E14F (utilisateur_id), INDEX IDX_67F068BCA9D860BC (actualite_post_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, sujet VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, utilisateur_id INT DEFAULT NULL, INDEX IDX_B6BD307FFB88E14F (utilisateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE signalement (id INT AUTO_INCREMENT NOT NULL, motif VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, commentaire_id INT NOT NULL, INDEX IDX_F4B55114BA9CD190 (commentaire_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE actualite_post ADD CONSTRAINT FK_112CC206FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA9D860BC FOREIGN KEY (actualite_post_id) REFERENCES actualite_post (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT FK_F4B55114BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE utilisateur ADD prenom VARCHAR(255) NOT NULL, ADD role VARCHAR(255) NOT NULL, ADD actif TINYINT NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD type VARCHAR(255) NOT NULL, ADD mdp VARCHAR(255) DEFAULT NULL, CHANGE nom nom VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite_post DROP FOREIGN KEY FK_112CC206FB88E14F');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCFB88E14F');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA9D860BC');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FFB88E14F');
        $this->addSql('ALTER TABLE signalement DROP FOREIGN KEY FK_F4B55114BA9CD190');
        $this->addSql('DROP TABLE actualite_post');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE signalement');
        $this->addSql('ALTER TABLE utilisateur DROP prenom, DROP role, DROP actif, DROP created_at, DROP updated_at, DROP type, DROP mdp, CHANGE nom nom VARCHAR(100) NOT NULL');
    }
}
