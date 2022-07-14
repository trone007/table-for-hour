<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220709160922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_log (id INT AUTO_INCREMENT NOT NULL, desk_id INT NOT NULL, user_id INT NOT NULL, date_start DATE NOT NULL, date_end DATE DEFAULT NULL, INDEX IDX_A95A511271F9DF5E (desk_id), INDEX IDX_A95A5112A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE desk (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, description VARCHAR(255) DEFAULT NULL, x INT NOT NULL, y INT NOT NULL, rotation INT DEFAULT NULL, width INT NOT NULL, length INT NOT NULL, INDEX IDX_56E246654177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE desk_features (id INT AUTO_INCREMENT NOT NULL, desk_id INT NOT NULL, description VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_4801ABFA71F9DF5E (desk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, width INT NOT NULL, length INT NOT NULL, background VARCHAR(2000) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(64) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_log ADD CONSTRAINT FK_A95A511271F9DF5E FOREIGN KEY (desk_id) REFERENCES desk (id)');
        $this->addSql('ALTER TABLE booking_log ADD CONSTRAINT FK_A95A5112A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE desk ADD CONSTRAINT FK_56E246654177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE desk_features ADD CONSTRAINT FK_4801ABFA71F9DF5E FOREIGN KEY (desk_id) REFERENCES desk (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_log DROP FOREIGN KEY FK_A95A511271F9DF5E');
        $this->addSql('ALTER TABLE desk_features DROP FOREIGN KEY FK_4801ABFA71F9DF5E');
        $this->addSql('ALTER TABLE desk DROP FOREIGN KEY FK_56E246654177093');
        $this->addSql('ALTER TABLE booking_log DROP FOREIGN KEY FK_A95A5112A76ED395');
        $this->addSql('DROP TABLE booking_log');
        $this->addSql('DROP TABLE desk');
        $this->addSql('DROP TABLE desk_features');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
