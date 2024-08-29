<?php

define("HOSTNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DATABASE", "trackr");

$con = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

if (!$con) {
    die("connection Failed");
} else {
    // echo "Connected";
}
