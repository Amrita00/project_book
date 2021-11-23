<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211122094905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rent_book (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, rent_date DATE NOT NULL, return_date DATE NOT NULL, INDEX IDX_BB8F0D7A9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rent_book ADD CONSTRAINT FK_BB8F0D7A9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE book ADD rent_book_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F78EC8F1 FOREIGN KEY (rent_book_id) REFERENCES rent_book (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331F78EC8F1 ON book (rent_book_id)');
        $this->addSql('ALTER TABLE news CHANGE author author VARCHAR(255) NOT NULL, CHANGE title title VARCHAR(255) NOT NULL, CHANGE url url VARCHAR(255) NOT NULL, CHANGE url_to_image url_to_image VARCHAR(255) NOT NULL, CHANGE published_at published_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `book` DROP FOREIGN KEY FK_CBE5A331F78EC8F1');
        $this->addSql('DROP TABLE rent_book');
        $this->addSql('DROP INDEX IDX_CBE5A331F78EC8F1 ON `book`');
        $this->addSql('ALTER TABLE `book` DROP rent_book_id');
        $this->addSql('ALTER TABLE `news` CHANGE author author VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE title title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url_to_image url_to_image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE published_at published_at VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
