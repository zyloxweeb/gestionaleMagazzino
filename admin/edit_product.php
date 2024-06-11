<?php
include '../includes/header.php';
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
include '../includes/config.php';

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM products WHERE id = $product_id");
    $product = $result->fetch_assoc();
}

// Recupera le categorie per il form
$categories = $conn->query("SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    } else {
        $image = $product['image'];
    }

    // Prepara la query di aggiornamento
    $stmt = $conn->prepare("UPDATE products SET name = ?, expiry_date = ?, lot_number = ?, image = ?, quantity = ?, price = ?, type = ?, category_id = ? WHERE id = ?");
    $stmt->bind_param("sssisdsi", $name, $expiry_date, $lot_number, $image, $quantity, $price, $type, $category_id, $product_id);

    // Esegui la query
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Prodotto aggiornato con successo.</div>";
    } else {
        echo "<div class='alert alert-danger'>Errore durante l'aggiornamento del prodotto: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<h1>Modifica Prodotto</h1>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>" required>
    </div>
    <div class="form-group">
        <label for="expiry_date">Data di Scadenza</label>
        <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="<?php echo $product['expiry_date']; ?>" required>
    </div>
    <div class="form-group">
        <label for="lot_number">Numero Lotto</label>
        <input type="text" class="form-control" id="lot_number" name="lot_number" value="<?php echo $product['lot_number']; ?>" required>
    </div>
    <div class="form-group">
        <label for="image">Immagine</label>
        <input type="file" class="form-control-file" id="image" name="image">
        <?php if ($product['image']): ?>
            <img src="../assets/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="width: 100px; height: auto;">
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="quantity">Quantità</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $product['quantity']; ?>" required>
    </div>
    <div class="form-group">
        <label for="price">Prezzo</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo number_format($product['price'], 2); ?>" required>
    </div>
    <div class="form-group">
        <label for="type">Tipo</label>
        <select class="form-control" id="type" name="type" required>
            <option value="bottiglia" <?php echo $product['type'] == 'bottiglia' ? 'selected' : ''; ?>>Bottiglia</option>
            <option value="lattina" <?php echo $product['type'] == 'lattina' ? 'selected' : ''; ?>>Lattina</option>
            <option value="fusto" <?php echo $product['type'] == 'fusto' ? 'selected' : ''; ?>>Fusto</option>
        </select>
    </div>
    <div class="form-group">
        <label for="category_id">Categoria</label>
        <select class="form-control" id="category_id" name="category_id" required>
            <?php while ($row = $categories->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $product['category_id'] ? 'selected' : ''; ?>><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Aggiorna</button>
</form>

<?php include '../includes/footer.php'; ?>
