<?php include 'conn.php';

if (!isset($_COOKIE['UID']) || !isset($_COOKIE['Category']) || $_COOKIE['Category'] != 'caragency_login') {
    header('Location: index.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rent</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="favicon/favicon-dark.svg" type="image/x-icon" media="(prefers-color-scheme: light)">
    <link rel="icon" href="favicon/favicon-light.svg" type="image/x-icon" media="(prefers-color-scheme: dark)">
</head>

<body>
    <header>
        <div class="logo">
            <span class="icon-car"><ion-icon name="car"></ion-icon></span>
            <h2 class="logo-name">Car Rent</h2>
        </div>
        <nav class="navigation">
            <a href="index.php">Home</a>
            <a href="yourcars.php">Your Cars</a>
            <a class="current" href="rented.php">Rented Cars</a>
            <span class="account" onclick="accountPopup()"><ion-icon class="account-icon" name="person-circle-outline"></ion-icon></span>
        </nav>
    </header>
    <?php
    $aUser = "";
    $aMail = "";
    while ($finduser = mysqli_fetch_assoc($caragencyLogin)) {
        if ($finduser["UID"] == $_COOKIE['UID']) {
            $aUser = $finduser["Username"];
            $aMail = $finduser["Email"];
        }
    }
    echo '<div class="outerest-a">
    <div class="wrapper-a">
        <span class="icon-close-a" onclick="iconCloseA()"><ion-icon name="close"></ion-icon></span>
        <div class="form-box-a">
            <h2>Account</h2>
            <div class="show-box">
                <span class="icon-a"><ion-icon name="person"></ion-icon></span>
                <p class="head-a">Name</p>
                <p class="body-a">' . $aUser . '</p>
            </div>
            <div class="show-box">
                <span class="icon-a"><ion-icon name="mail"></ion-icon></ion-icon></span>
                <p class="head-a">Email</p>
                <p class="body-a">' . $aMail . '</p>
            </div>
            <button class="log-out-btn" onclick="logout()">Log-Out</button>
        </div>
    </div>
    </div>';
    ?>
    <div class="container">
        <?php
        while ($rowOut = mysqli_fetch_assoc($rented)) {
            if ($rowOut['AgencyID'] == $_COOKIE['UID']) {
                $carId = $rowOut['CarID'];
                $rowQ = "SELECT * FROM `cars` WHERE (`CarID` = '$carId')";
                $row = mysqli_query($conn, $rowQ);
                $row = $row->fetch_assoc();
                $userId = $rowOut['UID'];
                $userQ = "SELECT `Username` FROM `customer_login` WHERE (`UID` = '$userId')";
                $username = mysqli_query($conn, $userQ);
                $username = $username->fetch_assoc();
                echo '<div class="rent-car-div">
                <p>' . $row['Model'] . '</p><p>' . $row['Number'] . '</p>
                <p>' . $row['Seating'] . ' Seats</p><p>Rs ' . $row['Rent'] . '/day</p>
                <p>' . $rowOut['Days'] . ' Days</p><p>' . $rowOut['Date'] . '</p>
                <p>' . $username['Username'] . '</p></div>';
            }
        }
        ?>
    </div>
    <script src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>