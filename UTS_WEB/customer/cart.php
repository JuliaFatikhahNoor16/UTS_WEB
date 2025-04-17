<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}

$products = $_SESSION['products'];
$cart = $_SESSION['cart'] ?? [];
$total = 0;

// Hapus item dari keranjang
if (isset($_GET['remove'])) {
    $removeId = $_GET['remove'];
    unset($_SESSION['cart'][$removeId]);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Keranjang Belanja</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="order_product.php">Order Products</a></li>
                <li><a href="cart.php">Keranjang</a></li>
                <li><a href="checkout.php">Checkout</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

<main>
    <?php if (empty($cart)): ?>
        <p>Keranjang masih kosong.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Produk</th><th>Qty</th><th>Harga</th><th>Subtotal</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $id => $qty): 
                    $product = array_filter($products, fn($p) => $p['id'] == $id);
                    $product = array_values($product)[0]; 
                    $subtotal = $product['price'] * $qty;
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= $product['name'] ?></td>
                        <td><?= $qty ?></td>
                        <td>Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                        <td><a href="?remove=<?= $id ?>" onclick="return confirm('Hapus item?')">Hapus</a></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
                    <td><a href="checkout.php">Checkout</a></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>
</main>
</body>
</html>
