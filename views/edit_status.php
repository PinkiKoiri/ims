<?php
require '../config/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    $asset_id = (int)$_POST['asset_id'];

    $update_query = "UPDATE assets SET status='$new_status' WHERE sl_no=$asset_id";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Status updated successfully'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to update status');</script>";
    }
}

$asset_id = isset($_GET['asset_id']) ? (int)$_GET['asset_id'] : 0;
$query = "SELECT * FROM assets WHERE sl_no=$asset_id";
$result = mysqli_query($conn, $query);
$asset = mysqli_fetch_assoc($result);

if (!$asset) {
    echo "<script>alert('Asset not found'); window.location.href='dashboard.php';</script>";
    exit;
}
?>

<?php include 'header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Edit Asset Status</h1>
    <form class="form-row" method="POST">
        <input type="hidden" name="asset_id" value="<?php echo $asset['sl_no']; ?>">
        <div class="col-md-3 mb-3 form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="Active" <?php echo ($asset['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                <option value="Maintenance" <?php echo ($asset['status'] == 'Maintenance') ? 'selected' : ''; ?>>Maintenance</option>
                <option value="Non repairable" <?php echo ($asset['status'] == 'Non repairable') ? 'selected' : ''; ?>>Non repairable</option>
            </select>
        </div>
        <button type="submit" name="update_status" class="btn btn-primary">Update</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include 'footer.php'; ?>