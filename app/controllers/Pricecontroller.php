<?php
require_once 'app/dbconnector.php';

class PriceController {
    private $pdo;

    public function __construct() {
        $dbConnector = new DbConnect();
        $this->pdo = $dbConnector->connect();
    }

    public function afficherFormulairePrix() {
        // Récupérer les téléphones depuis la base de données
        $stmt = $this->pdo->query("SELECT * FROM phones");
        $telephones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Afficher le formulaire de saisie des prix des téléphones
        require_once 'app/views/Price.php';
    }

    public function enregistrerPrix() {
        // Récupérer les prix du formulaire
        
        $prix = $_POST['prix'];
        // Parcourir les prix et les mettre à jour dans la base de données
        foreach ($prix as $telephoneId => $prixTelephone) {
            // Vérifier si le prix est vide
            if (!empty($prixTelephone)) {
                // Vérifier si le prix est valide (vous pouvez ajouter une validation supplémentaire ici)
                $prixTelephone = floatval($prixTelephone);
        
                // Mettre à jour le prix dans la base de données
                $stmt = $this->pdo->prepare("UPDATE phones SET price = :price WHERE id = :id");
                $stmt->execute([
                    'price' => $prixTelephone,
                    'id' => $telephoneId
                ]);
            }
        }

        // Redirection vers une autre page après l'enregistrement
        header("Location: index.php?action=afficher-chiffre-affaire");
        exit();
    }

    public function afficherChiffreAffaire()
    {
        // Récupérer les vendeurs depuis la base de données
        $stmt = $this->pdo->query("SELECT * FROM sellers");
        $vendeurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Récupérer les téléphones depuis la base de données
        $stmt = $this->pdo->query("SELECT * FROM phones");
        $telephones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Récupérer les ventes pour chaque vendeur
        $stmt = $this->pdo->query("SELECT sellers.name AS vendeur, SUM(sell.nb_sell * phones.price) AS chiffre_affaire
        FROM sellers
        LEFT JOIN sell ON sellers.id = sell.seller_id
        LEFT JOIN phones ON sell.phone_id = phones.id
        GROUP BY sellers.id");
$ventes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
        // Initialiser le tableau pour stocker le chiffre d'affaires par vendeur
        $chiffreAffaireParVendeur = array();
    
        // Calculer le chiffre d'affaires pour chaque vendeur
        foreach ($vendeurs as $vendeur) {
            $chiffreAffaire = 0;
        
            // Parcourir les ventes pour trouver le chiffre d'affaires du vendeur actuel
            foreach ($ventes as $vente) {
                if ($vente['vendeur'] === $vendeur['name']) {
                    $chiffreAffaire = $vente['chiffre_affaire'];
                    break;
                }
            }
        
            // Stocker le chiffre d'affaires dans le tableau par vendeur
            $chiffreAffaireParVendeur[$vendeur['name']] = $chiffreAffaire;
        }
        
    
        // Passer les données à la vue
        require_once 'app/views/SalesRevenue.php';
    }
    
    
}