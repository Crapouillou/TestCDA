<?php
require_once 'app/dbconnector.php';

class VentesController {
    private $pdo;

    public function __construct() {
        $dbConnector = new DbConnect();
        $this->pdo = $dbConnector->connect();
    }

    public function afficherFormulaire() {
        $stmt = $this->pdo->query("SELECT * FROM sellers ORDER BY id");
        $vendeurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        

        $stmt = $this->pdo->query("SELECT * FROM phones");
        $telephones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Afficher le formulaire
        require_once 'app/views/SellForm.php';
    }

    public function enregistrerVentes() {
        // Récupérer les données du formulaire
        $ventes = $_POST['ventes'];

        // Parcourir les ventes
        foreach ($ventes as $vendeurId => $telephones) {
            foreach ($telephones as $telephoneId => $nbVentes) {
                // Vérifier si le nombre de ventes est supérieur à 0
                $nbVentes = intval($nbVentes);
                if ($nbVentes > 0) {
                    // Insérer ou mettre à jour la vente dans la table "sell"
                    $stmt = $this->pdo->prepare("INSERT INTO sell (seller_id, phone_id, nb_sell) 
                                                VALUES (?, ?, ?) 
                                                ON DUPLICATE KEY UPDATE nb_sell = ?");
                    $stmt->execute([$vendeurId, $telephoneId, $nbVentes, $nbVentes]);
                }
            }
        }
        
        // Redirection vers une autre page après l'enregistrement
        header("Location: index.php?action=tableau-recapitulatif");

        exit();
    }
    public function getVentes() {
        $stmt = $this->pdo->query("SELECT s.name AS seller_name, p.name AS phone_name, se.nb_sell
                                    FROM sellers s
                                    CROSS JOIN phones p
                                    LEFT JOIN sell se ON se.seller_id = s.id AND se.phone_id = p.id
                                    ORDER BY s.name, p.name");
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function afficherTableauRecapitulatif() {
        $ventes = $this->getVentes();
    
        // Organiser les données de ventes dans un tableau à double entrées
        $tableauVentes = array();
        foreach ($ventes as $vente) {
            $sellerName = $vente['seller_name'];
            $phoneName = $vente['phone_name'];
            $nbVentes = $vente['nb_sell'];
            $tableauVentes[$sellerName][$phoneName] = $nbVentes;
        }
    
        // Récupérer les vendeurs et les téléphones pour la vue
        $stmt = $this->pdo->query("SELECT * FROM sellers");
        $vendeurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $stmt = $this->pdo->query("SELECT * FROM phones");
        $telephones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Passer les données à la vue
        require_once 'app/views/Array.php';
    }

}
       
    