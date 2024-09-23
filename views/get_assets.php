<?php
session_start();
require '../config/dbcon.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$status = isset($_GET['status']) ? $_GET['status'] : 'all';

$query = "SELECT sl_no, asset_type, model_no, serial_no, location, status FROM assets";

if ($status !== 'all') {
    $query .= " WHERE status = ?";
}

$query .= " ORDER BY sl_no";

$stmt = $conn->prepare($query);

if ($status !== 'all') {
    $stmt->bind_param("s", $status);
}

$stmt->execute();
$result = $stmt->get_result();

$assets = [];
while ($row = $result->fetch_assoc()) {
    $assets[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($assets);
