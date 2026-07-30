<?php
/**
 * Classe Database
 * Gere la connexion a la base de donnees MySQL via PDO.
 * A placer dans : config/Database.php
 */
class Database
{
    // Attributs PRIVES : proteges de l'exterieur (encapsulation)
    private string $host;
    private string $dbname;
    private string $user;
    private string $password;
    private ?PDO $connexion = null;

    /**
     * Le constructeur s'execute automatiquement a la creation de l'objet.
     * Il lit les identifiants dans config/config.php.
     */
    public function __construct()
    {
        $config = require __DIR__ . '/config.php';

        $this->host     = $config['host'];
        $this->dbname   = $config['dbname'];
        $this->user     = $config['user'];
        $this->password = $config['password'];
    }

    /**
     * Retourne la connexion PDO.
     * La connexion n'est creee qu'une seule fois puis reutilisee.
     */
    public function getConnexion(): PDO
    {
        if ($this->connexion === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";

                $this->connexion = new PDO($dsn, $this->user, $this->password);

                // Afficher les erreurs SQL sous forme d'exceptions
                $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Recuperer les resultats sous forme de tableaux associatifs
                $this->connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die('Erreur de connexion a la base de donnees : ' . $e->getMessage());
            }
        }

        return $this->connexion;
    }
}
