<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200628065503 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_filter (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, ordre VARCHAR(255) NOT NULL, filtre VARCHAR(255) NOT NULL, INDEX IDX_BC4B4FC8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_filter ADD CONSTRAINT FK_BC4B4FC8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26F9D86650F');
        $this->addSql('DROP INDEX IDX_1D5EF26F9D86650F ON movie');
        $this->addSql('ALTER TABLE movie CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1D5EF26FA76ED395 ON movie (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE order_filter');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26FA76ED395');
        $this->addSql('DROP INDEX IDX_1D5EF26FA76ED395 ON movie');
        $this->addSql('ALTER TABLE movie CHANGE user_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1D5EF26F9D86650F ON movie (user_id_id)');
    }
}
