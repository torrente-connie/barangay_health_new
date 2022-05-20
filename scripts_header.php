<?php 

session_start();

  if(!empty($_SESSION['patient_id'])) {

  $patient_id = $_SESSION['patient_id'];
  $patient_fullname = $_SESSION['patient_fullname'];
  $patient_image = $_SESSION['patient_image'];

  } else if(!empty($_SESSION['bhw_id'])) {

  $bhw_id = $_SESSION['bhw_id'];
  $bhw_fullname = $_SESSION['bhw_fullname'];
  $bhw_image = $_SESSION['bhw_image'];

  }

?>

<!DOCTYPE html>
<html lang="en"><head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>BRGYHEALTH: Barangay Health Center Appointment, Scheduling and Online Consultation System</title>
  <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.ico">
  
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.css">
  
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/vendors/fontawesome/css/all.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">

  <link rel="stylesheet" href="assets/vendors/bootstrap-social/bootstrap-social.css">

  <link rel="stylesheet" href="assets/vendors/fullcalendar/lib/main.css">

  <link rel="stylesheet" href="assets/vendors/owlcarousel/dist/assets/owl.carousel.css">

  <link rel="stylesheet" href="assets/vendors/jquery-ui/jquery-ui.css">

  <link href='assets/vendors/fullcalendar/packages/core/main.css' rel='stylesheet' />
  <link href='assets/vendors/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
  <link href='assets/vendors/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
  <link href='assets/vendors/fullcalendar/packages/list/main.css' rel='stylesheet' />

</head>


