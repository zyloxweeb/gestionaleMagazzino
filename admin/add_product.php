<?php
include '../includes/header.php';
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $expiry_date = $_POST['expiry_date'];
    $lot_number = $_POST['lot_number'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $category_id = $_POST['category_id'];

    $image = $_FILES['image']['name'];
    $target = "../assets/images/".basename($image);

    $sql = "INSERT INTO products (name, expiry_date, lot_number, image, quantity, price, type, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssdsii', $name, $expiry_date, $lot_number, $image, $quantity, $price, $type, $category_id);
    
    if ($stmt->execute() && move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        header('Location: manage_products.php');
        exit;
    } else {
        $error = "Errore nell'inserimento del prodotto";
    }
}

$categories = $conn->query("SELECT * FROM categories");
?>

<h1>Aggiungi Prodotto</h1>
<?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="expiry_date">Data di Scadenza</label>
        <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
    </div>
    <div class="form-group">
        <label for="lot_number">Numero Lotto</label>
        <input type="text" class="form-control" id="lot_number" name="lot_number" required>
    </div>
    <div class="form-group">
        <label for="image">Immagine</label>
        <input type="file" class="form-control-file" id="image" name="image" required>
    </div>
    <div class="form-group">
        <label for="quantity">Quantità</label>
        <input type="number" class="form-control" id="quantity" name="quantity" required>
    </div>
    <div class="form-group">
        <label for="price">Prezzo</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
    </div>
    <div class="form-group">
        <label for="type">Tipo</label>
        <select class="form-control" id="type" name="type" required>
            <option value="bottiglia">Bottiglia</option>
            <option value="lattina">Lattina</option>
            <option value="fusto">Fusto</option>
        </select>
    </div>
    <div class="form-group">
        <label for="category_id">Categoria</label>
        <select class="form-control" id="category_id" name="category_id" required>
            <?php while($row = $categories->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Aggiungi</button>
</form>

<?php include '../includes/footer.php'; ?>
