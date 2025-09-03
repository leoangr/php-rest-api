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

$id = $get_id;
$nama = trim($input['nama'] ?? '');
$kategori = trim($input['kategori'] ?? '');
$harga = $input['harga'] ?? '';
$image_url = trim($input['image_url'] ?? '');


if (!is_numeric($id)) {
    http_response_code(400);
    echo json_encode([
        'status' => '0',
        'message' => 'ID tidak valid'
    ]);
    exit();
}

$stmtCheck = $conn->prepare("SELECT id FROM items WHERE id = ?");
$stmtCheck->bind_param("i", $id);
$stmtCheck->execute();
$result = $stmtCheck->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode([
        'status' => '0',
        'message' => 'Data dengan ID tersebut tidak ditemukan'
    ]);
    exit();
}

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

if ($harga < 0) {
    http_response_code(400);
    echo json_encode([
        'status' => '0',
        'message' => 'Harga tidak boleh negatif'
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

    $stmtupdate = $conn->prepare("UPDATE items SET nama = ?, kategori = ?, harga = ?, image_url = ? WHERE id = ?");
    $stmtupdate->bind_param("ssisi", $nama, $kategori, $harga, $image_url, $id);
    
    if ($stmtupdate->execute()) {
        http_response_code(201);
        echo json_encode([
            'status' => '1',
            'message' => 'Data berhasil diupdate',
            'data' => $input
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'status' => '0',
            'message' => 'Data gagal diupdate'
        ]);
    }

} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode([
        'status' => '0',
        'message' => $th->getMessage()
    ]);
}