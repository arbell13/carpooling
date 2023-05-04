<?php

include "includes/connection.php";

$sql = "SELECT * FROM user WHERE usersID = " . $_SESSION['usersID'];
$query = $connection->query($sql);
$row = $query->fetch_assoc();

if (isset($_POST['submit'])){
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $email = $_POST['email'];
    $licenseNumber = $_POST['licenseNumber'];
    $plateNumber = $_POST['plateNumber'];
    $carType = $_POST['carType'];
    $newpassword = isset($_POST['newPassword']) ? $_POST['newPassword'] : '';

    if ($row['password'] != $password){
        $_SESSION['savingProfileMessageStatus'] = 'error';
        $_SESSION['savingProfileMessage'] = "Wrong Password!";
        header("location: driverprof.php");
    }else{
        if ($newpassword == ''){
            $sql = "UPDATE `user` SET `firstname`='".$firstName."',`middlename`='".$middleName."',`lastname`='".$lastName."',`barangay`='".$barangay."',`street`='".$street."',`city`='".$city."',`province`='".$province."',`phonenumber`='".$phoneNumber."',`email`='".$email."' WHERE usersID = '".$_SESSION['usersID']."'";
            $sql1 = "UPDATE `tbldriver` SET `licenseNumber`='".$licenseNumber."' WHERE usersID = '".$_SESSION['usersID']."'";
            $sql2 = "UPDATE `tbldriver` SET `licenseNumber`='".$licenseNumber."' WHERE usersID = '".$_SESSION['usersID']."'";
        }else{
            $sql = "UPDATE `user` SET `firstname`='".$firstName."',`middlename`='".$middleName."',`lastname`='".$lastName."',`barangay`='".$barangay."',`street`='".$street."',`city`='".$city."',`province`='".$province."',`phonenumber`='".$phoneNumber."',`email`='".$email."', `password`='".$newpassword."' WHERE usersID = '".$_SESSION['usersID']."'";
        }
        
        // $sql1 = "UPDATE `tbldriver` SET `licenseNumber`='".$licenseNumber."' WHERE usersID = '".$_SESSION['usersID']."'";
        // if(!$connection->query($sql1)){
        //     $_SESSION['savingProfileMessageStatus'] = 'error';
        //     $_SESSION['savingProfileMessage'] = "Can't Update!";
        // }
        // $sql2 = "UPDATE `tblcardetails` SET `plateNumber`='".$plateNumber."', `type`='".$carType."' WHERE usersID = '".$_SESSION['usersID']."'";
        // if(!$connection->query($sql2)){
        //     $_SESSION['savingProfileMessageStatus'] = 'error';
        //     $_SESSION['savingProfileMessage'] = "Can't Update!";
        // }
        
        if($connection->query($sql)){
            $_SESSION['savingProfileMessageStatus'] = 'success';
            $_SESSION['savingProfileMessage'] = "New Profile Saved!";
        }else{
            $_SESSION['savingProfileMessageStatus'] = 'error';
            $_SESSION['savingProfileMessage'] = "Can't Update!";
        }
    }


    
    header("location: driverprof.php");
}