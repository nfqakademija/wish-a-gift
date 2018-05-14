<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180514053526 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE gift_list (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', first_name VARCHAR(101) NOT NULL, email VARCHAR(101) NOT NULL, title VARCHAR(200) NOT NULL, description LONGTEXT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', uuid_admin CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_B6B50A45D17F50A6 (uuid), UNIQUE INDEX UNIQ_B6B50A454A77331F (uuid_admin), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gift (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', gift_list_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', title VARCHAR(255) NOT NULL, reserved_at DATETIME DEFAULT NULL, reservation_token VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_A47C990D51F42524 (gift_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gift ADD CONSTRAINT FK_A47C990D51F42524 FOREIGN KEY (gift_list_id) REFERENCES gift_list (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gift DROP FOREIGN KEY FK_A47C990D51F42524');
        $this->addSql('DROP TABLE gift_list');
        $this->addSql('DROP TABLE gift');
    }
}
