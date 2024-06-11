<?php
include '../includes/header.php';
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
include '../includes/config.php';

$message = isset($_GET['message']) ? $_GET['message'] : '';
$message_type = isset($_GET['message_type']) ? $_GET['message_type'] : '';

$products = $conn->query("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id");
?>

<h1>Gestisci Prodotti</h1>

<?php if ($message): ?>
    <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
<?php endif; ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Data di Scadenza</th>
            <th>Numero Lotto</th>
            <th>Immagine</th>
            <th>Quantità</th>
            <th>Prezzo</th>
            <th>Tipo</th>
            <th>Categoria</th>
            <th>Azioni</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $products->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['expiry_date']; ?></td>
                <td><?php echo $row['lot_number']; ?></td>
                <td><img src="../assets/images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" style="width: 50px; height: auto;"></td>
                <td><?php echo $row['quantity']; ?></td>
                <td>€<?php echo number_format($row['price'], 2); ?></td>
                <td><?php echo ucfirst($row['type']); ?></td>
                <td><?php echo $row['category_name']; ?></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Modifica</a>
                    <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questo prodotto?');">Elimina</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$conn->close();
include '../includes/footer.php';
?>
