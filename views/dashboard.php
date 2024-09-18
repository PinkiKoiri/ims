<?php
// session_start();
require '../config/dbcon.php';

// if (!isset($_SESSION['username'])) {
//     header("location: ../index.php");
//     exit();
// }

// Fetch data for dashboard (replace with actual queries)
$total_warehouse = 5;
$no_of_brands = 20;
$no_of_categories = 15;
$no_of_products = 100;

$quantity_in_hand = 1000;
$product_missing = 5;
$product_damage = 3;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrackR Dashboard</title>
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
            font-weight: 600;
            color: #495057;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container mt-4">
        <h1 class="mb-4">Dashboard</h1>

        <div class="row mb-4">
            <div class="col-12">
                <h2 class="section-title">Inventory Overview</h2>
            </div>
            <div class="col-md-3 mb-3">
                <div class="dashboard-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-title">Total Warehouses</div>
                            <div class="card-value"><?php echo $total_warehouse; ?></div>
                        </div>
                        <i class="fas fa-warehouse card-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="dashboard-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-title">No. of Brands</div>
                            <div class="card-value"><?php echo $no_of_brands; ?></div>
                        </div>
                        <i class="fas fa-tag card-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="dashboard-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-title">No. of Categories</div>
                            <div class="card-value"><?php echo $no_of_categories; ?></div>
                        </div>
                        <i class="fas fa-list card-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="dashboard-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-title">No. of Products</div>
                            <div class="card-value"><?php echo $no_of_products; ?></div>
                        </div>
                        <i class="fas fa-box card-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Inventory Summary</h2>
            </div>
            <div class="col-md-4 mb-3">
                <div class="dashboard-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-title">Quantity in Hand</div>
                            <div class="card-value"><?php echo $quantity_in_hand; ?></div>
                        </div>
                        <i class="fas fa-cubes card-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="dashboard-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-title">Missing Products</div>
                            <div class="card-value"><?php echo $product_missing; ?></div>
                        </div>
                        <i class="fas fa-search card-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="dashboard-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-title">Damaged Products</div>
                            <div class="card-value"><?php echo $product_damage; ?></div>
                        </div>
                        <i class="fas fa-exclamation-triangle card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>