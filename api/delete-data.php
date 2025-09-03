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

if (!is_numeric($id)) {
    http_response_code(400);
    echo json_encode([
        'status' => '0',
        'message' => 'ID tidak valid'
    ]);
    exit();
}

try {

    $stmtselect = $conn->prepare("SELECT id FROM items WHERE id = ?");
    $stmtselect->bind_param("i", $id);
    $stmtselect->execute();
    $result = $stmtselect->get_result();

    if ($result->num_rows == 0) {
        http_response_code(404);
        echo json_encode([
            'status' => '0',
            'message' => 'Data tidak ditemukan'
        ]);
        exit();
    } 

    $stmtdelete = $conn->prepare("DELETE FROM items WHERE id = ?");
    $stmtdelete->bind_param("i", $id);
    
    if ($stmtdelete->execute()) {
        http_response_code(201);
        echo json_encode([
            'status' => '1',
            'message' => 'Data berhasil dihapus'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'status' => '0',
            'message' => 'Data gagal dihapus'
        ]);
    }

} catch (\Throwable $th) {
    
    http_response_code(500);
    echo json_encode([
        'status' => '0',
        'message' => $th->getMessage()
    ]);

}