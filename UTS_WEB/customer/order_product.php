<?php
session_start();
require_once '../admin/product.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $id = $_POST['product_id'];
    $qty = (int) $_POST['quantity'];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty;
    }

    $_SESSION['success'] = "Produk ditambahkan ke keranjang!";
    header("Location: order_product.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pesan Produk</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Customer Dashboard</h1>
            <nav>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="register_class.php">Register for Class</a></li>
                    <li><a href="order_product.php" class="active">Order Products</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="order-container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                <a href="cart.php" class="view-cart">Lihat Keranjang</a>
            </div>
        <?php endif; ?>

        <h1>Produk Tersedia</h1>
        
        <div class="product-grid">
            <?php foreach ($_SESSION['products'] as $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="../images/products/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                    </div>
                    <div class="product-info">
                        <h3><?= $product['name'] ?></h3>
                        <p class="description"><?= $product['description'] ?></p>
                        <p class="price">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                        <p class="stock">Stok: <?= $product['stock'] ?></p>
                        
                        <form method="post" class="add-to-cart-form">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <div class="quantity-selector">
                                <button type="button" class="qty-btn minus">-</button>
                                <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>">
                                <button type="button" class="qty-btn plus">+</button>
                            </div>
                            <button type="submit" name="add_to_cart">Tambah ke Keranjang</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        // Quantity selector functionality
        document.querySelectorAll('.qty-btn').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input[type=number]');
                if (this.classList.contains('minus')) {
                    input.stepDown();
                } else {
                    input.stepUp();
                }
            });
        });
    </script>
</body>
</html>