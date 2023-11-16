<?php

include 'conn.php';
$otp = "1@&*/";
if (isset($_COOKIE['passMail'])) {
    $userMail = $_COOKIE['passMail'];
    $Match = false;
    if ($_COOKIE['passCategory'] == 'customer_login') {
        $checkuser = $customerLogin;
    } else {
        $checkuser = $caragencyLogin;
    }
    while ($check = mysqli_fetch_assoc($checkuser)) {
        if ($check["Email"] == $userMail) {
            $Match = true;
            $userPass = $check["Username"];
        }
    }
    if ($Match) {
        $otp = rand(100000, 999999);
        session_start();
        $_SESSION['otp'] = $otp;
        $subject = "One-Time Password for your Car Rent account";
        $body = "Hi " . $userPass . "! Your One-Time Password for reseting your password is " . $otp;
        $header = "From: Car Rent <webgamestore000@outlook.com>";
        if (@mail($userMail, $subject, $body, $header)) {
            echo 0;
        } else {
            echo 1;
        }
    } else {
        echo 2;
    }
}
