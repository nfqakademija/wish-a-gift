<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180504175856 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_B6B50A45D17F50A6 ON gift_list');
        $this->addSql('DROP INDEX UNIQ_B6B50A457BEAB3D1 ON gift_list');
        $this->addSql('ALTER TABLE gift_list CHANGE firstname firstname VARCHAR(101) NOT NULL, CHANGE email email VARCHAR(101) NOT NULL, CHANGE uuid uuid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE gift ADD active SMALLINT DEFAULT 1 NOT NULL, CHANGE gift gift VARCHAR(254) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gift DROP active, CHANGE gift gift VARCHAR(254) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE gift_list CHANGE firstname firstname VARCHAR(101) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(101) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE uuid uuid VARCHAR(254) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6B50A45D17F50A6 ON gift_list (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6B50A457BEAB3D1 ON gift_list (uuidadmin)');
    }
}
