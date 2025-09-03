<?php 
require_once __DIR__ . '/../helper/router-check.php';
require_once __DIR__ . '/../helper/api-config.php';
require_once __DIR__ . '/../includes/connect.php';

if (isset($get_id)) {
    $id = $get_id;
    $stmtdata = $conn->prepare("SELECT * FROM items WHERE id = ?");
    $stmtdata->bind_param("i", $id);
    $stmtdata->execute();
    $resultdata = $stmtdata->get_result();

    if ($data = $resultdata->fetch_assoc()) {
        http_response_code(200);
        echo json_encode([
            'status' => '1',
            'jumlah' => $resultdata->num_rows,
            'data' => $data,
        ]);
        exit();
    } else {
        http_response_code(404);
        echo json_encode([
            'status' => '0',
            'message' => 'Data tidak ditemukan'
        ]);
        exit();
    }
} else {
    $stmtdata = $conn->prepare("SELECT * FROM items ORDER BY id DESC");
    $stmtdata->execute();
    $resultdata = $stmtdata->get_result();
    
    $data = [];
    while ($row = $resultdata->fetch_assoc()) {
        $data[] = $row;
    }
    
    http_response_code(200);
    echo json_encode([
        'status' => '1',
        'jumlah' => $resultdata->num_rows,
        'data' => $data,
    ]);
    exit();
}

