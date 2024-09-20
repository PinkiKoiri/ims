<?php
require '../config/dbcon.php';
include 'header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $asset_type = mysqli_real_escape_string($conn, $_POST['asset_type']);
    $model_no = mysqli_real_escape_string($conn, $_POST['model_no']);
    $serial_no = mysqli_real_escape_string($conn, $_POST['serial_no']);
    $delivery_date = mysqli_real_escape_string($conn, $_POST['delivery_date']);
    $installation_type = mysqli_real_escape_string($conn, $_POST['installation_type']);
    $installation_date = mysqli_real_escape_string($conn, $_POST['installation_date']);
    $po_order_ref_no = mysqli_real_escape_string($conn, $_POST['po_order_ref_no']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $warranty = mysqli_real_escape_string($conn, $_POST['warranty']);

    // Insert data into the database
    $query = "INSERT INTO assets (asset_type, model_no, serial_no, delivery_date, installation_type, installation_date, po_order_ref_no, location, status, warranty) 
              VALUES ('$asset_type', '$model_no', '$serial_no', '$delivery_date', '$installation_type', '$installation_date', '$po_order_ref_no', '$location', '$status', '$warranty')";

    if (mysqli_query($conn, $query)) {
        $message = "<div class='alert alert-success'>Asset added successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Add New Asset</h3>
                </div>
                <div class="card-body">
                    <?php echo $message; ?>

                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="asset_type" class="form-label">Asset Type</label>
                                <input type="text" class="form-control" id="asset_type" name="asset_type" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="model_no" class="form-label">Model Number</label>
                                <input type="text" class="form-control" id="model_no" name="model_no" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="serial_no" class="form-label">Serial Number</label>
                                <input type="text" class="form-control" id="serial_no" name="serial_no" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="delivery_date" class="form-label">Delivery Date</label>
                                <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="installation_type" class="form-label">Installation Type</label>
                                <input type="text" class="form-control" id="installation_type" name="installation_type" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="installation_date" class="form-label">Installation Date</label>
                                <input type="date" class="form-control" id="installation_date" name="installation_date" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="po_order_ref_no" class="form-label">P.O. Order Ref No</label>
                                <input type="text" class="form-control" id="po_order_ref_no" name="po_order_ref_no" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="warranty" class="form-label">Warranty (in months)</label>
                                <input type="number" class="form-control" id="warranty" name="warranty" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location of Physical Installation</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Maintenance">Maintenance</option>
                                        <!-- <option value="Inactive">Inactive</option> -->
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="">
                            <button type="" class="btn btn-secondary">Cancel</button>

                            <button type="submit" class="btn btn-primary">Add Asset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

</style>

<?php include 'footer.php'; ?>