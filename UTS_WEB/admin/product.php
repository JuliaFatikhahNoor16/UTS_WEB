<?php
require_once '../product.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Inisialisasi produk jika belum ada
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [
        [
            'id' => 1,
            'name' => 'Handmade Mug',
            'price' => 250000,
            'stock' => 10,
            'category' => 'tableware',
            'image' => 'handmade_mug.jpg',
            'description' => 'Cangkir keramik buatan tangan.'
        ],
        [
            'id' => 2,
            'name' => 'Decorative Vase',
            'price' => 450000,
            'stock' => 5,
            'category' => 'decoration',
            'image' => 'decorative_vase.jpg',
            'description' => 'Vas cantik untuk dekorasi rumah.'
        ],
        [
            'id' => 3,
            'name' => 'Bamboo Basket',
            'price' => 180000,
            'stock' => 8,
            'category' => 'storage',
            'image' => 'bamboo_basket.jpg',
            'description' => 'Keranjang anyaman bambu multifungsi.'
        ],
        [
            'id' => 4,
            'name' => 'Wooden Coaster Set',
            'price' => 120000,
            'stock' => 15,
            'category' => 'tableware',
            'image' => 'wooden_coaster.jpg',
            'description' => 'Set alas gelap kayu dengan motif alami.'
        ],
        [
            'id' => 5,
            'name' => 'Handwoven Scarf',
            'price' => 320000,
            'stock' => 7,
            'category' => 'fashion',
            'image' => 'handwoven_scarf.jpg',
            'description' => 'Syal tenun tangan dengan bahan katun lembut.'
        ],
        [
            'id' => 6,
            'name' => 'Ceramic Teapot',
            'price' => 380000,
            'stock' => 4,
            'category' => 'tableware',
            'image' => 'ceramic_teapot.jpg',
            'description' => 'Teh porselen buatan tangan dengan filter bawaan.'
        ],
        [
            'id' => 7,
            'name' => 'Macrame Wall Hanging',
            'price' => 275000,
            'stock' => 6,
            'category' => 'decoration',
            'image' => 'macrame_wall.jpg',
            'description' => 'Hiasan dinding makrame dengan desain modern.'
        ],
        [
            'id' => 8,
            'name' => 'Hand-carved Wooden Bowl',
            'price' => 210000,
            'stock' => 9,
            'category' => 'tableware',
            'image' => 'wooden_bowl.jpg',
            'description' => 'Mangkuk kayu ukiran tangan untuk buah atau salad.'
        ]
        ];
}

// Fungsi mengurangi stok produk
function reduceStock($product_id, $quantity) {
    foreach ($_SESSION['products'] as &$product) {
        if ($product['id'] == $product_id && $product['stock'] >= $quantity) {
            $product['stock'] -= $quantity;
            return true;
        }
    }
    return false;
}
?>