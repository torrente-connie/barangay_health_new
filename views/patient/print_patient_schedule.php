<?php 
   require_once '../../assets/vendors/dompdf/autoload.inc.php';
   require("../../backend/dbconn.php");
   
   use Dompdf\Dompdf;
   $dompdf = new Dompdf();
   ob_start();
   
   ?>

   <?php
	$path = '../../assets/img/bh-logo-2.png';
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = file_get_contents($path);
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

	$path2 = '../../assets/img/liloan-logo-2.png';
	$type2 = pathinfo($path2, PATHINFO_EXTENSION);
	$data2 = file_get_contents($path2);
	$base642 = 'data:image/' . $type2 . ';base64,' . base64_encode($data2);

   ?>

   <?php 

   $connection = dbConn();
 
   // php code here;
   $appointment_id = $_GET['id'];

   $query = "SELECT 
             d.user_id as doctor_id,
             d.user_account_id as doctor_account,
             d.user_firstname  as doc_fname, 
             d.user_middlename as doc_mname, 
             d.user_lastname   as doc_lname,
             p.user_firstname  as patient_fname,
             p.user_middlename as patient_mname,
             p.user_lastname   as patient_lname,
             p.user_account_id as patient_account,
             p.user_id as patient_id,
             a.appointment_id as appointment_id,
             a.appointment_patient_fname as appoint_pfname,
             a.appointment_patient_mname as appoint_pmname,
             a.appointment_patient_lname as appoint_plname,
             a.appointment_patient_email as appoint_pemail,
             a.appointment_patient_pnum as appoint_ppnum,
             a.appointment_selected_date as appoint_date,
             a.appointment_selected_time as appoint_dst_id, 
             dst.schedule_start_time as appoint_start_time,
             dst.schedule_end_time as appoint_end_time,
             a.appointment_selected_service as appoint_service,
             a.appointment_type as appointment_type,
             a.appointment_status as appointment_status,
             a.appointment_reason as appointment_reason,
             a.appointment_code as appointment_code
             FROM appointment a
             JOIN user d 
             ON a.appointment_doctor_id = d.user_id 
             JOIN user p 
             ON a.appointment_patient_id = p.user_id 
             JOIN doctor_schedule_time dst 
             ON a.appointment_selected_time = dst.schedule_time_id 
             WHERE a.appointment_id = '$appointment_id' ";
             $result = mysqli_query($connection,$query);
             $row = mysqli_fetch_assoc($result);

   $dear_pfname = $row['patient_fname'];
   $dear_pmname = $row['patient_mname'];
   $dear_plname = $row['patient_lname'];

   $dear_fullname = $dear_pfname.' '.$dear_pmname.'. '.$dear_plname;


   $pfname = $row['appoint_pfname'];
   $pmname = $row['appoint_pmname'];
   $plname = $row['appoint_plname'];

   $fullname = $pfname.' '.$pmname.'. '.$plname;

   $sitename = 'Barangay San Vincente Liloan, Medical Clinic';

   $appointment_code = $row['appointment_code'];

   $appoint_start_time = $row['appoint_start_time'];
   $appoint_end_time = $row['appoint_end_time'];

   $appoint_date = $row['appoint_date'];   

   $format_date = date('l, F d, Y',strtotime($appoint_date));

    // format time
    $format_start = date("h:i:A", strtotime($appoint_start_time));
    $format_end   = date("h:i:A", strtotime($appoint_end_time));


   ?>


<!doctype html>
<html lang="en">
   <head>
	  <meta charset="UTF-8">
	  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	  <title>BRGYHEALTH: Barangay Health Center Appointment, Scheduling and Online Consultation System</title>
	  <link rel="icon" type="image/png" sizes="96x96" href="../../assets/img/favicon.ico">
 
      <style type="text/css">
         @page {
         margin: 0px;
         }
         body {
         margin: 0px;
         }
         * {
         font-family: Verdana, Arial, sans-serif;
         }
         a {
         color: #fff;
         text-decoration: none;
         }
         table {
         font-size: x-small;
         }
         tfoot tr td {
         font-weight: bold;
         font-size: x-small;
         }
         .invoice table {
         margin: 15px;
         }
         .invoice h3 {
         margin-left: 15px;
         }
         .invoice h4 {
         margin-left: 15px;
         }
         .information {
         background-color:rgba(40, 102, 199, 0.97)
         color: white;
         }
         .information .logo {
         margin: 5px;
         }
         .information table {
         padding: 10px;
         }

         .rounded-circle {
         	border-radius: 50%;
         }

         .text-uppercase {
         	text-transform: uppercase;
         }

         .text-capitalize {
         	text-transform: capitalize;
         }

         .text-success {
         	color: green;
         }

      </style>
   </head>
   <body>
      <div class="information">
         <table width="100%">

            <tr>
               <td align="left">
               	 <h2 style="color:white">BRGYHEALTH: Barangay Health Center Appointment, Scheduling and Online Consultation System</h2>
               </td>
               <td align="left" style="width: 10%;">
               	  <img src="<?php echo $base64?>" alt="Logo" class="logo"/>
               </td>
               <td align="left" style="width:10%">
               	  <img src="<?php echo $base642?>" alt="Logo" style="height: 85px; width: 90px; border-radius: 45px 45px 45px 45px;"/>
               </td>
            </tr>

         </table>
      </div>
      <br/>

         <div class="invoice">
      	 	<h3>Dear <span class="text-uppercase"><?php echo $dear_fullname ?></span> </h3> 
      	 	<h3 class="text-capitalize">good day! </h3>
      	 	<h3 class="text-capitalize text-success">you have successfully confirmed your appointment booking </h3>
      	 </div>

      <div class="invoice">
         <h4>The following are the details for your appointment:</h4>
         <hr>
         <table width="100%">
            <tbody>
               <tr>
                  <td width="40%" style="font-size: 30px;">Appointment Code #: </td>
                  <td width="60%" align="left" style="font-size: 24px;"><?php echo $appointment_code ?></td>
               </tr>
                <tr>
                  <td width="40%" style="font-size: 30px;">Site Name: </td>
                  <td width="60%" align="left" style="font-size: 24px;">Barangay San Vincente Liloan, Medical Clinic</td>
               </tr>
                <tr>
                  <td width="40%" style="font-size: 30px;">Patient Name: </td>
                  <td width="60%" align="left" style="font-size: 24px;"><?php echo $fullname ?></td>
               </tr>
                <tr>
                  <td width="40%" style="font-size: 30px;">Date: </td>
                  <td width="60%" align="left" style="font-size: 24px;"><?php echo $format_date ?></td>
               </tr>

               <tr>
                  <td width="40%" style="font-size: 30px;">Time: </td>
                  <td width="60%" align="left" style="font-size: 24px;"><?php echo $format_start ?> - <?php echo $format_end ?></td>
               </tr>
              
            </tbody>
         </table>
         <hr>
      </div>

      <div style="height: 100px;"></div>

      <div class="invoice" style="border:1px solid black;padding:10px;margin:20px;">
         <h4>Note:</h4>
         <table width="100%">
            <tbody>
            	
               <tr>
                  <td width="60%" align="left" style="font-size: 20px;">1. Please Present A Printed Copy of This Appointment Booking Ticket To The Barangay Health Worker.</td>
               </tr>

               <tr>
                  <td width="60%" align="left" style="font-size: 20px;">2. Bring your vaccination ID and One Valid Government ID.</td>
               </tr>

                <tr>
                  <td width="60%" align="left" style="font-size: 20px;">3. Don't Forget to wear your Face Mask and Face Shield.</td>
               </tr>
              
              
            </tbody>
         </table>
       </div>

      <div class="information" style="position: absolute; bottom: 0;">
         <table width="100%">
            <tr>
               <td align="left" style="width: 50%;">
                 <span style="color:white;font-weight: bold;">BRGYHEALTH: Barangay Health Center Appointment, Scheduling and Online Consultation System</span>
               </td>
              
            </tr>
         </table>
      </div>

   </body>
</html>
<?php
   $html = ob_get_clean();
   $dompdf->loadHtml($html);
   $dompdf->setPaper('A4', 'portrait');
   $dompdf->render();
   $dompdf->stream("codexworld",array("Attachment"=>0));
   
   ?>