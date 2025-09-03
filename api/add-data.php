<?php
require_once __DIR__ . '/../helper/router-check.php';
require_once __DIR__ . '/../helper/api-config.php';
require_once __DIR__ . '/../includes/connect.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input)) {
    http_response_code(400);
    echo json_encode([
        'status' => '0',
        'message' => 'Invalid input'
    ]);
    exit();
}

$nama = trim($input['nama'] ?? '');
$kategori = trim($input['kategori'] ?? '');
$harga = $input['harga'] ?? '';
$image_url = trim($input['image_url'] ?? '');

if (!$nama || !$kategori || !$harga || !$image_url) {
    http_response_code(400);
    echo json_encode([
        'status' => '0',
        'message' => 'Lengkapi semua input data'
    ]);
    exit();
}

if (!preg_match('/^[a-zA-Z\s]+$/', $nama)) {
    http_response_code(400);
    echo json_encode([
        'status' => '0',
        'message' => 'Nama harus berupa huruf'
    ]);
    exit();
}

if (!in_array($kategori, ['buah', 'sayur'])) {
    http_response_code(400);
    echo json_encode([
        'status' => '0',
        'message' => 'Kategori harus "buah" atau "sayur"'
    ]);
    exit();
}

if (!is_numeric($harga)) {
    http_response_code(400);
    echo json_encode([
        'status' => '0',
        'message' => 'Harga harus berupa angka'
    ]);
    exit();
}

if ($harga < 1) {
    http_response_code(400);
    echo json_encode([
        'status' => '0',
        'message' => 'Harga tidak boleh kurang dari 1'
    ]);
    exit();
}

if (!preg_match('/^https?:\/\//', $image_url)) {
    http_response_code(400);
    echo json_encode([
        'status' => '0',
        'message' => 'Masukan link gambar yang valid'
    ]);
    exit();
}

try {

    $stmtinsert = $conn->prepare("INSERT INTO items (nama, kategori, harga, image_url) VALUES (?, ?, ?, ?)");
    $stmtinsert->bind_param("ssis", $nama, $kategori, $harga, $image_url);

    if ($stmtinsert->execute()) {
        http_response_code(201);
        echo json_encode([
            'status' => '1',
            'message' => 'Data berhasil ditambahkan',
            'data' => $input
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'status' => '0',
            'message' => 'Data gagal ditambahkan'
        ]);
    }
} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode([
        'status' => '0',
        'message' => $th->getMessage()
    ]);
}
