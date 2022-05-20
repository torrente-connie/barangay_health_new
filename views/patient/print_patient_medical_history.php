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
   $medical_history = $_GET['id'];

   
                      $sql = "SELECT 
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
                      mh.medical_history_id as medical_history_id,
                      mh.medical_history_user_id as mh_user_id,
                      mh.medical_history_doctor_id as mh_doctor_id,
                      mh.medical_history_appointment_id as mh_appointment_id,
                      mh.medical_history_pfname as mh_pfname,
                      mh.medical_history_pmname as mh_pmname,
                      mh.medical_history_plname as mh_plname,
                      mh.medical_history_page as mh_page,
                      mh.medical_history_pallergy as mh_pallergy,
                      mh.medical_history_psymptoms as mh_psymptoms,
                      mh.medical_history_ptemp as mh_ptemp,
                      mh.medical_history_pheart as mh_pheart,
                      mh.medical_history_pbp as mh_pbp,
                      mh.medical_history_pulse as mh_pulse,
                      mh.medical_history_pcomments as mh_pcomments,
                      mh.medical_history_pprescription as mh_pprescription,
                      mh.medical_history_appointment_type as mh_atype,
                      mh.medical_history_medical_service as mh_mservice,
                      mh.medical_history_date as mh_date,
                      mh.medical_history_stime as mh_stime,
                      mh.medical_history_etime as mh_etime,
                      mh.medical_history_datetime as mh_datetime,
                      mh.medical_history_status as mh_status,
                      mh.medical_history_bool as mh_bool
                      FROM medical_history mh
                      JOIN user p 
                      ON mh.medical_history_user_id = p.user_id 
                      JOIN user d 
                      ON mh.medical_history_doctor_id = d.user_id
                      JOIN appointment a 
                      ON mh.medical_history_appointment_id = a.appointment_id
                      WHERE mh.medical_history_id = '$medical_history'
                      ";
                    
   $result = mysqli_query($connection,$sql);
   $row = mysqli_fetch_assoc($result);

   $patient_id = $row['patient_id'];

   // doctor fullname
   $doc_account      = $row['doctor_account'];
   $doc_firstname    = ucfirst($row['doc_fname']);
   $doc_middlename   = ucfirst($row['doc_mname']);
   $doc_lastname     = ucfirst($row['doc_lname']);

   $doc_name = $doc_firstname.' '.$doc_middlename.'.'.' '.$doc_lastname;

   // user patient fullname
   $book_patient_account      = $row['patient_account'];
   $book_patient_firstname    = ucfirst($row['patient_fname']);
   $book_patient_middlename   = ucfirst($row['patient_mname']);
   $book_patient_lastname     = ucfirst($row['patient_lname']);

   $book_patient_name = $book_patient_firstname.' '.$book_patient_middlename.'.'.' '.$book_patient_lastname;

   // user patient fullname
   $mh_firstname    = ucfirst($row['mh_pfname']);
   $mh_middlename   = ucfirst($row['mh_pmname']);
   $mh_lastname     = ucfirst($row['mh_plname']);

   $mh_name = $mh_firstname.' '.$mh_middlename.'.'.' '.$mh_lastname;

   // format date and time
   $date = $row['mh_date'];
   $format_start = date("h:i:A", strtotime($row['mh_stime']));
   $format_end   = date("h:i:A", strtotime($row['mh_etime']));
   
   //
   $mh_id = $row['medical_history_id'];
   $mh_mservice = $row['mh_mservice'];
   $mh_atype = $row['mh_atype'];

   if($mh_atype == "bookappointment") {
     $atype = "Face to Face Appointment";
   } else if($mh_atype == "onlineappointment") {
     $atype = "Virtual Consultation";
   } else if($mh_atype == "walkinappointment" AND $patient_id != 0 ) {
     $atype = "Walk-In Appointment With Account";
   } else if($mh_atype == "walkinappointment" AND $patient_id == 0) {
     $atype = "Walk-In Appointment Without Account";
   }

   // patient medical records

   $mh_age = $row['mh_page'];
   $mh_allergy = $row['mh_pallergy'];
   $mh_symptoms = $row['mh_psymptoms'];
   $mh_temp = $row['mh_ptemp'];
   $mh_heart = $row['mh_pheart'];
   $mh_bp = $row['mh_pbp'];
   $mh_pulse = $row['mh_pulse'];
   $mh_comments = $row['mh_pcomments'];
   $mh_prescription = $row['mh_pprescription'];


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
      	 	<h3>Patient Name: <span class="text-capitalize"><?php echo $mh_name ?></span> </h3>
          <h3>Doctor Name: <span class="text-capitalize"><?php echo $doc_name ?></span> </h3>
          <h3>Appointment Type and Medical Service: <span class="text-capitalize"><?php echo $atype ?></span> - <span class="text-capitalize"><?php echo $mh_mservice ?></span>  </h3>
          <h3>Appointment Date and Time: <span class="text-capitalize"><?php echo $date ?></span> and <?php echo $format_start ?> to <?php echo $format_end ?> </h3> 
      	 </div>

      <div class="invoice">
         <h2 style="text-align:center">Patient Medical Records</h2>
         <hr>
         <table width="100%">
            <tbody>
               <tr>
                  <td width="60%" style="font-size: 24px;">Patient Age: </td>
                  <td width="40%" align="left" style="font-size: 24px;"><?php echo $mh_age ?></td>
               </tr>
                <tr>
                  <td width="60%" style="font-size: 24px;">Patient Allergy: </td>
                  <td width="40%" align="left" style="font-size: 24px;"><?php echo $mh_allergy ?></td>
               </tr>
                <tr>
                  <td width="60%" style="font-size: 24px;">Patient Symptoms: </td>
                  <td width="40%" align="left" style="font-size: 24px;"><?php echo $mh_symptoms ?></td>
               </tr>
                <tr>
                  <td width="60%" style="font-size: 24px;">Patient Temperature: </td>
                  <td width="40%" align="left" style="font-size: 24px;"><?php echo $mh_temp ?></td>
               </tr>

               <tr>
                  <td width="60%" style="font-size: 24px;">Patient Heart Rate: </td>
                  <td width="40%" align="left" style="font-size: 24px;"><?php echo $mh_heart ?></td>
               </tr>

                <tr>
                  <td width="60%" style="font-size: 24px;">Patient Blood Pressure Rate: </td>
                  <td width="40%" align="left" style="font-size: 24px;"><?php echo $mh_bp ?></td>
               </tr>

                <tr>
                  <td width="60%" style="font-size: 24px;">Patient Pulse Rate: </td>
                  <td width="40%" align="left" style="font-size: 24px;"><?php echo $mh_pulse ?></td>
               </tr>

                <tr>
                  <td width="60%" style="font-size: 24px;">Doctor Comments: </td>
                  <td width="40%" align="left" style="font-size: 24px;"><?php echo $mh_comments ?></td>
               </tr>

                <tr>
                  <td width="60%" style="font-size: 24px;">Doctor Prescriptions: </td>
                  <td width="40%" align="left" style="font-size: 24px;"><?php echo $mh_prescription ?></td>
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