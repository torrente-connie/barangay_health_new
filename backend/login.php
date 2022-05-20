<?php 

require("dbconn.php");
session_start();

// function for database connection
$connection = dbConn();

if(isset($_POST['login'])) {

$secret = "test"; // change the secret key soon;

if(isset($_POST['email']) && isset($_POST['password'])) {
  $email = $_POST['email'];
  $pass = md5($_POST['password']);

  // filter user type
  $sqlGetInfo = "SELECT * FROM user WHERE (`user_email` LIKE '$email') AND (`user_password` LIKE '$pass')";
  $resultGetInfo = mysqli_query($connection,$sqlGetInfo);
  $rowGetInfo = mysqli_fetch_assoc($resultGetInfo);
  $getInfoUserType = $rowGetInfo['user_type'];

  // Get All Administrator
  if($getInfoUserType == 'Administrator') {
   $sql = "SELECT * FROM user WHERE (`user_email` LIKE '$email') AND (`user_password` LIKE '$pass') AND (user_type = '$getInfoUserType') ";
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['logged_in'] = $secret;
        $_SESSION['admin_id'] = $row['user_id'];
        $_SESSION['admin_fullname'] = $row['user_firstname'].' '.$row['user_middlename'].'.'.' '. $row['user_lastname'];
        $_SESSION['admin_image'] = $row['user_image'];
        header('location:../views/admin/dashboard.php'); 
    }

  } else if($getInfoUserType == 'Patient') {

    // Get All Patients
    $sql = "SELECT * FROM user WHERE (`user_email` LIKE '$email') AND (`user_password` LIKE '$pass') AND (user_type = '$getInfoUserType') ";
    $result = mysqli_query($connection, $sql); 
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['logged_in'] = $secret;
        $_SESSION['patient_id'] = $row['user_id'];
        $_SESSION['patient_fullname'] = $row['user_firstname'].' '.$row['user_middlename'].'.'.' '. $row['user_lastname'];
        $_SESSION['patient_image'] = $row['user_image'];
        header('location:../views/patient/dashboard.php');
    }
  } else if($getInfoUserType == 'Doctor') {

    // Get All Doctor
    $sql = "SELECT * FROM user WHERE (`user_email` LIKE '$email') AND (`user_password` LIKE '$pass') AND (user_type = '$getInfoUserType') "; 
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['logged_in'] = $secret;
        $_SESSION['doctor_id'] = $row['user_id'];
        $_SESSION['doctor_fullname'] = $row['user_firstname'].' '.$row['user_middlename'].'.'.' '. $row['user_lastname'];
        $_SESSION['doctor_image'] = $row['user_image'];
        header('location:../views/doctor/dashboard.php');

    }
  
  } else if ($getInfoUserType == 'Barangay Health Worker') {
   // Get All Barangay Health Worker
   $sql = "SELECT * FROM user WHERE (`user_email` LIKE '$email') AND (`user_password` LIKE '$pass') AND user_type = '$getInfoUserType'";
    $result = mysqli_query($connection, $sql); 
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['logged_in'] = $secret;
        $_SESSION['bhw_id'] = $row['user_id'];
        $_SESSION['bhw_fullname'] = $row['user_firstname'].' '.$row['user_middlename'].'.'.' '. $row['user_lastname'];
        $_SESSION['bhw_image'] = $row['user_image'];
        header('location:../views/bhw/dashboard.php');
    }
  } else if($getInfoUserType == '') {
      $alert = "Invalid Account";
      header('location:../login.php?invalid='.$alert);
    }
  }
}

if(isset($_POST['loginHome'])) {

$secret = "test"; // change the secret key soon;

if(isset($_POST['email']) && isset($_POST['password'])) {
  $email = $_POST['email'];
  $pass = md5($_POST['password']);

  // filter user type
  $sqlGetInfo = "SELECT * FROM user WHERE (`user_email` LIKE '$email') AND (`user_password` LIKE '$pass')";
  $resultGetInfo = mysqli_query($connection,$sqlGetInfo);
  $rowGetInfo = mysqli_fetch_assoc($resultGetInfo);
  $getInfoUserType = $rowGetInfo['user_type'];

  // Get All Administrator
  if($getInfoUserType == 'Administrator') {
   $sql = "SELECT * FROM user WHERE (`user_email` LIKE '$email') AND (`user_password` LIKE '$pass') AND (user_type = '$getInfoUserType') ";
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['logged_in'] = $secret;
        $_SESSION['admin_id'] = $row['user_id'];
        $_SESSION['admin_fullname'] = $row['user_firstname'].' '.$row['user_middlename'].'.'.' '. $row['user_lastname'];
        $_SESSION['admin_image'] = $row['user_image'];
        header('location:../home_schedules.php'); 
    }

  } else if($getInfoUserType == 'Patient') {

    // Get All Patients
    $sql = "SELECT * FROM user WHERE (`user_email` LIKE '$email') AND (`user_password` LIKE '$pass') AND (user_type = '$getInfoUserType') ";
    $result = mysqli_query($connection, $sql); 
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['logged_in'] = $secret;
        $_SESSION['patient_id'] = $row['user_id'];
        $_SESSION['patient_fullname'] = $row['user_firstname'].' '.$row['user_middlename'].'.'.' '. $row['user_lastname'];
        $_SESSION['patient_image'] = $row['user_image'];
        header('location:../home_schedules.php');
    }
  } else if($getInfoUserType == 'Doctor') {

    // Get All Doctor
    $sql = "SELECT * FROM user WHERE (`user_email` LIKE '$email') AND (`user_password` LIKE '$pass') AND (user_type = '$getInfoUserType') "; 
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['logged_in'] = $secret;
        $_SESSION['doctor_id'] = $row['user_id'];
        $_SESSION['doctor_fullname'] = $row['user_firstname'].' '.$row['user_middlename'].'.'.' '. $row['user_lastname'];
        $_SESSION['doctor_image'] = $row['user_image'];
        header('location:../home_schedules.php');

    }
  
  } else if ($getInfoUserType == 'Barangay Health Worker') {
   // Get All Barangay Health Worker
   $sql = "SELECT * FROM user WHERE (`user_email` LIKE '$email') AND (`user_password` LIKE '$pass') AND user_type = '$getInfoUserType'";
    $result = mysqli_query($connection, $sql); 
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['logged_in'] = $secret;
        $_SESSION['bhw_id'] = $row['user_id'];
        $_SESSION['bhw_fullname'] = $row['user_firstname'].' '.$row['user_middlename'].'.'.' '. $row['user_lastname'];
        $_SESSION['bhw_image'] = $row['user_image'];
        header('location:../home_schedules.php');
    }
  } else if($getInfoUserType == '') {
      $alert = "Invalid Account";
      header('location:../home_schedules.php?invalid='.$alert);
    }
  }
}


?>

