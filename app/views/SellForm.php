<!DOCTYPE html>
<html>
<head>
    <title>Formulaire de saisie des ventes</title>
</head>
<body>
    <h1>Saisie des ventes</h1>
    <form method="POST" action="index.php?action=enregistrer-ventes">

    <?php foreach ($vendeurs as $vendeur): ?>
    <h2><?php echo $vendeur['name']; ?></h2>
    <?php foreach ($telephones as $telephone): ?>
        <label for="vente_<?php echo $vendeur['id']; ?>_<?php echo $telephone['id']; ?>">
            Combien de <?php echo $telephone['name']; ?> ont été vendus par <?php echo $vendeur['name']; ?> ?
        </label>
        <input type="number" name="ventes[<?php echo $vendeur['id']; ?>][<?php echo $telephone['id']; ?>]" min="0" value="0" required>
        <br>
    <?php endforeach; ?>
    <hr>
<?php endforeach; ?>

        <input type="submit" value="Enregistrer">
    </form>
</body>
</html>
