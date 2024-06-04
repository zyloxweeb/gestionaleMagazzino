<?php
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepara la query per ottenere i dettagli del prodotto
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    
    if (!$product) {
        echo "Prodotto non trovato.";
        exit;
    }

    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $expiry_date = $_POST['expiry_date'];
    $lot_number = $_POST['lot_number'];
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    $type = $_POST['type'];
    $category_id = intval($_POST['category_id']);

    // Formatta il prezzo
    $price = number_format($price, 2, '.', '');

    // Gestione dell'immagine
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target_dir = "assets/images/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

        // Prepara la query con l'immagine aggiornata
        $stmt = $conn->prepare("UPDATE products SET name = ?, expiry_date = ?, lot_number = ?, image = ?, quantity = ?, price = ?, type = ?, category_id = ? WHERE id = ?");
        $stmt->bind_param("sssisdsi", $name, $expiry_date, $lot_number, $image, $quantity, $price, $type, $category_id, $id);
    } else {
        // Prepara la query senza aggiornare l'immagine
        $stmt = $conn->prepare("UPDATE products SET name = ?, expiry_date = ?, lot_number = ?, quantity = ?, price = ?, type = ?, category_id = ? WHERE id = ?");
        $stmt->bind_param("sssisdsi", $name, $expiry_date, $lot_number, $quantity, $price, $type, $category_id, $id);
    }

    // Esegui la query
    if ($stmt->execute()) {
        header("Location: manage_products.php");
        exit;
    } else {
        echo "Errore durante l'aggiornamento del prodotto: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Richiesta non valida.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Modifica Prodotto</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container">
        <h2>Modifica Prodotto</h2>
        <form action="edit_product.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name'], ENT_QUOTES); ?>" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Data di Scadenza:</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="<?php echo $product['expiry_date']; ?>">
            </div>
            <div class="form-group">
                <label for="lot_number">Numero di Lotto:</label>
                <input type="text" class="form-control" id="lot_number" name="lot_number" value="<?php echo htmlspecialchars($product['lot_number'], ENT_QUOTES); ?>">
            </div>
            <div class="form-group">
                <label for="quantity">Quantità:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $product['quantity']; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Prezzo:</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
            </div>
            <div class="form-group">
                <label for="type">Tipo:</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="bottiglia" <?php if ($product['type'] === 'bottiglia') echo 'selected'; ?>>Bottiglia</option>
                    <option value="lattina" <?php if ($product['type'] === 'lattina') echo 'selected'; ?>>Lattina</option>
                    <option value="fusto" <?php if ($product['type'] === 'fusto') echo 'selected'; ?>>Fusto</option>
                </select>
            </div>
            <div class="form-group">
                <label for="category_id">Categoria:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <?php
                    $categories = $conn->query("SELECT * FROM categories");
                    while ($category = $categories->fetch_assoc()) {
                        echo '<option value="' . $category['id'] . '"' . ($product['category_id'] == $category['id'] ? ' selected' : '') . '>' . htmlspecialchars($category['name'], ENT_QUOTES) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Immagine:</label>
                <input type="file" class="form-control-file" id="image" name="image">
                <?php if ($product['image']): ?>
                    <img src="../assets/images/<?php echo htmlspecialchars($product['image'], ENT_QUOTES); ?>" alt="<?php echo htmlspecialchars($product['name'], ENT_QUOTES); ?>" style="max-width: 200px;">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Salva</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
