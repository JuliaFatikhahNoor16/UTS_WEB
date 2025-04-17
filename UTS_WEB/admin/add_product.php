<?php
// add_product.php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Inisialisasi array products jika belum ada
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [];
}

// Proses form tambah/edit produk
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category = $_POST['category'];
    $description = trim($_POST['description']);
    $image = trim($_POST['image']);

    $product = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'stock' => $stock,
        'category' => $category,
        'description' => $description,
        'image' => $image
    ];

    if (isset($_POST['edit_mode']) && $_POST['edit_mode'] === '1') {
        // Edit produk
        foreach ($_SESSION['products'] as &$p) {
            if ($p['id'] == $id) {
                $p = $product;
                break;
            }
        }
    } else {
        // Tambah produk baru
        $_SESSION['products'][] = $product;
    }

    header('Location: manage_products.php');
    exit();
}

// Jika edit, ambil data produk
$product = null;
$edit_mode = false;
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_id = $_GET['edit'];
    foreach ($_SESSION['products'] as $p) {
        if ($p['id'] == $edit_id) {
            $product = $p;
            break;
        }
    }

    if (!$product) {
        header('Location: manage_products.php');
        exit();
    }
} else {
    // Generate ID baru untuk produk baru
    $new_id = 1;
    if (!empty($_SESSION['products'])) {
        $ids = array_column($_SESSION['products'], 'id');
        $new_id = max($ids) + 1;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $edit_mode ? 'Edit' : 'Tambah'; ?> Produk</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1><?php echo $edit_mode ? 'Edit' : 'Tambah'; ?> Produk</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Beranda</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="manage_products.php">Kelola Produk</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form method="post">
            <input type="hidden" name="edit_mode" value="<?php echo $edit_mode ? '1' : '0'; ?>">
            <input type="hidden" name="id" value="<?php echo $edit_mode ? $product['id'] : $new_id; ?>">

            <div class="form-group">
                <label>Nama Produk:</label>
                <input type="text" name="name" value="<?php echo $edit_mode ? htmlspecialchars($product['name']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label>Harga:</label>
                <input type="number" step="0.01" name="price" value="<?php echo $edit_mode ? $product['price'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label>Stok:</label>
                <input type="number" name="stock" value="<?php echo $edit_mode ? $product['stock'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label>Kategori:</label>
                <select name="category" required>
                    <option value="tableware" <?php echo ($edit_mode && $product['category'] == 'tableware') ? 'selected' : ''; ?>>Tableware</option>
                    <option value="decoration" <?php echo ($edit_mode && $product['category'] == 'decoration') ? 'selected' : ''; ?>>Decoration</option>
                    <option value="kitchenware" <?php echo ($edit_mode && $product['category'] == 'kitchenware') ? 'selected' : ''; ?>>Kitchenware</option>
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi:</label>
                <textarea name="description" rows="4" required><?php echo $edit_mode ? htmlspecialchars($product['description']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label>Nama File Gambar:</label>
                <input type="text" name="image" value="<?php echo $edit_mode ? htmlspecialchars($product['image']) : ''; ?>" required>
                <small>Contoh: produk1.jpg</small>
            </div>

            <button type="submit" name="save">Simpan</button>
            <a href="manage_products.php" class="btn-cancel">Batal</a>
        </form>
    </main>
</body>
</html>
