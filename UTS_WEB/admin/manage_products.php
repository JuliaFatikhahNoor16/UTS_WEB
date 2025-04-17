<?php
session_start();
require_once 'product.php';

// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Proses pembaruan produk
if (isset($_POST['update_product'])) {
    $editId = $_POST['edit_id'];
    foreach ($_SESSION['products'] as &$product) {
        if ($product['id'] == $editId) {
            $product['name'] = $_POST['name'];
            $product['price'] = $_POST['price'];
            $product['stock'] = $_POST['stock'];
            $product['category'] = $_POST['category'];
            $_SESSION['message'] = "Produk berhasil diperbarui!";
            break;
        }
    }
    unset($product); // Hapus referensi
    header("Location: manage_products.php");
    exit();
}

// Hapus produk
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    foreach ($_SESSION['products'] as $index => $product) {
        if ($product['id'] == $deleteId) {
            unset($_SESSION['products'][$index]);
            $_SESSION['products'] = array_values($_SESSION['products']); // Reindex
            $_SESSION['message'] = "Produk berhasil dihapus!";
            break;
        }
    }
    header("Location: manage_products.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Produk</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Pottery Studio Admin</h1>
            <nav class="admin-nav">
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="manage_products.php" class="active">Manage Products</a></li>
                    <li><a href="add_product.php">Add Product</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="admin-container">
        <h2>Daftar Produk</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>

        <?php if (empty($_SESSION['products'])): ?>
            <div class="empty-state">
                <p>Belum ada produk. Tambahkan sekarang.</p>
                <a href="add_product.php" class="btn">Tambah Produk</a>
            </div>
        <?php else: ?>
        <div class="product-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['products'] as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td>
                                <?php if (!empty($product['image'])): ?>
                                    <img src="../images/products/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="product-thumbnail">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= htmlspecialchars($product['description']) ?></td>
                            <td>Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                            <td><?= $product['stock'] ?></td>
                            <td><?= ucfirst($product['category']) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="manage_products.php?edit=<?= $product['id'] ?>" class="btn-edit">Edit</a>
                                    <a href="manage_products.php?delete=<?= $product['id'] ?>" class="btn-delete" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['edit'])):
            $editId = $_GET['edit'];
            foreach ($_SESSION['products'] as $product) {
                if ($product['id'] == $editId) {
                    $editProduct = $product;
                    break;
                }
            }
            if (isset($editProduct)): ?>
            <div class="product-form">
                <h3>Edit Produk</h3>
                <form method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="edit_id" value="<?= $editProduct['id'] ?>">
                    
                    <div class="form-group">
                        <label>Nama Produk:</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($editProduct['name']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Deskripsi:</label>
                        <textarea name="description" required><?= htmlspecialchars($editProduct['description']) ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Harga (Rp):</label>
                        <input type="number" name="price" value="<?= $editProduct['price'] ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Stok:</label>
                        <input type="number" name="stock" value="<?= $editProduct['stock'] ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Kategori:</label>
                        <select name="category" required>
                            <option value="tableware" <?= $editProduct['category'] == 'tableware' ? 'selected' : '' ?>>Tableware</option>
                            <option value="decoration" <?= $editProduct['category'] == 'decoration' ? 'selected' : '' ?>>Decoration</option>
                            <option value="fashion" <?= $editProduct['category'] == 'fashion' ? 'selected' : '' ?>>Fashion</option>
                            <option value="storage" <?= $editProduct['category'] == 'storage' ? 'selected' : '' ?>>Storage</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Gambar Saat Ini:</label>
                        <?php if (!empty($editProduct['image'])): ?>
                            <img src="../images/products/<?= $editProduct['image'] ?>" class="product-image-preview">
                            <input type="hidden" name="current_image" value="<?= $editProduct['image'] ?>">
                        <?php else: ?>
                            <p>No image</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Ubah Gambar (biarkan kosong jika tidak ingin mengubah):</label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                    
                    <button type="submit" name="update_product" class="btn">Simpan Perubahan</button>
                </form>
            </div>
        <?php else: ?>
            <p>Produk tidak ditemukan.</p>
        <?php endif; ?>
        <?php endif; ?>
    </main>
</body>
</html>