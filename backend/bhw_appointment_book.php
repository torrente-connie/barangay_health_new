<?php

require("dbconn.php");

//fetch data for subject using update,delete and view
if(isset($_POST['bookID'])){
  getAllDataForAppointmentBook();
}


function getAllDataForAppointmentBook(){
    $conn = dbConn();
    $id = $_POST['bookID'];
    $sql = "SELECT 
    		d.user_id as doctor_id,
            d.user_account_id as doctor_account,
            d.user_firstname  as doc_fname, 
            d.user_middlename as doc_mname, 
            d.user_lastname   as doc_lname,
            p.user_id as patient_id,
            p.user_firstname  as patient_fname,
            p.user_middlename as patient_mname,
            p.user_lastname   as patient_lname,
            p.user_account_id as patient_account,
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
            a.appointment_reason as appointment_reason
            FROM appointment a
            JOIN user d 
            ON a.appointment_doctor_id = d.user_id 
            JOIN user p 
            ON a.appointment_patient_id = p.user_id 
            JOIN doctor_schedule_time dst 
            ON a.appointment_selected_time = dst.schedule_time_id
            WHERE a.appointment_id = '$id' ";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
}


// code for accept appointment
if(isset($_POST['acceptAppointmentSubmit'])) {
	
	$connection = dbConn();
	$acceptID = $_POST['acceptID'];
	$reason = "";
	
	$sql = "UPDATE appointment SET `appointment_status` = '3', `appointment_reason` = '$reason' WHERE appointment_id = '$acceptID' ";
	$result = mysqli_query($connection,$sql);

	if($result) {
	 	$alert="Appointment Book Accept by Barangay Health Worker";
			header("Location:../views/bhw/appointments_book.php?s=".$alert);
		}else{
		 $alert="Error";
			header("Location:../views/bhw/appointments_book.php?s=".$alert);
		}	
	}


// code for cancel appointment
if(isset($_POST['cancelAppointmentSubmit'])) {
	
	$connection = dbConn();
	$cancelID = $_POST['cancelID'];
	$reason = $_POST['reason'];

	$sql = "UPDATE appointment SET `appointment_status` = '2', `appointment_reason` = '$reason' WHERE appointment_id = '$cancelID' ";
	$result = mysqli_query($connection,$sql);

	if($result) {
	 	$alert="Appointment Book Cancel by Barangay Health Worker";
			header("Location:../views/bhw/appointments_book.php?s=".$alert);
		}else{
		 $alert="Error";
			header("Location:../views/bhw/appointments_book.php?s=".$alert);
		}	
	}

// code for face to face appointment
if(isset($_POST['proceedAppointmentSubmit'])) {
    
    $connection = dbConn();

    $proceedID = $_POST['proceedID']; // appointment ID ni;
    $proceedDoctorID = $_POST['proceedDoctorID']; // doctor ni;
    $proceedPatientID = $_POST['proceedPatientID']; // patient ni;
    $proceedDate = $_POST['proceedDate']; // date ni;
    $proceedStartTime = $_POST['proceedStartTime']; // start time ni;
    $proceedEndTime = $_POST['proceedEndTime']; // end time ni;

    $proceedPfname = $_POST['proceedPfname'];
    $proceedPmname = $_POST['proceedPmname'];
    $proceedPlname = $_POST['proceedPlname'];

    $proceedAppointmentType = $_POST['proceedAppointmentType'];
    $proceedMedicalService = $_POST['proceedMedicalService'];

    $appointment_code = $_POST['appointment_code'];
   
    date_default_timezone_set('Asia/Manila');
    $proceed_datetime = date('Y/m/d H:i:s');

    $proceed_status = 1;
    $proceed_bool = 1;

    $getAppointmentCode = "SELECT * FROM appointment WHERE appointment_id = '$proceedID' ";
    $resultAppointmentCode = mysqli_query($connection,$getAppointmentCode);
    $rowAppointmentCode = mysqli_fetch_assoc($resultAppointmentCode);
   
    if($appointment_code == $rowAppointmentCode['appointment_code']) {

    $query = "INSERT INTO patient_list (patient_list_id,patient_list_user_id,patient_list_doctor_id,patient_list_appointment_id,patient_list_pfname,patient_list_pmname,patient_list_plname,patient_list_appointment_type,patient_list_medical_service,patient_list_date,patient_list_stime,patient_list_etime,patient_list_datetime,patient_list_status,patient_list_bool) VALUES (NULL, '$proceedPatientID','$proceedDoctorID','$proceedID','$proceedPfname','$proceedPmname','$proceedPlname','$proceedAppointmentType','$proceedMedicalService','$proceedDate','$proceedStartTime','$proceedEndTime','$proceed_datetime','$proceed_status','$proceed_bool')";
    $result_query = mysqli_query($connection,$query);

    $sql = "UPDATE appointment SET `appointment_status` = '7', `appointment_code_status` = '0' WHERE appointment_id = '$proceedID' ";
    $result_sql = mysqli_query($connection,$sql);

    if($result_query AND $result_sql) {
        $alert="Virtual Consultation Set by Barangay Health Worker";
            //header("Location:../views/bhw/appointments_book.php?s=".$alert);
            header("Location:../views/bhw/dashboard.php?s=".$alert);
        }else{
         $alert="Error";
            //header("Location:../views/bhw/appointments_book.php?s=".$alert);
         var_dump($query);
        }   
  } else {
     $alert="Wrong Appointment Code Inputted";
        header("Location:../views/bhw/appointments_book.php?s=".$alert);
  }
}



?>