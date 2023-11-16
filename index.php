<?php include 'conn.php';

if (isset($_POST['login'])) {
    $email = $_POST["logMail"];
    $password = $_POST["logPass"];
    $remember = isset($_POST["remember"]);
    $noMatch = true;
    $logType = $_POST["logType"];
    if ($logType == "customer_login") {
        $login = $customerLogin;
    } else {
        $login = $caragencyLogin;
    }
    while ($check = mysqli_fetch_assoc($login)) {
        if ($check["Email"] == $email && password_verify($password, $check["Password"])) {
            if ($remember) {
                setcookie("UID", $check["UID"], time() + (86400 * 30), "/");
                setcookie("Category", $logType, time() + (86400 * 30), "/");
            } else {
                setcookie("UID", $check["UID"]);
                setcookie("Category", $logType);
            }
            $noMatch = false;
        }
    }
    if ($noMatch) {
        echo '<script type="text/javascript">alert("Incorrect email or password");</script>';
    }
    echo '<script>window.location.href ="index.php";</script>';
} elseif (isset($_POST['register'])) {
    $uid = uniqid();
    $user = $_POST["regUser"];
    $mail = strtolower($_POST["regMail"]);
    $pass = password_hash($_POST["regPass"], PASSWORD_DEFAULT);
    $noMatch = true;
    $regType = $_POST["regType"];
    if ($regType == "customer_login") {
        $register = $customerLogin;
    } else {
        $register = $caragencyLogin;
    }
    while ($check = mysqli_fetch_assoc($register)) {
        if ($check["Email"] == $mail) {
            $noMatch = false;
        }
    }
    if ($noMatch) {
        $sqlt = "INSERT INTO `$dbName`.`$regType` (`UID`, `Username`, `Email`, `Password`) VALUES ('$uid' ,'$user', '$mail', '$pass')";
        $results = mysqli_query($conn, $sqlt);
        setcookie("UID", $uid, time() + (86400 * 30), "/");
        setcookie("Category", $regType, time() + (86400 * 30), "/");
        echo '<script type="text/javascript">alert("Customer registered successfully!");</script>';
    } elseif (!$noMatch) {
        echo '<script type="text/javascript">alert("Email already exists");</script>';
    }
    echo '<script>window.location.href ="index.php";</script>';
} elseif (isset($_POST['reset'])) {
    $userMail = $_POST["resetMail"];
    $otpPass = (int)$_POST["otp"];
    $newPass = password_hash($_POST["newPass"], PASSWORD_DEFAULT);
    $Matched = false;
    $resetType = $_POST["resetType"];
    if ($resetType == "customer_login") {
        $reset = $customerLogin;
    } else {
        $reset = $caragencyLogin;
    }
    while ($check = mysqli_fetch_assoc($reset)) {
        if ($check["Email"] == $userMail) {
            $Matched = true;
        }
    }
    session_start();
    $otx = $_SESSION['otp'];
    if ($Matched && $otpPass == $otx) {
        $sqlt = "UPDATE `$dbName`.`$resetType` SET `Password` = '$newPass' WHERE (`Email` = '$userMail')";
        $results = mysqli_query($conn, $sqlt);
        echo '<script type="text/javascript">alert("Password changed successfully!");</script>';
    } elseif (!$Matched) {
        echo '<script type="text/javascript">alert("Email does not exists");</script>';
    } elseif ($otpPass != $otx) {
        echo '<script type="text/javascript">alert("Incorrect otp");</script>';
    }
    echo '<script>window.location.href ="index.php";</script>';
} elseif (isset($_POST['rent'])) {
    $carId = $_POST['rent-carid'];
    $agencyId = $_POST['rent-agencyid'];
    $uid = $_POST['rent-uid'];
    $days = $_POST['rent-days'];
    $date = $_POST['rent-date'];
    $noMatch = true;
    while ($check = mysqli_fetch_assoc($rented)) {
        if ($check["CarID"] == $carId) {
            if (!checkRent($check["Date"], $check["Days"], $date, $days))
                $noMatch = false;
        }
    }
    if ($noMatch) {
        $sqlt = "INSERT INTO `$dbName`.`rented` (`CarID`, `AgencyID`, `UID`, `Days`, `Date`) VALUES ('$carId' ,'$agencyId', '$uid', '$days', '$date')";
        $results = mysqli_query($conn, $sqlt);
        echo '<script type="text/javascript">alert("Car rented successfully!");</script>';
    } elseif (!$noMatch) {
        echo '<script type="text/javascript">alert("Car already rented");</script>';
    }
    echo '<script>window.location.href ="index.php";</script>';
}
function checkRent($startDate, $interval, $checkDate, $checkInterval)
{
    $timeStart = strtotime($startDate);
    $timeEnd = strtotime('+' . $interval . ' days', $timeStart);
    $checkTimeStart = strtotime($checkDate);
    $checkTimeEnd = strtotime('+' . $checkInterval . ' days', $checkTimeStart);
    if ($checkTimeEnd < $timeStart) {
        return true;
    } elseif ($checkTimeStart > $timeEnd) {
        return true;
    }
    return false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Rent</title>
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
            <?php
            if (!isset($_COOKIE['UID'])) {
                echo '<button class="loginbtn-popup" onclick="loginPopup()">Login</button>';
            } else {
                if ($_COOKIE['Category'] == 'caragency_login') {
                    echo '<a class="current" href="index.php">Home</a>
                    <a href="yourcars.php">Your Cars</a>
                    <a href="rented.php">Rented Cars</a>';
                }
                echo '<span class="account"  onclick="accountPopup()"><ion-icon class="account-icon" name="person-circle-outline"></ion-icon></span>';
            }
            ?>
        </nav>
    </header>
    <?php
    if (!isset($_COOKIE['UID'])) {
        echo '<div class="outerest">
        <div class="wrapper">
            <span class="icon-close" onclick="iconClose()"><ion-icon name="close"></ion-icon></span>
            <div class="form-box login">
                <h2>Login</h2>
                <form method="post">
                    <div class="category-box">
                        <label>
                            <input type="radio" name="logType" value="customer_login" checked>
                            <p>Customer</p>
                        </label>
                        <label>
                            <input type="radio" name="logType" value="caragency_login">
                            <p>Car Agency</p>
                        </label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="mail"></ion-icon></span>
                        <input type="email" required name="logMail">
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                        <input type="password" required name="logPass">
                        <label>Password</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox" name="remember">Remember me</label>
                        <a class="forgot-link" onclick="forgotLink()">Forgot Password</a>
                    </div>
                    <button type="submit" class="btn" name="login">Login</button>
                    <div class="login-register">
                        <p>Don' . "'" . 't have an account ? <a class="register-link" onclick="registerLink()">Register</a></p>
                    </div>
                </form>
            </div>
            <div class="form-box register">
                <h2>Registration</h2>
                <form method="post">
                    <div class="category-box">
                        <label>
                            <input type="radio" name="regType" value="customer_login" checked>
                            <p>Customer</p>
                        </label>
                        <label>
                            <input type="radio" name="regType" value="caragency_login">
                            <p>Car Agency</p>
                        </label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="person"></ion-icon></span>
                        <input type="text" required name="regUser">
                        <label>Name</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="mail"></ion-icon></span>
                        <input type="email" required name="regMail">
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                        <input type="password" required name="regPass">
                        <label>Password</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox" name="agree" required>I agree to the terms & conditions</label>
                    </div>
                    <button type="submit" class="btn" name="register">Register</button>
                    <div class="login-register">
                        <p>Already have an account ? <a class="login-link" onclick="loginLink()">Login</a></p>
                    </div>
                </form>
            </div>
            <div class="form-box forgot-pass">
                <h2>Reset Password</h2>
                <form method="post">
                    <div class="category-box">
                        <label>
                            <input type="radio" name="resetType" value="customer_login" checked>
                            <p>Customer</p>
                        </label>
                        <label>
                            <input type="radio" name="resetType" value="caragency_login">
                            <p>Car Agency</p>
                        </label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="person"></ion-icon></span>
                        <input type="text" id="pass-mail" required name="resetMail">
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon otp-push" onclick="otp()"><ion-icon name="refresh-circle"></ion-icon></span>
                        <span class="icon"><ion-icon name="shield"></ion-icon></span>
                        <input type="password" required name="otp" maxlength="6">
                        <label>One-Time Password</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                        <input type="password" required name="newPass">
                        <label>New Password</label>
                    </div>
                    <button type="submit" class="btn" name="reset">Change</button>
                    <div class="login-register">
                        <p>Remember your password ? <a class="login-back" onclick="backLink()">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>';
    } else {
        $aUser = "";
        $aMail = "";
        if ($_COOKIE['Category'] == 'customer_login') {
            $account = $customerLogin;
        } else {
            $account = $caragencyLogin;
        }
        while ($finduser = mysqli_fetch_assoc($account)) {
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
    }
    ?>
    <div class="container">
        <?php
        while ($row = mysqli_fetch_assoc($cars)) {
            echo '<div class="av-car-div">
            <p>' . $row['Model'] . '</p><p>' . $row['Number'] . '</p>
            <p>' . $row['Seating'] . ' Seats</p><p>Rs ' . $row['Rent'] . '/day</p>
            <button class="rent-btn" onclick=' . "'" . 'rentPopup(' . json_encode($row) . ')' . "'" . '>Rent</button>
            </div>';
        }
        ?>
    </div>
    <div class="outerest">
        <div class="wrapper rent">
            <span class="icon-close" onclick="iconCloseRent()"><ion-icon name="close"></ion-icon></span>
            <div class="form-box">
                <h2>Rent Car</h2>
                <form method="post">
                    <div class="input-box hidden">
                        <input id="carID" type="text" required name="rent-carid">
                    </div>
                    <div class="input-box hidden">
                        <input id="agencyId" type="text" required name="rent-agencyid">
                    </div>
                    <div class="input-box hidden">
                        <input id="UID" type="text" required name="rent-uid">
                    </div>
                    <div class="input-box">
                        <input type="number" required name="rent-days">
                        <label>No. of Days</label>
                    </div>
                    <div class="input-box">
                        <p>Start Date</p><input id="date" type="date" required name="rent-date">
                    </div>
                    <button type="submit" class="btn" name="rent">Rent Car</button>
                </form>
            </div>
        </div>
    </div>
    <script src="main.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>