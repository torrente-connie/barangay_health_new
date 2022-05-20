<?php

require("dbconn.php");

//fetch data for subject using update,delete and view
if(isset($_POST['mhID'])){
  getAllDataForMedicalHistory();
}


function getAllDataForMedicalHistory(){
    $conn = dbConn();
    $id = $_POST['mhID'];
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
            LEFT JOIN user p 
            ON mh.medical_history_user_id = p.user_id 
            JOIN user d 
            ON mh.medical_history_doctor_id = d.user_id
            JOIN appointment a 
            ON mh.medical_history_appointment_id = a.appointment_id
            WHERE mh.medical_history_id = '$id'
            ";
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


?>