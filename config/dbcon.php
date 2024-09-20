<?php

define("HOSTNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DATABASE", "trackr");

$conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

if (!$conn) {
    die("connection Failed");
} else {
    // echo "Connected";
}
