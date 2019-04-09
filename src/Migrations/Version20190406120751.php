<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190406120751 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_359F6E8FBEFD98D1');
        $this->addSql('DROP INDEX IDX_359F6E8FA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_training AS SELECT user_id, training_id FROM user_training');
        $this->addSql('DROP TABLE user_training');
        $this->addSql('CREATE TABLE user_training (user_id INTEGER NOT NULL, training_id INTEGER NOT NULL, PRIMARY KEY(user_id, training_id), CONSTRAINT FK_359F6E8FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_359F6E8FBEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_training (user_id, training_id) SELECT user_id, training_id FROM __temp__user_training');
        $this->addSql('DROP TABLE __temp__user_training');
        $this->addSql('CREATE INDEX IDX_359F6E8FBEFD98D1 ON user_training (training_id)');
        $this->addSql('CREATE INDEX IDX_359F6E8FA76ED395 ON user_training (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_359F6E8FA76ED395');
        $this->addSql('DROP INDEX IDX_359F6E8FBEFD98D1');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_training AS SELECT user_id, training_id FROM user_training');
        $this->addSql('DROP TABLE user_training');
        $this->addSql('CREATE TABLE user_training (user_id INTEGER NOT NULL, training_id INTEGER NOT NULL, PRIMARY KEY(user_id, training_id))');
        $this->addSql('INSERT INTO user_training (user_id, training_id) SELECT user_id, training_id FROM __temp__user_training');
        $this->addSql('DROP TABLE __temp__user_training');
        $this->addSql('CREATE INDEX IDX_359F6E8FA76ED395 ON user_training (user_id)');
        $this->addSql('CREATE INDEX IDX_359F6E8FBEFD98D1 ON user_training (training_id)');
    }
}
