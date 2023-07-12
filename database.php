<?php
$dbConnector = new DbConnect();
$pdo = $dbConnector->connect();

if ($pdo) {
    // Création de la table "sellers" avec contrainte d'unicité sur le nom
    $pdo->exec("CREATE TABLE IF NOT EXISTS sellers (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL UNIQUE
    )");

    // Peuplement de la table "sellers" (si elle est vide)
    $stmt = $pdo->query("SELECT COUNT(*) FROM sellers");
    $rowCount = $stmt->fetchColumn();
    if ($rowCount == 0) {
        $sellers = array("Alexis", "Paul", "Emmanuelle", "Gregory", "Theo");
        foreach ($sellers as $seller) {
            $stmt = $pdo->prepare("INSERT INTO sellers (name) VALUES (?)");
            $stmt->execute([$seller]);
        }
    }

    // Création de la table "phones" avec contrainte d'unicité sur le nom
    $pdo->exec("CREATE TABLE IF NOT EXISTS phones (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL UNIQUE,
        price DECIMAL(10, 2) DEFAULT 0.00
    )");

    // Peuplement de la table "phones" (si elle est vide)
    $stmt = $pdo->query("SELECT COUNT(*) FROM phones");
    $rowCount = $stmt->fetchColumn();
    if ($rowCount == 0) {
        $phones = array(
            array("name" => "Samsung Galaxy S22", "price" => 0.00),
            array("name" => "iPhone 14", "price" => 0.00),
            array("name" => "Xiaomi 12 Pro", "price" => 0.00),
            array("name" => "Honor Magic 4 Pro", "price" => 0.00)
        );
        foreach ($phones as $phone) {
            $stmt = $pdo->prepare("INSERT INTO phones (name, price) VALUES (:name, :price)");
            $stmt->execute($phone);
        }
    }
        // Création de la table "sell" avec clés étrangères sur les tables "sellers" et "phones"
        $pdo->exec("CREATE TABLE IF NOT EXISTS sell (
            seller_id INT,
            phone_id INT,
            nb_sell INT,
            
            PRIMARY KEY (seller_id, phone_id),
            FOREIGN KEY (seller_id) REFERENCES sellers(id),
            FOREIGN KEY (phone_id) REFERENCES phones(id)
        )");
} else {
    echo "Erreur de connexion à la base de données.";
}