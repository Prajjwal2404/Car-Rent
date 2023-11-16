<?php include 'conn.php';

if (!isset($_COOKIE['UID']) || !isset($_COOKIE['Category']) || $_COOKIE['Category'] != 'caragency_login') {
    header('Location: index.php');
    die();
}

if (isset($_POST['add'])) {
    $carId = uniqid();
    $model = $_POST['model'];
    $number = strtoupper($_POST['number']);
    $seating = (int)$_POST['seating'];
    $rent = $_POST['rent'];
    $agencyId = $_COOKIE['UID'];
    $noMatch = true;
    while ($check = mysqli_fetch_assoc($cars)) {
        if ($check["Number"] == $number) {
            $noMatch = false;
        }
    }
    if ($noMatch) {
        $sqlt = "INSERT INTO `$dbName`.`cars` (`CarID`, `Model`, `Number`, `Seating`, `Rent`, `AgencyID`) VALUES ('$carId' ,'$model', '$number', '$seating', '$rent', '$agencyId')";
        $results = mysqli_query($conn, $sqlt);
        echo '<script type="text/javascript">alert("Car added successfully!");</script>';
    } elseif (!$noMatch) {
        echo '<script type="text/javascript">alert("Car number already exists");</script>';
    }
    echo '<script>window.location.href ="yourcars.php";</script>';
} elseif (isset($_POST['edit'])) {
    $model = $_POST['edit-model'];
    $number = strtoupper($_POST['edit-number']);
    $seating = (int)$_POST['edit-seating'];
    $rent = $_POST['edit-rent'];
    $carId = $_POST['edit-car'];
    $noMatch = true;
    while ($check = mysqli_fetch_assoc($cars)) {
        if ($check["Number"] == $number) {
            $noMatch = false;
        }
    }
    if ($noMatch) {
        $sqlt = "UPDATE `$dbName`.`cars` SET `Model` = '$model', `Number` = '$number', `Seating` = '$seating', `Rent` = '$rent' WHERE (`CarID` = '$carId')";
        $results = mysqli_query($conn, $sqlt);
        echo '<script type="text/javascript">alert("Car updated successfully!");</script>';
    } elseif (!$noMatch) {
        echo '<script type="text/javascript">alert("Car number already exists");</script>';
    }
    echo '<script>window.location.href ="yourcars.php";</script>';
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
            <a class="current" href="yourcars.php">Your Cars</a>
            <a href="rented.php">Rented Cars</a>
            <span class="account" onclick="accountPopup()"><ion-icon class="account-icon" name="person-circle-outline"></ion-icon></span>
        </nav>
    </header>
    <div class="outerest">
        <div class="wrapper add">
            <span class="icon-close" onclick="iconCloseAdd()"><ion-icon name="close"></ion-icon></span>
            <div class="form-box">
                <h2>Add Car</h2>
                <form method="post">
                    <div class="input-box">
                        <input type="text" required name="model">
                        <label>Vehicle Model</label>
                    </div>
                    <div class="input-box">
                        <input type="text" required name="number">
                        <label>Vehicle Number</label>
                    </div>
                    <div class="inline">
                        <div class="input-box sml">
                            <input type="number" required name="seating">
                            <label>Seating</label>
                        </div>
                        <div class="input-box sml">
                            <input type="number" required name="rent" step=".01">
                            <label>Rent/day</label>
                        </div>
                    </div>
                    <button type="submit" class="btn" name="add">Add Car</button>
                </form>
            </div>
        </div>
    </div>
    <div class="outerest">
        <div class="wrapper edit">
            <span class="icon-close" onclick="iconCloseEdit()"><ion-icon name="close"></ion-icon></span>
            <div class="form-box">
                <h2>Edit Car</h2>
                <form method="post">
                    <div class="input-box">
                        <input id="model" type="text" required name="edit-model">
                        <label>Vehicle Model</label>
                    </div>
                    <div class="input-box">
                        <input id="number" type="text" required name="edit-number">
                        <label>Vehicle Number</label>
                    </div>
                    <div class="inline">
                        <div class="input-box sml">
                            <input id="seating" type="number" required name="edit-seating">
                            <label>Seating</label>
                        </div>
                        <div class="input-box sml">
                            <input id="rent" type="number" required name="edit-rent" step=".01">
                            <label>Rent/day</label>
                        </div>
                    </div>
                    <div class="input-box hidden">
                        <input id="carId" type="text" required name="edit-car">
                    </div>
                    <button type="submit" class="btn" name="edit">Edit Car</button>
                </form>
            </div>
        </div>
    </div>
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
        <div class="add-div" onclick="addPopup()"><ion-icon name="add-circle"></ion-icon></div>
        <?php
        while ($row = mysqli_fetch_assoc($cars)) {
            if ($row['AgencyID'] == $_COOKIE['UID']) {
                echo '<div class="car-div" onclick=' . "'" . 'editPopup(' . json_encode($row) . ')' . "'" . '>
                <p>' . $row['Model'] . '</p><p>' . $row['Number'] . '</p>
                <p>' . $row['Seating'] . ' Seats</p><p>Rs ' . $row['Rent'] . '/day</p></div>';
            }
        }
        ?>
    </div>
    <script src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>