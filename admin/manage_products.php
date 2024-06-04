<?php

include '../includes/config.php';


// Funzione per eliminare un prodotto
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        header('Location: manage_products.php');
        exit;
    } else {
        $error = 'Errore nell\'eliminazione del prodotto.';
    }
}

// Recupera tutti i prodotti dal database
$stmt = $conn->prepare("SELECT products.*, categories.name as category_name FROM products JOIN categories ON products.category_id = categories.id");
$stmt->execute();
$products = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestisci Prodotti</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-4">
        <h2>Gestisci Prodotti</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Data di Scadenza</th>
                    <th>Numero di Lotto</th>
                    <th>Immagine</th>
                    <th>Quantità</th>
                    <th>Prezzo</th>
                    <th>Tipologia</th>
                    <th>Categoria</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $products->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['expiry_date']); ?></td>
                        <td><?php echo htmlspecialchars($product['lot_number']); ?></td>
                        <td><img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 50px;"></td>
                        <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($product['price']); ?></td>
                        <td><?php echo htmlspecialchars($product['type']); ?></td>
                        <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm">Modifica</a>
                            <a href="manage_products.php?delete_id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questo prodotto?');">Elimina</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
