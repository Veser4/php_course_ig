<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240601051623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX email_idx ON user');
        $this->addSql('DROP INDEX phone_idx ON user');
        $this->addSql('ALTER TABLE user CHANGE first_name first_name VARCHAR(200) NOT NULL, CHANGE last_name last_name VARCHAR(200) NOT NULL, CHANGE birth_date birth_date VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE first_name first_name VARCHAR(255) NOT NULL, CHANGE last_name last_name VARCHAR(255) NOT NULL, CHANGE birth_date birth_date DATETIME NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX email_idx ON user (email)');
        $this->addSql('CREATE UNIQUE INDEX phone_idx ON user (phone)');
    }
}
