<?php
require '../config/dbcon.php';
include 'header.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

$message = '';
$condition_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$asset_type = isset($_GET['asset_type']) ? $_GET['asset_type'] : '';
$serial_no = isset($_GET['serial_no']) ? $_GET['serial_no'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update data in the assets_condition table
    $update_query = "UPDATE assets_condition SET status = '$status' WHERE sl_no = $condition_id";

    if (mysqli_query($conn, $update_query)) {
        $message = "<div class='alert alert-success'>Asset status updated successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Fetch the asset condition data
$query = "SELECT * FROM assets_condition WHERE sl_no = $condition_id";
$result = mysqli_query($conn, $query);
$asset_condition = mysqli_fetch_assoc($result);

if (!$asset_condition) {
    echo "<script>alert('Asset condition not found'); window.location.href='analytics.php';</script>";
    exit;
}

// Fetch the corresponding asset data
$asset_query = "SELECT * FROM assets WHERE asset_type = '$asset_type' AND serial_no = '$serial_no'";
$asset_result = mysqli_query($conn, $asset_query);
$asset = mysqli_fetch_assoc($asset_result);

if (!$asset) {
    echo "<script>alert('Corresponding asset not found'); window.location.href='analytics.php';</script>";
    exit;
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Edit Asset Status</h3>
                </div>
                <div class="card-body">
                    <?php echo $message; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="asset_type" class="form-label">Asset Type</label>
                            <input type="text" class="form-control" id="asset_type" value="<?php echo htmlspecialchars($asset['asset_type']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="model_no" class="form-label">Model Number</label>
                            <input type="text" class="form-control" id="model_no" value="<?php echo htmlspecialchars($asset['model_no']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="serial_no" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="serial_no" value="<?php echo htmlspecialchars($asset['serial_no']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="Active" <?php echo ($asset_condition['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                                <option value="Maintenance" <?php echo ($asset_condition['status'] == 'Maintenance') ? 'selected' : ''; ?>>Maintenance</option>
                                <option value="Non repairable" <?php echo ($asset_condition['status'] == 'Non repairable') ? 'selected' : ''; ?>>Non repairable</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>