<?php

require_once  __DIR__ .  '/../vendor/autoload.php';
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Seeder
{
    private static ?\PDO $pdo = null;

    private static function connect()
    {
        if (self::$pdo === null) {
          
            self::$pdo = new \PDO($_ENV['dsn'],
            $_ENV['DB_USER'],
              $_ENV['DB_PASSWORD']);
            
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public static function run()
    {
        self::connect();

        try {
                self::$pdo->exec("INSERT INTO citoyen (nom, prenom, numerocni, photoIdentite, lieuNaiss, dateNaiss) VALUES 
                ('Diop', 'sidi', '1234567890123', 'photo_identite1.jpg', 'Dakar', '1980-01-01'),
                ('Gueye', 'mohamed', '1344567890123', 'photo_identite2.jpg', 'Dakar', '2004-01-01'),
                ('Ly', 'Abdoulaye', '1454567890123', 'photo_identite3.jpg', 'Dakar', '2002-01-01'),
                ('Diallo', 'Alassane', '1564567890123', 'photo_identite4.jpg', 'Yeumbeul', '2001-01-01'),
                ('Ndiaye', 'Moussa', '1674567890123', 'photo_identite5.jpg', 'Dakar', '1998-01-01'),
                ('Sarr', 'Libasse', '1784567890123', 'photo_identite6.jpg', 'Sacre Coeur', '2005-11-21'),
                ('Ly', 'Abdoulaye', '1894567890123', 'photo_identite7.jpg', 'Mermoz', '2002-01-01')
                ");
            echo " Citoyen inséré.\n";
            echo "Toutes les données de test ont été insérées avec succès.\n";

        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion des données: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
}

Seeder::run();