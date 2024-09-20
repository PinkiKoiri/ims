<?php
require '../config/dbcon.php';

// Fetch data for dashboard
$total_assets_query = "SELECT COUNT(*) as count FROM assets";
$total_assets_result = mysqli_query($conn, $total_assets_query);
$total_assets = mysqli_fetch_assoc($total_assets_result)['count'];

$unique_asset_types_query = "SELECT COUNT(DISTINCT asset_type) as count FROM assets";
$unique_asset_types_result = mysqli_query($conn, $unique_asset_types_query);
$unique_asset_types = mysqli_fetch_assoc($unique_asset_types_result)['count'];

$unique_locations_query = "SELECT COUNT(DISTINCT location) as count FROM assets";
$unique_locations_result = mysqli_query($conn, $unique_locations_query);
$unique_locations = mysqli_fetch_assoc($unique_locations_result)['count'];

$unique_models_query = "SELECT COUNT(DISTINCT model_no) as count FROM assets";
$unique_models_result = mysqli_query($conn, $unique_models_query);
$unique_models = mysqli_fetch_assoc($unique_models_result)['count'];

// Fetch status summary
$status_summary_query = "SELECT status, COUNT(*) as count FROM assets GROUP BY status";
$status_summary_result = mysqli_query($conn, $status_summary_query);
$status_summary = [];
while ($row = mysqli_fetch_assoc($status_summary_result)) {
    $status_summary[$row['status']] = $row['count'];
}

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
            color: #007bff;
        }

        .card-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #6c757d;
        }

        .card-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #343a40;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 500;
            color: #495057;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container mt-4">
        <h1 class="mb-4">Analytics</h1>

        <div class="row mb-4">
            <div class="col-12">
                <h2 class="section-title">Inventory Overview</h2>
            </div>
            <div class="col-md-3 mb-3">
                <div class="dashboard-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-title">Total Assets</div>
                            <div class="card-value"><?php echo $total_assets; ?></div>
                        </div>
                        <i class="fas fa-boxes card-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="dashboard-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-title">Unique Asset Types</div>
                            <div class="card-value"><?php echo $unique_asset_types; ?></div>
                        </div>
                        <i class="fas fa-tags card-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="dashboard-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-title">Unique Locations</div>
                            <div class="card-value"><?php echo $unique_locations; ?></div>
                        </div>
                        <i class="fas fa-map-marker-alt card-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="dashboard-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-title">Unique Models</div>
                            <div class="card-value"><?php echo $unique_models; ?></div>
                        </div>
                        <i class="fas fa-barcode card-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Status Summary</h2>
            </div>
            <?php foreach ($status_summary as $status => $count): ?>
                <div class="col-md-4 mb-3">
                    <div class="dashboard-card p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="card-title"><?php echo ucfirst($status); ?></div>
                                <div class="card-value"><?php echo $count; ?></div>
                            </div>
                            <i class="fas fa-info-circle card-icon"></i>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php include 'footer.php'; ?>
</body>

</html>