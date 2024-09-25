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
    // $installation_type = mysqli_real_escape_string($conn, $_POST['installation_type']);
    // $installation_date = mysqli_real_escape_string($conn, $_POST['installation_date']);
    $po_order_ref_no = mysqli_real_escape_string($conn, $_POST['po_order_ref_no']);
    // $location = mysqli_real_escape_string($conn, $_POST['location']);
    // $status = mysqli_real_escape_string($conn, $_POST['status']);
    $warranty = mysqli_real_escape_string($conn, $_POST['warranty']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    // Insert data into the database
    $query = "INSERT INTO assets (asset_type, model_no, serial_no, delivery_date, po_order_ref_no, warranty, price, quantity) 
              VALUES ('$asset_type', '$model_no', '$serial_no', '$delivery_date', '$po_order_ref_no', '$warranty', '$price', '$quantity'  )";

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

                    <form method="POST" action="" id="assetForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="asset_type" class="form-label">Asset Type <span class="required">*</span></label>
                                <select class="form-select" id="asset_type" name="asset_type" required>
                                    <option value="">Select Asset Type</option>
                                    <option value="L2 Manageable 48 port Switch">L2 Manageable 48 port Switch</option>
                                    <option value="L2 Manageable 24 port Switch">L2 Manageable 24 port Switch</option>
                                    <option value="L2 Manageable 24 port Gigabit Switch">L2 Manageable 24 port Gigabit Switch</option>
                                    <option value="L2 Non Manageable 24 port Switch">L2 Non Manageable 24 port Switch</option>
                                    <option value="8 port Non Manageable Switch">8 port Non Manageable Switch</option>
                                    <option value="External DVD Drive / LAN TESTER">External DVD Drive / LAN TESTER</option>
                                    <option value="External HDD / CRIMPING TOOLS">External HDD / CRIMPING TOOLS</option>
                                    <option value="Networking UTP Cat 6 Cable">Networking UTP Cat 6 Cable</option>
                                    <option value="Networking I/O Box">Networking I/O Box</option>
                                    <option value="Fiber Patch Cord (FCPC-LC) 2mtr">Fiber Patch Cord (FCPC-LC) 2mtr</option>
                                    <option value="Fiber Patch Cord (SC-SC) 1mtr">Fiber Patch Cord (SC-SC) 1mtr</option>
                                    <option value="RJ-45 Connector">RJ-45 Connector</option>
                                    <option value="UTP Patch Cord (2mtr)">UTP Patch Cord (2mtr)</option>
                                    <option value="Blower">Blower</option>
                                    <option value="Switch Power Supply">Switch Power Supply</option>
                                    <option value="Fiber Patch chord (SC-LC) 2mtr">Fiber Patch chord (SC-LC) 2mtr</option>
                                    <option value="Patch Panel 24 port">Patch Panel 24 port</option>
                                    <option value="Crimping Tool (Make-DLINK)">Crimping Tool (Make-DLINK)</option>
                                    <option value="Networking UTP Patch cord (5mtr)">Networking UTP Patch cord (5mtr)</option>
                                    <option value="KVM Switch 8 port">KVM Switch 8 port</option>
                                    <option value="OFC (24P) Joint closure">OFC (24P) Joint closure</option>
                                    <option value="UTP Cable Manager">UTP Cable Manager</option>
                                    <option value="UTP Patch cord (1mtr)">UTP Patch cord (1mtr)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="model_no" class="form-label">Model Number <span class="required">*</span></label>
                                <input type="text" class="form-control" id="model_no" name="model_no" required minlength="5" maxlength="20">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="serial_no" class="form-label">Serial Number (if any)</label>
                                <input type="text" class="form-control" id="serial_no" name="serial_no" minlength="5" maxlength="20">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="delivery_date" class="form-label">Delivery Date <span class="required">*</span></label>
                                <input type="date" class="form-control" id="delivery_date" name="delivery_date" required max="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-md-6 mb-3">
                                <label for="installation_type" class="form-label">Installation Type</label>
                                <input type="text" class="form-control" id="installation_type" name="installation_type" minlength="5" maxlength="40">
                            </div> -->
                            <!-- <div class="col-md-6 mb-3">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Maintenance">Maintenance</option>
                                        <option value="Inactive">Non repairable</option>
                                    </select>
                                </div>
                            </div> -->
                            <!-- <div class="col-md-6 mb-3">
                                <label for="installation_date" class="form-label">Installation Date</label>
                                <input type="date" class="form-control" id="installation_date" name="installation_date" required max="<?php echo date('Y-m-d'); ?>">
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="po_order_ref_no" class="form-label">P.O. Order Ref No <span class="required">*</span></label>
                                <input type="text" class="form-control" id="po_order_ref_no" name="po_order_ref_no" required title="Alphanumeric characters and slashes only." minlength="5" maxlength="20" pattern="^[a-zA-Z0-9/]+$">
                            </div>

                            <div class=" col-md-6 mb-3">
                                <label for="warranty" class="form-label">Warranty (in months)</label>
                                <input type="number" class="form-control" id="warranty" name="warranty">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">Quantity Delivered <span class="required">*</span></label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price (Single item) <span class="required">*</span></label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                        </div>
                        <!-- <div class="mb-3">
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
                        </div> -->

                        <div class="row justify-content-between">
                            <div class="col-md-3 d-flex justify-content-start "> <button type="" class="btn btn-secondary w-100" onclick="window.history.back();">Cancel</button>
                            </div>
                            <div class="col-md-3 d-flex justify-content-end"> <button type="submit" class="btn btn-primary w-100" id="submitBtn">Add Asset</button>
                            </div>


                        </div>
                </div>



                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('assetForm');
        const submitBtn = document.getElementById('submitBtn');
        const deliveryDate = document.getElementById('delivery_date');
        // const installationDate = document.getElementById('installation_date');
        // const location = document.getElementById('location');
        const poOrderRefNo = document.getElementById('po_order_ref_no');

        // Set max date for date inputs
        const today = new Date().toISOString().split('T')[0];
        deliveryDate.max = today;
        // installationDate.max = today;

        // Function to check if all fields are valid
        function checkFormValidity() {
            const isFormValid = form.checkValidity();
            const areDatesValid = checkDateValidity();
            // const isLocationValid = /^[a-zA-Z0-9\s]+$/.test(location.value);
            const isPoOrderRefNoValid = /^[a-zA-Z0-9/]+$/.test(poOrderRefNo.value);

            // submitBtn.disabled = !(isFormValid && areDatesValid && isLocationValid);
        }

        // Function to check if dates are valid
        function checkDateValidity() {
            const deliveryValue = deliveryDate.value;
            // const installationValue = installationDate.value;

            if (deliveryValue && installationValue) {
                return new Date(deliveryValue) <= new Date(installationValue);
            }
            return true; // If either date is not set, consider it valid
        }

        // Add event listeners to all form inputs
        form.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', checkFormValidity);
        });

        // Special handling for date inputs
        deliveryDate.addEventListener('change', function() {
            installationDate.min = this.value; // Installation date can't be before delivery date
            checkFormValidity();
        });

        installationDate.addEventListener('change', checkFormValidity);

        // Special handling for location field
        // location.addEventListener('input', function(e) {
        //     this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, '');
        // });

        // Special handling for P.O. Order Ref No field
        // poOrderRefNo.addEventListener('input', function(e) {
        //     this.value = this.value.replace(/[^a-zA-Z0-9/]/g, '');
        // });

        // Prevent form submission if any field is invalid
        form.addEventListener('submit', function(event) {
            // if (!checkFormValidity()) {
            //     event.preventDefault();
            //     alert('Please ensure all fields are filled correctly. Location should only contain letters, numbers, and spaces. P.O. Order Ref No should only contain letters, numbers, and slashes.');
            // }
        });
    });
</script>

<?php include 'footer.php'; ?>