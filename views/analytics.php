<?php include 'header.php'; ?>

<?php
require '../config/dbcon.php';

// Fetch data for dashboard
$total_assets_query = "SELECT COUNT(*) as count FROM assets_condition";
$total_assets_result = mysqli_query($conn, $total_assets_query);
$total_assets = mysqli_fetch_assoc($total_assets_result)['count'];

$unique_asset_types_query = "SELECT COUNT(DISTINCT asset_type) as count FROM assets_condition";
$unique_asset_types_result = mysqli_query($conn, $unique_asset_types_query);
$unique_asset_types = mysqli_fetch_assoc($unique_asset_types_result)['count'];

$unique_locations_query = "SELECT COUNT(DISTINCT location) as count FROM assets_condition";
$unique_locations_result = mysqli_query($conn, $unique_locations_query);
$unique_locations = mysqli_fetch_assoc($unique_locations_result)['count'];

$unique_models_query = "SELECT COUNT(DISTINCT model_no) as count FROM assets_condition";
$unique_models_result = mysqli_query($conn, $unique_models_query);
$unique_models = mysqli_fetch_assoc($unique_models_result)['count'];

// Fetch status summary
$status_summary_query = "SELECT status, COUNT(*) as count FROM assets_condition GROUP BY status";
$status_summary_result = mysqli_query($conn, $status_summary_query);
$status_summary = [];
while ($row = mysqli_fetch_assoc($status_summary_result)) {
    $status_summary[$row['status']] = $row['count'];
}

// Fetch all assets data
$all_assets_query = "SELECT * FROM assets_condition";
$all_assets_result = mysqli_query($conn, $all_assets_query);
$all_assets = [];
while ($row = mysqli_fetch_assoc($all_assets_result)) {
    $all_assets[] = $row;
}

// Check if the user is an admin
// session_start();
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrackR </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .card-icon {
            font-size: 2.5rem;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }

        .card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #007bff;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 500;
            color: #495057;
            margin-bottom: 1rem;
        }

        .status-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .edit-link {
            color: #007bff;
            text-decoration: none;
        }

        .edit-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container mt-4">
        <h1 class="mb-4">Analytics</h1>

        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Status Summary</h2>
            </div>
            <div class="col-md-4 mb-3">
                <div class="dashboard-card p-3" data-status="active">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-title">Active</div>
                            <div class="card-value"><?php echo isset($status_summary['Active']) ? $status_summary['Active'] : 0; ?></div>
                        </div>
                        <i class="fas fa-check-circle card-icon" style="color: green;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="dashboard-card p-3" data-status="maintenance">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-title">Maintenance</div>
                            <div class="card-value"><?php echo isset($status_summary['Maintenance']) ? $status_summary['Maintenance'] : 0; ?></div>
                        </div>
                        <i class="fas fa-tools card-icon" style="color: orange;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="dashboard-card p-3" data-status="non repairable">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-title">Non Repairable</div>
                            <div class="card-value"><?php echo isset($status_summary['Non repairable']) ? $status_summary['Non repairable'] : 0; ?></div>
                        </div>
                        <i class="fas fa-times-circle card-icon" style="color: red;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add this section to display all assets in a table format -->
        <div class="mt-4">
            <h2 class="section-title">All Assets</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sl no</th>
                            <th>Asset Type</th>
                            <th>Model no</th>
                            <th>Serial no</th>
                            <th>Location</th>
                            <th>Status</th>
                            <?php if ($is_admin): ?>
                                <th>Edit</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_assets as $asset): ?>
                            <tr data-status="<?php echo strtolower($asset['status']); ?>">
                                <td><?php echo $asset['sl_no']; ?></td>
                                <td><?php echo $asset['asset_type']; ?></td>
                                <td><?php echo $asset['model_no']; ?></td>
                                <td><?php echo $asset['serial_no']; ?></td>
                                <td><?php echo $asset['location']; ?></td>
                                <td>
                                    <?php
                                    $statusColor = '';
                                    switch (strtolower($asset['status'])) {
                                        case 'active':
                                            $statusColor = 'green';
                                            break;
                                        case 'maintenance':
                                            $statusColor = 'yellow';
                                            break;
                                        case 'non repairable':
                                            $statusColor = 'red';
                                            break;
                                    }
                                    ?>
                                    <span class="status-dot" style="background-color: <?php echo $statusColor; ?>;"></span>
                                    <?php echo $asset['status']; ?>
                                </td>
                                <?php if ($is_admin): ?>
                                    <td>
                                        <a href="edit_status.php?id=<?php echo $asset['sl_no']; ?>&asset_type=<?php echo urlencode($asset['asset_type']); ?>&serial_no=<?php echo urlencode($asset['serial_no']); ?>" class="edit-link">Edit</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            console.log('Document ready');

            $('.dashboard-card').click(function() {
                console.log('Dashboard card clicked');

                var status = $(this).data('status').toLowerCase();
                var title = $(this).find('.card-title').text();
                console.log('Status:', status, 'Title:', title);

                $('#statusFilter').text('- ' + title);

                filterTable(status);
            });

            // Add a "Reset" button
            $('<button>')
                .text('Reset')
                .addClass('btn btn-secondary mb-3 me-2')
                .click(function() {
                    console.log('Reset clicked');
                    $('#statusFilter').text('');
                    $('table tbody tr').show();
                })
                .insertBefore('table');

            // Existing "Show All" button (renamed to avoid confusion)
            $('<button>')
                .text('Show All')
                .addClass('btn btn-primary mb-3')
                .click(function() {
                    console.log('Show All clicked');
                    $('#statusFilter').text('');
                    $('table tbody tr').show();
                })
                .insertBefore('table');

            function filterTable(status) {
                var visibleRows = 0;
                $('table tbody tr').each(function() {
                    var rowStatus = $(this).data('status');
                    console.log('Row status:', rowStatus, 'Comparing with:', status);
                    if (rowStatus === status) {
                        $(this).show();
                        visibleRows++;
                    } else {
                        $(this).hide();
                    }
                });
                console.log('Visible rows:', visibleRows);
            }

            // Log all row statuses on page load
            console.log('All row statuses:');
            $('table tbody tr').each(function() {
                console.log($(this).data('status'));
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php include 'footer.php'; ?>
</body>

</html>