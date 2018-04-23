<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180422152541 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gift_list CHANGE firstname firstname VARCHAR(101) DEFAULT NULL, CHANGE lastname lastname VARCHAR(100) DEFAULT NULL, CHANGE email email VARCHAR(101) DEFAULT NULL');
        $this->addSql('ALTER TABLE gift CHANGE gift gift VARCHAR(254) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gift CHANGE gift gift VARCHAR(254) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE gift_list CHANGE firstname firstname VARCHAR(101) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE lastname lastname VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(101) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
