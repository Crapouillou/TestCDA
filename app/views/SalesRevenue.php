<!DOCTYPE html>
<html>
<head>
    <title>Tableau récapitulatif du chiffre d'affaires</title>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Tableau récapitulatif du chiffre d'affaires</h1>
    <table>
    <tr>
        <th>Vendeur</th>
        <th>Chiffre d'affaires</th>
    </tr>
    <?php foreach ($chiffreAffaireParVendeur as $vendeur => $chiffreAffaire) : ?>
        <tr>
            <td><?php echo $vendeur; ?></td>
            <td><?php echo $chiffreAffaire; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
    <form method="POST" action="index.php?action=tableau-recapitulatif">
        <button type="submit">Retour au formulaire</button>
    </form>
</body>
</html>