<?php
session_start();

// Cek apakah ada data dalam keranjang
if (empty($_SESSION['cart'])) {
    header("Location: order_product.php"); // Redirect ke halaman produk jika keranjang kosong
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total = 0;
    foreach ($_SESSION['cart'] as $product_id => $qty) {
        foreach ($_SESSION['products'] as $product) {
            if ($product['id'] == $product_id) {
                $total += $product['price'] * $qty;
            }
        }
    }

    $order = [
        'date' => date("Y-m-d"),
        'items' => $_SESSION['cart'],
        'total' => $total,
        'nama' => $_POST['nama'],
        'alamat' => $_POST['alamat'],
        'telepon' => $_POST['telepon']
    ];

    $_SESSION['orders'][] = $order;
    $_SESSION['success'] = "Pesanan berhasil diproses.";

    header("Location: order_confirmation.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        /* Add the CSS above here */
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Pottery Studio</h1>
            <nav>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="order_product.php">Back to Products</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="checkout-container">
        <h2>Form Checkout</h2>

        <h3>Daftar Produk yang Dibeli:</h3>
        <table class="cart-summary">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $product_id => $qty) {
                    foreach ($_SESSION['products'] as $product) {
                        if ($product['id'] == $product_id) {
                            $subtotal = $product['price'] * $qty;
                            $total += $subtotal;
                            echo "<tr>
                                    <td>{$product['name']}</td>
                                    <td>{$qty}</td>
                                    <td class='price'>Rp " . number_format($product['price'], 0, ',', '.') . "</td>
                                    <td class='price'>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
                                </tr>";
                        }
                    }
                }
                ?>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total Pembayaran:</strong></td>
                    <td class="total-price"><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
                </tr>
            </tbody>
        </table>

        <div class="checkout-form">
            <h3>Isi Data Pembeli:</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Nama:</label>
                    <input type="text" name="nama" required>
                </div>
                
                <div class="form-group">
                    <label>Alamat:</label>
                    <textarea name="alamat" required></textarea>
                </div>
                
                <div class="form-group">
                    <label>No Telepon:</label>
                    <input type="text" name="telepon" required>
                </div>
                
                <button type="submit" class="btn-submit">Proses Pesanan</button>
            </form>
        </div>
    </main>
</body>
</html>
