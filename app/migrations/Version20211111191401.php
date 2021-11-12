<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211111191401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, transport_id INT NOT NULL, address LONGTEXT DEFAULT NULL, total_weight DOUBLE PRECISION NOT NULL, distance DOUBLE PRECISION NOT NULL, price INT NOT NULL, INDEX IDX_3781EC109909C13F (transport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, min_weight DOUBLE PRECISION NOT NULL, max_weight DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_delivery (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, delivery_id INT NOT NULL, weight DOUBLE PRECISION NOT NULL, INDEX IDX_5B8C24DB126F525E (item_id), INDEX IDX_5B8C24DB12136921 (delivery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, weight_limit DOUBLE PRECISION NOT NULL, distance_limit INT NOT NULL, distance_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC109909C13F FOREIGN KEY (transport_id) REFERENCES transport (id)');
        $this->addSql('ALTER TABLE item_delivery ADD CONSTRAINT FK_5B8C24DB126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE item_delivery ADD CONSTRAINT FK_5B8C24DB12136921 FOREIGN KEY (delivery_id) REFERENCES delivery (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item_delivery DROP FOREIGN KEY FK_5B8C24DB12136921');
        $this->addSql('ALTER TABLE item_delivery DROP FOREIGN KEY FK_5B8C24DB126F525E');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC109909C13F');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_delivery');
        $this->addSql('DROP TABLE transport');
    }
}
