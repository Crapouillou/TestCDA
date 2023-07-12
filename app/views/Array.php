<!DOCTYPE html>
<html>
<head>
    <title>Tableau récapitulatif des ventes</title>
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
<h1>Tableau récapitulatif des ventes</h1>
    <table>
        <tr>
            <th>Vendeur</th>
            <?php foreach ($telephones as $telephone): ?>
                <th><?php echo $telephone['name']; ?></th>
            <?php endforeach; ?>
        </tr>
        <?php foreach ($vendeurs as $vendeur): ?>
            <tr>
                <td><?php echo $vendeur['name']; ?></td>
                <?php foreach ($telephones as $telephone): ?>
                    <?php $nbVentes = isset($tableauVentes[$vendeur['name']][$telephone['name']]) ? $tableauVentes[$vendeur['name']][$telephone['name']] : 0; ?>
                    <td><?php echo $nbVentes; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <form method="POST" action="index.php?action=afficher-formulaire">
        
        <button type="submit">Retour au formulaire</button>
    </form>
    <p>Récapitulatif des ventes pour chaque modèle de téléphone :</p>
<ul>
    <?php foreach ($telephones as $telephone): ?>
        <?php $totalVentes = 0; ?>
        <?php foreach ($vendeurs as $vendeur): ?>
            <?php $nbVentes = isset($tableauVentes[$vendeur['name']][$telephone['name']]) ? $tableauVentes[$vendeur['name']][$telephone['name']] : 0; ?>
            <?php $totalVentes += $nbVentes; ?>
        <?php endforeach; ?>
        <li><?php echo $telephone['name']; ?> (dont l'id est : <?php echo $telephone['id']; ?>) : <?php echo $totalVentes; ?> ventes</li>
    <?php endforeach; ?>
</ul>

<form method="POST" action="index.php?action=saisir-prix">
    
    <button type="submit">Saisir les prix des téléphones</button>
</form>
<form method="POST" action="index.php?action=afficher-chiffre-affaire">
        <button type="submit">Acceder au chiffre d'affaires par vendeur</button>
    </form>

</body>
</html>