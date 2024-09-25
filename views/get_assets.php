<?php
require '../config/dbcon.php';

$status = isset($_GET['status']) ? $_GET['status'] : '';

$query = "SELECT * FROM assets_condition WHERE status = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $status);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$assets = [];
while ($row = mysqli_fetch_assoc($result)) {
    $assets[] = $row;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($assets);
