<?php
session_start();

if (!isset($_SESSION['orders'])) {
    header("Location: order_product.php");
    exit();
}

$order = end($_SESSION['orders']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice Pembelian - Pottery Studio</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        /* ===================================== */
        /* Pottery Studio - Invoice Page         */
        /* ===================================== */
        
        .invoice-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            font-family: 'Arial', sans-serif;
        }
        
        .invoice-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--cream-color);
        }
        
        .invoice-header h2 {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .invoice-logo {
            max-width: 150px;
            margin-bottom: 1rem;
        }
        
        .customer-details {
            margin-bottom: 2rem;
            background: #f9f5f0;
            padding: 1.5rem;
            border-radius: 6px;
        }
        
        .customer-details h3 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }
        
        .customer-details p {
            margin: 0.5rem 0;
            line-height: 1.6;
        }
        
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
        }
        
        .invoice-table th {
            background: var(--primary-color);
            color: var(--white);
            padding: 1rem;
            text-align: left;
        }
        
        .invoice-table td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        
        .invoice-table tr:last-child td {
            border-bottom: none;
            font-weight: bold;
            background: #f9f5f0;
        }
        
        .price {
            color: var(--secondary-color);
        }
        
        .total-row {
            font-size: 1.1rem;
        }
        
        .success-message {
            color: var(--success-color);
            background: var(--success-bg);
            padding: 1rem;
            border-radius: 6px;
            margin: 1.5rem 0;
            text-align: center;
            border: 1px solid var(--success-border);
        }
        
        .action-buttons {
            margin-top: 2rem;
            text-align: center;
        }
        
        .btn-print {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
            display: inline-block;
            text-decoration: none;
            margin-right: 1rem;
        }
        
        .btn-print:hover {
            background: var(--secondary-color);
        }
        
        .btn-back {
            background: #6c757d;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
            display: inline-block;
        }
        
        .btn-back:hover {
            background: #5a6268;
        }
        
        @media print {
            body * {
                visibility: hidden;
            }
            .invoice-container, .invoice-container * {
                visibility: visible;
            }
            .invoice-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none;
            }
            .action-buttons {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .invoice-container {
                padding: 1rem;
            }
            
            .invoice-table {
                font-size: 0.9rem;
            }
            
            .invoice-table th, 
            .invoice-table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Pottery Studio</h1>
            <nav>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="invoice-container">
            <div class="invoice-header">
            <img src="../img/logo.png" alt="Pottery Studio Logo" class="invoice-logo" style="width: 100px; height: auto;">
            <h2>Invoice Pembelian</h2>
            <p>Tanggal: <strong><?= $order['date'] ?></strong></p>
            </div>
            
            <div class="customer-details">
                <h3>Detail Pelanggan</h3>
                <p><strong>Nama Penerima:</strong> <?= htmlspecialchars($order['nama']) ?></p>
                <p><strong>Alamat:</strong> <?= htmlspecialchars($order['alamat']) ?></p>
                <p><strong>No Telepon:</strong> <?= htmlspecialchars($order['telepon']) ?></p>
            </div>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="success-message">
                    <?= $_SESSION['success'] ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            
            <table class="invoice-table">
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
                    foreach ($order['items'] as $product_id => $quantity) {
                        foreach ($_SESSION['products'] as $product) {
                            if ($product['id'] == $product_id) {
                                $subtotal = $product['price'] * $quantity;
                                echo "<tr>
                                    <td>{$product['name']}</td>
                                    <td>{$quantity}</td>
                                    <td class='price'>Rp " . number_format($product['price'], 0, ',', '.') . "</td>
                                    <td class='price'>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
                                </tr>";
                            }
                        }
                    }
                    ?>
                    <tr class="total-row">
                        <td colspan="3"><strong>Total Pembayaran</strong></td>
                        <td class="price"><strong>Rp <?= number_format($order['total'], 0, ',', '.') ?></strong></td>
                    </tr>
                </tbody>
            </table>
            
            <div class="action-buttons">
                <button onclick="window.print()" class="btn-print">Cetak Invoice</button>
                <a href="dashboard.php" class="btn-back">Kembali ke Dashboard</a>
            </div>
        </div>
    </main>
</body>
</html>