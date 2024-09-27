<?php

require '../config/dbcon.php';
// session_start(); // Start the session to access session variables

// Initialize search term
$search_term = isset($_GET['search_term']) ? mysqli_real_escape_string($conn, $_GET['search_term']) : '';

// Pagination setup
$rows_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $rows_per_page;

// Modify the query to include search
$query = "SELECT * FROM assets WHERE 1=1";
if (!empty($search_term)) {
    $query .= " AND (asset_type LIKE '%$search_term%')";
}
$query .= " ORDER BY sl_no LIMIT $rows_per_page OFFSET $offset";

$result = mysqli_query($conn, $query);

// Modify total rows query to include search and sum quantity
$total_rows_query = "SELECT COUNT(*) as count, SUM(quantity) as total_quantity FROM assets WHERE 1=1";
if (!empty($search_term)) {
    $total_rows_query .= " AND (asset_type LIKE '%$search_term%')";
}
$total_rows_result = mysqli_query($conn, $total_rows_query);
$total_rows_data = mysqli_fetch_assoc($total_rows_result);
$total_rows = $total_rows_data['count'];
$total_quantity = $total_rows_data['total_quantity'];

// Calculate "In use" and "Available to Assign" for the specific asset type
$in_use_query = "SELECT COUNT(*) as in_use FROM assets_condition WHERE status != 'Non repairable'";
if (!empty($search_term)) {
    $in_use_query .= " AND (asset_type LIKE '%$search_term%')";
}
$in_use_result = mysqli_query($conn, $in_use_query);
$in_use_data = mysqli_fetch_assoc($in_use_result);
$in_use = $in_use_data['in_use'];

$available_to_assign = $total_quantity - $in_use;

// Calculate total pages
$total_pages = ceil($total_rows / $rows_per_page);

?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    $asset_id = (int)$_POST['asset_id'];

    $update_query = "UPDATE assets SET status='$new_status' WHERE sl_no=$asset_id";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Status updated successfully');</script>";
    } else {
        echo "<script>alert('Failed to update status');</script>";
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Dashboard</h1>

    <!-- Search form -->
    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" name="search_term" placeholder="Search by Asset Type" value="<?php echo htmlspecialchars($search_term); ?>">
            </div>
            <div class="col-md-3 mb-3">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="?" class="btn btn-secondary">Clear</a>
            </div>
        </div>
    </form>

    <!-- Display metrics for the searched asset type -->
    <?php if (!empty($search_term)): ?>
        <div class="alert alert-info">
            <div class="metric-row">
                <div class="metric">
                    <strong>Total quantity delivered</strong>
                    <?php echo $total_quantity; ?>
                </div>
                <div class="metric">
                    <strong>In use</strong>
                    <?php echo $in_use; ?>
                </div>
                <div class="metric">
                    <strong>Available to Assign</strong>
                    <?php echo $available_to_assign; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ... existing dashboard cards ... -->

    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="section-title">Asset Inventory</h2>
            <a href="insert_assets_condition.php" class="btn btn-primary">Add Location & Status</a>
        </div>

        <div class="col-12">


            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sl no</th>
                            <th>Asset Type</th>
                            <!-- <th>Model no</th> -->
                            <!-- <th>Serial no</th> -->
                            <th>Delivery Date</th>
                            <!-- <th>Installation Type</th> -->
                            <!-- <th>Installation Date</th> -->
                            <th>P.O order ref no</th>
                            <!-- <th>Location of physical installation</th> -->
                            <th>Warranty <br>(Months)</th>
                            <th>Price(Single item)</th>
                            <th>Quantity Delivered</th>
                            <!-- <th>Status</th> -->
                            <!-- <?php if ($_SESSION['role'] == 'admin'): ?>
                                <th>Actions</th>
                            <?php endif; ?> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['sl_no'] . "</td>";
                            echo "<td>" . $row['asset_type'] . "</td>";
                            // echo "<td>" . $row['model_no'] . "</td>";
                            // echo "<td>" . $row['serial_no'] . "</td>";
                            echo "<td>" . $row['delivery_date'] . "</td>";
                            // echo "<td>" . $row['installation_type'] . "</td>";
                            // echo "<td>" . $row['installation_date'] . "</td>";
                            echo "<td>" . $row['po_order_ref_no'] . "</td>";
                            // echo "<td>" . $row['location'] . "</td>";
                            echo "<td>" . $row['warranty'] . "</td>";
                            echo "<td>" . $row['price'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            // echo "<td>";
                            // echo '<div class="status-container">';
                            // if (strtolower($row['status']) == 'active') {
                            //     echo '<span class="status-dot active"></span>';
                            // } elseif (strtolower($row['status']) == 'maintenance') {
                            //     echo '<span class="status-dot maintenance"></span>';
                            // } elseif (strtolower($row['status']) == 'non repairable') {
                            //     echo '<span class="status-dot non-repairable"></span>';
                            // }
                            // echo '<span class="status-text">' . $row['status'] . '</span>';
                            // echo '</div>';
                            // echo "</td>";

                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Updated Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <!-- Previous button -->
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&search_term=<?php echo urlencode($search_term); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <?php
                    $show_dots = false;
                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i <= 3 || $i > $total_pages - 3 || abs($page - $i) <= 1) {
                            echo '<li class="page-item ' . (($page == $i) ? 'active' : '') . '">';
                            echo '<a class="page-link" href="?page=' . $i . '&search_term=' . urlencode($search_term) . '">' . $i . '</a>';
                            echo '</li>';
                            $show_dots = true;
                        } elseif ($show_dots) {
                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            $show_dots = false;
                        }
                    }
                    ?>

                    <!-- Next button -->
                    <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&search_term=<?php echo urlencode($search_term); ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<style>
    .status-container {
        display: flex;
        align-items: center;
    }

    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 5px;
        /* Adjusted for better spacing */
    }

    .status-dot.active {
        background-color: #28a745;
    }

    .status-dot.maintenance {
        background-color: #ffc107;
    }

    .status-dot.non-repairable {
        background-color: #dc2626;
    }
</style>

<style>
    .metric-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .metric {
        flex: 1;
        text-align: center;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 5px;
        margin: 0 5px;
    }

    .metric strong {
        display: block;
        font-size: 1.2em;
        margin-bottom: 5px;
    }
</style>

<?php include 'footer.php'; ?>