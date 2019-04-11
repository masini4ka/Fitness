<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190411121950 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE user ADD COLUMN notificationtype SMALLINT DEFAULT NULL');
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

        $this->addSql('DROP INDEX UNIQ_8D93D64992FC23A8');
        $this->addSql('DROP INDEX UNIQ_8D93D649A0D96FBF');
        $this->addSql('DROP INDEX UNIQ_8D93D649C05FB297');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles, fio, birthdate, gender, phonenumber FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:array)
        , fio VARCHAR(45) NOT NULL, birthdate DATE NOT NULL, gender VARCHAR(5) NOT NULL, phonenumber VARCHAR(15) NOT NULL)');
        $this->addSql('INSERT INTO user (id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles, fio, birthdate, gender, phonenumber) SELECT id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles, fio, birthdate, gender, phonenumber FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64992FC23A8 ON user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A0D96FBF ON user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C05FB297 ON user (confirmation_token)');
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
