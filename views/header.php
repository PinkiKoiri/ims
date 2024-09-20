<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'TrackR'; ?></title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles.css">
    <style>
        .navbar {
            background-color: #3498db;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff !important;
        }

        .nav-link {
            color: #ecf0f1 !important;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #2c3e50 !important;
        }

        .navbar-text {
            color: #ecf0f1;
        }

        .navbar-text a {
            color: #2c3e50;
            text-decoration: none;
            font-weight: bold;
            margin-left: 10px;
        }

        .navbar-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"> <i class="fas fa-box-open me-1"></i> TrackR</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'analytics.php' ? 'active' : ''; ?>" href="analytics.php"><i class="fas fa-chart-bar me-1"></i>Analytics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'add_assets.php' ? 'active' : ''; ?>" href="add_assets.php"><i class="fas fa-add me-1"></i>Add Assets</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'reports.php' ? 'active' : ''; ?>" href="reports.php"><i class="fas fa-file-alt me-1"></i>Reports</a>
                    </li> -->
                </ul>
                <?php if (isset($_SESSION['username'])) : ?>
                    <span class="navbar-text">
                        Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
                        <a href="logout.php"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
                    </span>
                <?php else : ?>
                    <span class="navbar-text">
                        <a href="login.php"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </nav>