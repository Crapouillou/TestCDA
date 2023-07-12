<!DOCTYPE html>
<html>
<head>
    <title>Saisie des prix des téléphones</title>
</head>
<body>
    <h1>Saisie des prix des téléphones</h1>

    <form method="POST" action="index.php?action=enregistrer-prix">
        <?php foreach ($telephones as $telephone): ?>
            <label for="<?php echo $telephone['id']; ?>"><?php echo $telephone['name']; ?> :</label>
            <input type="text" id="<?php echo $telephone['id']; ?>" name="prix[<?php echo $telephone['id']; ?>]"><br>
        <?php endforeach; ?>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
