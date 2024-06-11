<?php
include '../includes/header.php';
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
include '../includes/config.php';

$message = '';
$message_type = '';

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Prepara la query di eliminazione
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    // Esegui la query
    if ($stmt->execute()) {
        $message = "Prodotto eliminato con successo.";
        $message_type = "success";
    } else {
        $message = "Errore durante l'eliminazione del prodotto: " . $stmt->error;
        $message_type = "danger";
    }

    $stmt->close();
} else {
    $message = "ID del prodotto non fornito.";
    $message_type = "danger";
}

$conn->close();

header("Location: manage_products.php?message=$message&message_type=$message_type");
exit;
?>
