<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230518131608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mentor (id INT AUTO_INCREMENT NOT NULL, has_star TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE star (id INT AUTO_INCREMENT NOT NULL, mentor_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_C9DB5A14DB403044 (mentor_id), INDEX IDX_C9DB5A14CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE star ADD CONSTRAINT FK_C9DB5A14DB403044 FOREIGN KEY (mentor_id) REFERENCES mentor (id)');
        $this->addSql('ALTER TABLE star ADD CONSTRAINT FK_C9DB5A14CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE star DROP FOREIGN KEY FK_C9DB5A14DB403044');
        $this->addSql('ALTER TABLE star DROP FOREIGN KEY FK_C9DB5A14CB944F1A');
        $this->addSql('DROP TABLE mentor');
        $this->addSql('DROP TABLE star');
        $this->addSql('DROP TABLE student');
    }
}
