<?php
require '../config/dbcon.php';
include 'header.php';

$message = '';

// Fetch asset types and their quantities from the assets table
$asset_types_query = "SELECT asset_type, quantity, model_no, serial_no FROM assets";
$asset_types_result = mysqli_query($conn, $asset_types_query);
$asset_types = [];
while ($row = mysqli_fetch_assoc($asset_types_result)) {
    $asset_types[$row['asset_type']] = [
        'quantity' => $row['quantity'],
        'model_no' => $row['model_no'],
        'serial_no' => $row['serial_no']
    ];
}

// Count the number of locations for each asset type in assets_condition table
$asset_locations_query = "SELECT asset_type, COUNT(DISTINCT location) as location_count FROM assets_condition GROUP BY asset_type";
$asset_locations_result = mysqli_query($conn, $asset_locations_query);
$asset_locations = [];
while ($row = mysqli_fetch_assoc($asset_locations_result)) {
    $asset_locations[$row['asset_type']] = $row['location_count'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $asset_type = mysqli_real_escape_string($conn, $_POST['asset_type']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $serial_no = mysqli_real_escape_string($conn, $_POST['serial_no']);
    $model_no = mysqli_real_escape_string($conn, $_POST['model_no']);

    // Check if the asset type is valid
    $location_count = isset($asset_locations[$asset_type]) ? $asset_locations[$asset_type] : 0;
    if ($location_count < $asset_types[$asset_type]['quantity']) {
        // Insert data into the assets_condition table
        $query = "INSERT INTO assets_condition (location, asset_type, status, serial_no, model_no) VALUES ('$location', '$asset_type', '$status', '$serial_no', '$model_no')";

        if (mysqli_query($conn, $query)) {
            $message = "<div class='alert alert-success'>Data inserted successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Error: The selected asset type has reached its maximum quantity across locations.</div>";
    }
}

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Add Asset Location & Status</h3>
                </div>
                <div class="card-body">
                    <?php echo $message; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="location" class="form-label">Location of Physical Installation</label>
                            <select class="form-select form-control cursor-pointer" id="location" name="location" required>
                                <option value="">Select Department</option>
                                <?php
                                include 'departments.php';
                                foreach ($departments as $campus => $campusDepartments) {
                                    foreach ($campusDepartments as $department) {
                                        echo "<option value=\"$department\">$department</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="asset_type" class="form-label">Asset Type</label>
                            <select class="form-select" id="asset_type" name="asset_type" required>
                                <option value="">Select Asset Type</option>
                                <?php foreach ($asset_types as $type => $data): ?>
                                    <?php
                                    $location_count = isset($asset_locations[$type]) ? $asset_locations[$type] : 0;
                                    if ($data['quantity'] > $location_count):
                                    ?>
                                        <option value="<?php echo htmlspecialchars($type); ?>"
                                            data-model="<?php echo htmlspecialchars($data['model_no']); ?>"
                                            data-serial="<?php echo htmlspecialchars($data['serial_no']); ?>">
                                            <?php echo htmlspecialchars($type); ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="Active">Active</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Non repairable">Non repairable</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="serial_no" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="serial_no" name="serial_no" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="model_no" class="form-label">Model Number</label>
                            <input type="text" class="form-control" id="model_no" name="model_no" required readonly>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>

                            <button type="submit" class="btn btn-primary">Add Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const assetTypeSelect = document.getElementById('asset_type');
        const serialNoInput = document.getElementById('serial_no');
        const modelNoInput = document.getElementById('model_no');

        assetTypeSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            serialNoInput.value = selectedOption.dataset.serial || '';
            modelNoInput.value = selectedOption.dataset.model || '';
        });
    });
</script>

<?php include 'footer.php'; ?>