<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217141200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_images (users_id INT NOT NULL, images_id INT NOT NULL, INDEX IDX_EFF830FA67B3B43D (users_id), INDEX IDX_EFF830FAD44F05E5 (images_id), PRIMARY KEY(users_id, images_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_images ADD CONSTRAINT FK_EFF830FA67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_images ADD CONSTRAINT FK_EFF830FAD44F05E5 FOREIGN KEY (images_id) REFERENCES images (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_images DROP FOREIGN KEY FK_EFF830FA67B3B43D');
        $this->addSql('ALTER TABLE users_images DROP FOREIGN KEY FK_EFF830FAD44F05E5');
        $this->addSql('DROP TABLE users_images');
    }
}
