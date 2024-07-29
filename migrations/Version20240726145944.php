<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240726145944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles ADD short_title VARCHAR(255) NOT NULL, ADD paragraph LONGTEXT NOT NULL, ADD slug VARCHAR(255) NOT NULL, CHANGE name title VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BFDD3168989D9B62 ON articles (slug)');
        $this->addSql('ALTER TABLE user CHANGE avatar_hash avatar_hash VARCHAR(255) DEFAULT NULL, CHANGE username username VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64943349DE ON user (discord_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_BFDD3168989D9B62 ON articles');
        $this->addSql('ALTER TABLE articles ADD name VARCHAR(255) NOT NULL, DROP title, DROP short_title, DROP paragraph, DROP slug');
        $this->addSql('DROP INDEX UNIQ_8D93D64943349DE ON user');
        $this->addSql('ALTER TABLE user CHANGE avatar_hash avatar_hash VARCHAR(255) NOT NULL, CHANGE username username VARCHAR(255) NOT NULL, CHANGE roles roles LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`');
    }
}
