<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180504143543 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE gift_list (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(101) DEFAULT NULL, email VARCHAR(101) DEFAULT NULL, title VARCHAR(200) NOT NULL, description VARCHAR(100) NOT NULL, uuid VARCHAR(254) NOT NULL, uuidadmin VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B6B50A45D17F50A6 (uuid), UNIQUE INDEX UNIQ_B6B50A457BEAB3D1 (uuidadmin), INDEX IDX_B6B50A45D17F50A67BEAB3D1 (uuid, uuidadmin), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gift (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, gift VARCHAR(254) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE gift_list');
        $this->addSql('DROP TABLE gift');
    }
}
