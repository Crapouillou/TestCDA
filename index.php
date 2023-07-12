<?php

// Inclure les fichiers nécessaires
require_once 'app/dbconnector.php';
require_once 'app/controllers/SellController.php';
require_once 'app/controllers/PriceController.php';
require_once 'database.php';

// Créer une instance du contrôleur
$ventesController = new VentesController();
$prixController = new PriceController();

// Récupérer l'action à partir de la requête GET
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Effectuer le routage en fonction de l'action
switch ($action) {
    case 'afficher-formulaire':
        $ventesController->afficherFormulaire();
        break;
    case 'enregistrer-ventes':
        $ventesController->enregistrerVentes();
        break;
    case 'tableau-recapitulatif':
        $ventesController->afficherTableauRecapitulatif();
        break;
    case 'saisir-prix':
        $prixController->afficherFormulairePrix();
        break;
    case 'enregistrer-prix':
        $prixController->enregistrerPrix();
        break;
    case 'afficher-chiffre-affaire':
            $prixController->afficherChiffreAffaire();
            break;
    default:
        $ventesController->afficherFormulaire(); // Action par défaut, afficher le formulaire
        break;
}