<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170817125011 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commandes (id INT AUTO_INCREMENT NOT NULL, proforma_id INT DEFAULT NULL, created DATETIME NOT NULL, delivery DATE NOT NULL, status INT NOT NULL, reference VARCHAR(225) NOT NULL, UNIQUE INDEX UNIQ_35D4282CB26BFE8D (proforma_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compagny (id INT AUTO_INCREMENT NOT NULL, country VARCHAR(255) NOT NULL, bank VARCHAR(255) NOT NULL, compte_cc VARCHAR(255) DEFAULT NULL, center_impot VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, adresse LONGTEXT NOT NULL, street VARCHAR(255) NOT NULL, regime VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, represent VARCHAR(255) NOT NULL, phone_two VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, fax VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conditions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, informations LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrepot (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, lng VARCHAR(255) DEFAULT NULL, lnt VARCHAR(255) DEFAULT NULL, created DATE NOT NULL, UNIQUE INDEX UNIQ_D805175A989D9B62 (slug), INDEX IDX_D805175AF6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mark (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mouvement (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id VARCHAR(36) NOT NULL, unites_id INT DEFAULT NULL, category_id INT DEFAULT NULL, marks_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, reference VARCHAR(255) NOT NULL, buy_price BIGINT DEFAULT NULL COMMENT \'Prix d\'\'achat de la machandise\', hire_price BIGINT DEFAULT NULL COMMENT \'Prix de location de la machandise\', cout BIGINT DEFAULT NULL COMMENT \'Cout du produit de type service\', coef DOUBLE PRECISION DEFAULT NULL COMMENT \'coefficient de multiplication du produits pour la vente\', min_stock INT DEFAULT NULL COMMENT \'stock minimum du produit\', description LONGTEXT DEFAULT NULL, type INT DEFAULT NULL COMMENT \'Type de service : soit produit ou service\', created DATE NOT NULL, UNIQUE INDEX UNIQ_D34A04AD989D9B62 (slug), UNIQUE INDEX UNIQ_D34A04ADAEA34913 (reference), INDEX IDX_D34A04ADA6998D31 (unites_id), INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04AD4B8FD494 (marks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proforma (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, condition_id INT DEFAULT NULL, user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', client_id INT DEFAULT NULL, compagny_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, reference_view VARCHAR(255) NOT NULL, created DATE NOT NULL, updated DATE NOT NULL, status INT NOT NULL, arrete LONGTEXT DEFAULT NULL, local VARCHAR(225) DEFAULT NULL COMMENT \'Localisation de la proforma de location\', start DATE DEFAULT NULL COMMENT \'Date de debut de la location\', end DATE DEFAULT NULL COMMENT \'Date de fin de la location\', subject LONGTEXT DEFAULT NULL, INDEX IDX_8383AFD6ED5CA9E6 (service_id), INDEX IDX_8383AFD6887793B6 (condition_id), INDEX IDX_8383AFD6A76ED395 (user_id), INDEX IDX_8383AFD619EB6921 (client_id), INDEX IDX_8383AFD61224ABE0 (compagny_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proformas_products (id INT AUTO_INCREMENT NOT NULL, proforma_id INT DEFAULT NULL, product_id VARCHAR(36) DEFAULT NULL, qte_cmd INT NOT NULL, price BIGINT NOT NULL, remise DOUBLE PRECISION DEFAULT NULL, mont_ht BIGINT NOT NULL, created DATE NOT NULL, duration INT DEFAULT NULL COMMENT \'information à renseigné si la proforma est de type location\', INDEX IDX_88DF9D1CB26BFE8D (proforma_id), INDEX IDX_88DF9D1C4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, lng VARCHAR(255) DEFAULT NULL, lnt VARCHAR(255) DEFAULT NULL, created DATE NOT NULL, UNIQUE INDEX UNIQ_694309E4989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, product_id VARCHAR(36) DEFAULT NULL, entrepot_id INT DEFAULT NULL, mouvement_id INT DEFAULT NULL, reference VARCHAR(8) NOT NULL COMMENT \'référence de l\'\'inventaire\', sku VARCHAR(8) NOT NULL COMMENT \'faire référence au produit relié a ce mouvement\', code_mouv INT NOT NULL COMMENT \'correspond au status du mouvement du stock\', referrer VARCHAR(225) DEFAULT NULL COMMENT \'reference à la quelle ce mouvement est relié\', quantity INT NOT NULL, created DATE NOT NULL, updated DATE NOT NULL, INDEX IDX_4B3656604584665A (product_id), INDEX IDX_4B36566072831E97 (entrepot_id), INDEX IDX_4B365660ECD1C222 (mouvement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unite (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, adresse LONGTEXT DEFAULT NULL, representant VARCHAR(255) NOT NULL, created DATE NOT NULL, email_entreprise VARCHAR(255) DEFAULT NULL, email_represent VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_C7440455989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', firstname VARCHAR(225) DEFAULT NULL, lastname VARCHAR(225) DEFAULT NULL, UNIQUE INDEX UNIQ_D5428AED92FC23A8 (username_canonical), UNIQUE INDEX UNIQ_D5428AEDA0D96FBF (email_canonical), UNIQUE INDEX UNIQ_D5428AEDC05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CB26BFE8D FOREIGN KEY (proforma_id) REFERENCES proforma (id)');
        $this->addSql('ALTER TABLE entrepot ADD CONSTRAINT FK_D805175AF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA6998D31 FOREIGN KEY (unites_id) REFERENCES unite (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4B8FD494 FOREIGN KEY (marks_id) REFERENCES mark (id)');
        $this->addSql('ALTER TABLE proforma ADD CONSTRAINT FK_8383AFD6ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE proforma ADD CONSTRAINT FK_8383AFD6887793B6 FOREIGN KEY (condition_id) REFERENCES conditions (id)');
        $this->addSql('ALTER TABLE proforma ADD CONSTRAINT FK_8383AFD6A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE proforma ADD CONSTRAINT FK_8383AFD619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE proforma ADD CONSTRAINT FK_8383AFD61224ABE0 FOREIGN KEY (compagny_id) REFERENCES compagny (id)');
        $this->addSql('ALTER TABLE proformas_products ADD CONSTRAINT FK_88DF9D1CB26BFE8D FOREIGN KEY (proforma_id) REFERENCES proforma (id)');
        $this->addSql('ALTER TABLE proformas_products ADD CONSTRAINT FK_88DF9D1C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B3656604584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566072831E97 FOREIGN KEY (entrepot_id) REFERENCES entrepot (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660ECD1C222 FOREIGN KEY (mouvement_id) REFERENCES mouvement (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE proforma DROP FOREIGN KEY FK_8383AFD61224ABE0');
        $this->addSql('ALTER TABLE proforma DROP FOREIGN KEY FK_8383AFD6887793B6');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566072831E97');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4B8FD494');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660ECD1C222');
        $this->addSql('ALTER TABLE proformas_products DROP FOREIGN KEY FK_88DF9D1C4584665A');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656604584665A');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282CB26BFE8D');
        $this->addSql('ALTER TABLE proformas_products DROP FOREIGN KEY FK_88DF9D1CB26BFE8D');
        $this->addSql('ALTER TABLE proforma DROP FOREIGN KEY FK_8383AFD6ED5CA9E6');
        $this->addSql('ALTER TABLE entrepot DROP FOREIGN KEY FK_D805175AF6BD1646');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA6998D31');
        $this->addSql('ALTER TABLE proforma DROP FOREIGN KEY FK_8383AFD619EB6921');
        $this->addSql('ALTER TABLE proforma DROP FOREIGN KEY FK_8383AFD6A76ED395');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE commandes');
        $this->addSql('DROP TABLE compagny');
        $this->addSql('DROP TABLE conditions');
        $this->addSql('DROP TABLE entrepot');
        $this->addSql('DROP TABLE mark');
        $this->addSql('DROP TABLE mouvement');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE proforma');
        $this->addSql('DROP TABLE proformas_products');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE unite');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE Users');
    }
}
