<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

$product_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $expiry_date = $_POST['expiry_date'];
    $lot_number = $_POST['lot_number'];
    $image = $_POST['image'];  // In a real application, handle file uploads properly
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $category_id = $_POST['category_id'];

    $stmt = $conn->prepare("UPDATE products SET name = ?, expiry_date = ?, lot_number = ?, image = ?, quantity = ?, price = ?, type = ?, category_id = ? WHERE id = ?");
    $stmt->bind_param("ssssiisii", $name, $expiry_date, $lot_number, $image, $quantity, $price, $type, $category_id, $product_id);

    if ($stmt->execute()) {
        header('Location: manage_products.php');
        exit;
    } else {
        $error = 'Errore nell\'aggiornamento del prodotto.';
    }
} else {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        header('Location: manage_products.php');
        exit;
    }
}

$stmt = $conn->prepare("SELECT id, name FROM categories");
$stmt->execute();
$categories = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Modifica Prodotto</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-4">
        <h2>Modifica Prodotto</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="edit_product.php?id=<?php echo $product_id; ?>" method="post">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Data di Scadenza</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="<?php echo htmlspecialchars($product['expiry_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="lot_number">Numero di Lotto</label>
                <input type="text" class="form-control" id="lot_number" name="lot_number" value="<?php echo htmlspecialchars($product['lot_number']); ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Immagine</label>
                <input type="text" class="form-control" id="image" name="image" value="<?php echo htmlspecialchars($product['image']); ?>" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantità</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Prezzo</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="form-group">
                <label for="type">Tipologia</label>
                <input type="text" class="form-control" id="type" name="type" value="<?php echo htmlspecialchars($product['type']); ?>" required>
            </div>
            <div class="form-group">
                <label for="category_id">Categoria</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <?php while ($category = $categories->fetch_assoc()): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo $category['id'] == $product['category_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salva Modifiche</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
