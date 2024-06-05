<?php
include '../includes/header.php';
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
include '../includes/config.php';

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Prepara la query di eliminazione
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    // Esegui la query
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Prodotto eliminato con successo.</div>";
    } else {
        echo "<div class='alert alert-danger'>Errore durante l'eliminazione del prodotto: " . $stmt->error . "</div>";
    }

    $stmt->close();
} else {
    echo "<div class='alert alert-danger'>ID del prodotto non fornito.</div>";
}

$conn->close();

header('Location: manage_products.php');
exit;
?>
