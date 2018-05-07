<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180507182441 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gift ADD gift_list_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gift ADD CONSTRAINT FK_A47C990D51F42524 FOREIGN KEY (gift_list_id) REFERENCES gift_list (id)');
        $this->addSql('CREATE INDEX IDX_A47C990D51F42524 ON gift (gift_list_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gift DROP FOREIGN KEY FK_A47C990D51F42524');
        $this->addSql('DROP INDEX IDX_A47C990D51F42524 ON gift');
        $this->addSql('ALTER TABLE gift DROP gift_list_id');
    }
}
