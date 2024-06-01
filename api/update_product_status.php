<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

// Funzione per aggiornare lo stato del prodotto
function updateProductStatus($conn) {
    $stmt = $conn->prepare("SELECT id, quantity FROM products");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($product = $result->fetch_assoc()) {
        $status = '';
        if ($product['quantity'] == 0) {
            $status = 'rosso';
        } elseif ($product['quantity'] < 10) {
            $status = 'giallo'; // Questo può essere impostato manualmente come richiesto
        } else {
            $status = 'verde';
        }

        $update_stmt = $conn->prepare("UPDATE products SET status = ? WHERE id = ?");
        $update_stmt->bind_param("si", $status, $product['id']);
        $update_stmt->execute();
    }
}

// Aggiorna lo stato dei prodotti
updateProductStatus($conn);

header('Location: manage_products.php');
exit;
