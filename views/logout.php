<?php
session_start(); // Start the session

// Unset session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page or home page
header("Location: ../"); // Change 'index.php' to your desired location
exit();
