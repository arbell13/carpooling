<?php

include 'includes/connection.php';

// $sql = "SELECT * FROM user WHERE verify_status = 'verify'";
// $result = $connection->query($sql);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $type = $_POST['type'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $contact_no = $_POST['contact_no'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verify = 'verify';
    if ($type == 'Driver') {
        $licenseNumber = $_POST['licenseNumber'];
        $plateNumber = $_POST['plateNumber'];
        $carType = $_POST['carType'];
    }

    // Validate Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['bg'] =  "danger";
        $_SESSION['message'] = "Invalid email format!";
        header('Location: index.php');
        return;
    }

    // if ($result->num_rows > 0) {
    //     $_SESSION['bg'] =  "danger";
    //     $_SESSION['message'] = "Email already exist!";
    //     header('Location: index.php');
    //     return;
    // }

    // Prepared Statement & Binding (Avoid SQL Injections)
    $sql = "INSERT INTO user (userType, firstname, middlename, lastname, barangay, street, city, province, phonenumber, email, password, verify_status) VALUES ('$type', '$fname', '$mname', '$lname', '$barangay', '$street', '$city', '$province', '$contact_no', '$email', '$password', '$verify')";


    if ($connection->query($sql)) {
        $last_id = $connection->insert_id;
        $sql1 = "INSERT INTO tbldriver (usersID, licenseNumber, wallet, balance) VALUES ('" . $last_id . "','" . $licenseNumber . "','0','0')";
        if ($connection->query($sql1)) {
            $last_id2 = $connection->insert_id;
            $sql2 = "INSERT INTO tblcardetails (driverID, plateNumber, type) VALUES ('" . $last_id2 . "','" . $plateNumber . "','" . $carType . "')";
            if ($connection->query($sql2)) {
                $_SESSION['bg'] =  "success";
                $_SESSION['message'] = "Account registration success!";
                echo '<script>alert("Account registration success!")</script>';
                header('Location: index.php');
            } else {
                $_SESSION['bg'] =  "danger";
                $_SESSION['message'] = "Account registration failure!";
                header('Location: index.php');
            }
        } else {
            $_SESSION['bg'] =  "danger";
            $_SESSION['message'] = "Account registration failure!";
            header('Location: index.php');
        }
    } else {
        $_SESSION['bg'] =  "danger";
        $_SESSION['message'] = "Account registration failure!";
        header('Location: index.php');
    }




    // Mailling Part
    // $name = $fname . " " . $lname;
    // $subject = "User Registration";
    // $link = $home . "/verify.php?user=" . $email . "";
    // $message = ' 
    // <!DOCTYPE html>
    // <html lang="en">
    // <head>
    //     <meta charset="UTF-8">
    //     <style>
    //         #verify {
    //             background-color: #0f79b7;
    //             padding: 10px;
    //             text-decoration: none;
    //             color: white;
    //         }
    //         #verify:hover {
    //             background-color: #0988d2;
    //         }
    //     </style>
    // </head>
    // <body>
    //     <b> Carpool App </b>
    //     <hr>
    //     <p> Hi, <strong>' . $name . '!</strong></p>
    //     <p> You only have one more step to use the app. Please click the link below to finalize your Carpool App
    //         Registration.
    //         <br><br>
    //         <a id="verify" href="' . $link . '"> Verify Email Address </a>
    //         <br><br>
    //         If you have are having trouble verifying, email us at carpool@lashes.com. Did not sign up for an account? You may kindly ignore this email.
    //         <br><br>
    //         Riding you safe, <br>
    //         <b>Carpool Buddy 😊 </b>
    //     </p>
    // </body>
    // </html>
    // ';

    // $mail = new PHPMailer(true);
    // $mail->isSMTP();
    // $mail->Host = 'smtp.hostinger.com';
    // $mail->SMTPAuth = 'true';
    // $mail->Username = 'carpool@lashes.com';
    // $mail->Password = 'Arabella@15';
    // $mail->SMTPSecure = 'tls';
    // $mail->Port = '587';

    // $mail->setFrom('carpool@lashes.com', 'Carpool App');
    // $mail->addAddress($email);
    // $mail->isHTML(true);
    // $mail->Subject = $subject;
    // $mail->Body = $message;
    // $mail->send();

    // $_SESSION['bg'] =  "warning";
    // $_SESSION['message'] = "Please check your email to verify your registration.";
    header('Location: index.php');
}
