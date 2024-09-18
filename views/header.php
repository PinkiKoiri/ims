<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Default Title'; ?></title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/styles.css">
    <style>
        /* Custom CSS for sidebar layout */
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        /* #wrapper {
            display: flex;
            flex: 1;
        } */

        #sidebar-wrapper {
            /* width: 250px; */
            background-color: #f8f9fa;
            /* Light gray background for sidebar */
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            padding-top: 60px;
            /* Adjust padding for fixed navbar */
        }

        #content-wrapper {
            flex: 1;
            padding: 20px;
            margin-left: 250px;
            /* Adjust margin for sidebar width */
        }

        /* Styling for sidebar links */
        .nav-sidebar .nav-link {
            color: #333;
            /* Dark gray text color */
        }

        .nav-sidebar .nav-link.active {
            background-color: #e9ecef;
            /* Lighter gray background for active link */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">TrackR</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['username'])) : ?>
                        <li class="nav-item">
                            <span class="navbar-text">
                                Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
                                <a href="logout.php">Logout</a>
                            </span>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="wrapper">
        <div id="sidebar-wrapper">
            <ul class="nav nav-pills flex-column nav-sidebar">
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'home.php' ? 'active' : ''; ?>" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'features.php' ? 'active' : ''; ?>" href="features.php">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'pricing.php' ? 'active' : ''; ?>" href="pricing.php">Pricing</a>
                </li>
            </ul>
        </div>

        <!-- <div id="content-wrapper">
            <div class="container-fluid">
            </div>
        </div> -->
    </div>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>