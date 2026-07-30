<?php
/**
 * Point d'entree du site - test de la POO
 * A placer dans : public/index.php
 */

require_once __DIR__ . '/../models/Patient.php';

// On cree un OBJET a partir de la CLASSE Patient
$patient = new Patient();

// On appelle une METHODE de cet objet
$listePatients = $patient->lister();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test POO - Cabinet dentaire</title>
    <style>
        body   { font-family: Arial, sans-serif; margin: 40px; background: #f0f2f5; }
        h1     { color: #2E5C8A; }
        .ok    { background: #d4edda; color: #155724; padding: 12px 16px;
                 border-radius: 8px; display: inline-block; }
        table  { border-collapse: collapse; margin-top: 24px; background: #fff;
                 box-shadow: 0 2px 6px rgba(0,0,0,.08); }
        th, td { padding: 10px 16px; border-bottom: 1px solid #eee; text-align: left; }
        th     { background: #2E5C8A; color: #fff; }
    </style>
</head>
<body>

    <h1>Cabinet dentaire Dr. Dupont</h1>

    <p class="ok">Connexion a la base de donnees reussie !</p>

    <h2>Liste des patients (<?= count($listePatients) ?>)</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Email</th>
            <th>Telephone</th>
        </tr>
        <?php foreach ($listePatients as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['id']) ?></td>
            <td><?= htmlspecialchars($p['nom']) ?></td>
            <td><?= htmlspecialchars($p['prenom']) ?></td>
            <td><?= htmlspecialchars($p['email']) ?></td>
            <td><?= htmlspecialchars($p['telephone'] ?? '-') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
