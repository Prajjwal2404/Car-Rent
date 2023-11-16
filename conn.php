<?php

$env = parse_ini_file('.env', false);
$conn = mysqli_connect($env["HOSTNAME"], $env["USERNAME"], $env["PASSWORD"], $env["DATABASE"], $env["PORT"]);
if (!$conn) {
    die(mysqli_connect_error());
}

$dbName = $env["DATABASE"];

$customerLoginQ = "SELECT * FROM `customer_login`";
$customerLogin = mysqli_query($conn, $customerLoginQ);

$caragencyLoginQ = "SELECT * FROM `caragency_login`";
$caragencyLogin = mysqli_query($conn, $caragencyLoginQ);

$carsQ = "SELECT * FROM `cars`";
$cars = mysqli_query($conn, $carsQ);

$rentedQ = "SELECT * FROM `rented`";
$rented = mysqli_query($conn, $rentedQ);
