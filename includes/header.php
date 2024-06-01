<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../gestionaleMagazzino/auth/login.php');
    exit;
}

// Determina il base URL
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

$base_path = '/5BIA/gestionaleMagazzino/'; // Specifica il percorso base del tuo progetto, se necessario

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Magazzino</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url . $base_path; ?>assets/css/styles.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo $base_url . $base_path; ?>assets/js/scripts.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo $base_url . $base_path; ?>index.php">Magazzino</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_url . $base_path; ?>admin/manage_products.php">Gestisci Prodotti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_url . $base_path; ?>admin/add_product.php">Aggiungi Prodotto</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url . $base_path; ?>auth/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
