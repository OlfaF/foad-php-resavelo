<?php
// Démarrer la session si besoin 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Connexion BDD
require_once __DIR__ . '/../config/db_connect.php';

// Fonctions vélos
require_once __DIR__ . '/../includes/functions_velos.php';

// Initialisation des variables
$errors = [];
$success = '';
$velo = [
    'name' => '',
    'price' => '',
    'quantity' => '',
    'description' => '',
    'image_url' => ''
];

// Si on a un id dans l'URL, on est en mode "édition"
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int) $_GET['id'];
    $veloData = getVeloById($pdo, $id);

    if ($veloData) {
        $velo = $veloData;
    } else {
        $errors[] = "Vélo introuvable.";
    }
}

// Soumission du formulaire (ajout ou mise à jour)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération et nettoyage des données envoyées
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');

    // Validation  
        $errors[] = "Le nom est obligatoire.";
    }
    if ($price === '' || !is_numeric($price)) {
        $errors[] = "Le prix doit être un nombre.";
    }
    if ($quantity === '' || !ctype_digit($quantity)) {
        $errors[] = "La quantité doit être un entier.";
    }

    // Si pas d'erreurs, on sauvegarde
    if (empty($errors)) {
        $data = [
            'name' => $name,
            'price' => (float) $price,
            'quantity' => (int) $quantity,
            'description' => $description,
            'image_url' => $image_url,
        ];

        // Mode édition si un id est présent dans l'URL
        if (!empty($_GET['id'])) {
            $id = (int) $_GET['id'];
            $updated = updateVelo($pdo, $id, $data);
            if ($updated) {
                $success = "Vélo mis à jour avec succès.";
            } else {
                $errors[] = "Erreur lors de la mise à jour du vélo.";
            }
        } else {
            // Mode ajout
            $inserted = addVelo($pdo, $data);
            if ($inserted) {
                $success = "Vélo ajouté avec succès.";
                // On peut vider le formulaire après ajout
                $velo = [
                    'name' => '',
                    'price' => '',
                    'quantity' => '',
                    'description' => '',
                    'image_url' => ''
                ];
            } else {
                $errors[] = "Erreur lors de l'ajout du vélo.";
            }
        }
    } else {
        // On réinjecte les valeurs saisies si erreurs
        $velo = [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'description' => $description,
            'image_url' => $image_url
        ];
    }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo !empty($_GET['id']) ? 'Modifier un vélo' : 'Ajouter un vélo'; ?></title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<?php include __DIR__ . '/../includes/partials/header_admin.php'; ?>

<h1><?php echo !empty($_GET['id']) ? 'Modifier un vélo' : 'Ajouter un vélo'; ?></h1>

<!-- Affichage des messages d'erreurs -->
<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Message de succès -->
<?php if ($success) : ?>
    <div class="alert alert-success">
        <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<form method="post" action="">
    <div>
        <label for="name">Nom du vélo</label><br>
        <input type="text" id="name" name="name"
               value="<?php echo htmlspecialchars($velo['name']); ?>" required>
    </div>

    <div>
        <label for="price">Prix journalier (€)</label><br>
        <input type="number" step="0.01" id="price" name="price"
               value="<?php echo htmlspecialchars($velo['price']); ?>" required>
    </div>

    <div>
        <label for="quantity">Quantité disponible</label><br>
        <input type="number" id="quantity" name="quantity"
               value="<?php echo htmlspecialchars($velo['quantity']); ?>" required>
    </div>

    <div>
        <label for="description">Description</label><br>
        <textarea id="description" name="description" rows="4"><?php
            echo htmlspecialchars($velo['description']);
        ?></textarea>
    </div>

    <div>
        <label for="image_url">URL de l'image</label><br>
        <input type="text" id="image_url" name="image_url"
               value="<?php echo htmlspecialchars($velo['image_url']); ?>">
    </div>

    <br>

    <button type="submit">
        <?php echo !empty($_GET['id']) ? 'Mettre à jour' : 'Ajouter'; ?>
    </button>

    <a href="velos.php">Retour à la liste des vélos</a>
</form>

</body>
</html>