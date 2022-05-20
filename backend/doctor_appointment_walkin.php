<?php

require("dbconn.php");

//fetch data for subject using update,delete and view
if(isset($_POST['walkInID'])){
  getAllDataForAppointmentWalkIn();
}


function getAllDataForAppointmentWalkIn(){
    $conn = dbConn();
    $id = $_POST['walkInID'];
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
if(isset($_POST['approveAppointmentSubmit'])) {
	
	$connection = dbConn();
	$approveID = $_POST['approveID'];
	$reason = "";
	
	$sql = "UPDATE appointment SET `appointment_status` = '4', `appointment_reason` = '$reason' WHERE appointment_id = '$approveID' ";
	$result = mysqli_query($connection,$sql);

	if($result) {
	 	$alert="Appointment Book Approve by Doctor ";
			header("Location:../views/doctor/appointments_oc.php?s=".$alert);
		}else{
		 $alert="Error";
			header("Location:../views/doctor/appointments_oc.php?s=".$alert);
		}	
	}


// code for cancel appointment
if(isset($_POST['rescheduleAppointmentSubmit'])) {
	
	$connection = dbConn();
	$rescheduleID = $_POST['rescheduleID'];
	$reason = $_POST['reason'];

	$sql = "UPDATE appointment SET `appointment_status` = '5', `appointment_reason` = '$reason' WHERE appointment_id = '$rescheduleID' ";
	$result = mysqli_query($connection,$sql);

	if($result) {
	 	$alert="Appointment Book Cancel by Barangay Health Worker";
			header("Location:../views/doctor/appointments_oc.php?s=".$alert);
		}else{
		 $alert="Error";
			header("Location:../views/doctor/appointments_oc.php?s=".$alert);
		}	
	}


?>