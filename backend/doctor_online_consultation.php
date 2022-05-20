<?php

require("dbconn.php");

//fetch data for subject using update,delete and view
if(isset($_POST['vcID'])){
  getAllDataForVirtualConsultation();
}


function getAllDataForVirtualConsultation(){
    $conn = dbConn();
    $id = $_POST['vcID'];
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
             vc.virtual_consultation_patient_fname as virtual_pfname,
             vc.virtual_consultation_patient_mname as virtual_pmname,
             vc.virtual_consultation_patient_lname as virtual_plname,
             vc.virtual_consultation_id as consultation_id,
             vc.virtual_consultation_link as consultation_link,
             vc.virtual_consultation_type as consultation_type,
             vc.virtual_consultation_date as consultation_date,
             vc.virtual_consultation_start_time as consultation_stime,
             vc.virtual_consultation_end_time as consultation_etime,
             vc.virtual_consultation_status as consultation_status,
             vc.virtual_consultation_bool as consultation_bool
             FROM virtual_consultation vc
             JOIN user d 
             ON vc.virtual_consultation_doctor_id = d.user_id 
             JOIN user p 
             ON vc.virtual_consultation_user_id = p.user_id 
             JOIN appointment a 
             ON vc.virtual_consultation_appointment_id = a.appointment_id
             WHERE vc.virtual_consultation_id = '$id' ";
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
			header("Location:../views/doctor/appointments_book.php?s=".$alert);
		}else{
		 $alert="Error";
			header("Location:../views/doctor/appointments_book.php?s=".$alert);
		}	
	}

// code for when the virtual consultation is completed
if(isset($_POST['completedVirtualConsultationSubmit'])) {
    
    $connection = dbConn();
    $consultationID = $_POST['consultationID'];
    $appointmentID = $_POST['appointmentID'];
    $reason = "";
  
    $query = "UPDATE virtual_consultation SET `virtual_consultation_status` =  '0' WHERE virtual_consultation_id = '$consultationID' ";
    $result_query = mysqli_query($connection,$query);

    $sql = "UPDATE appointment SET `appointment_status` = '0', `appointment_reason` = '$reason' WHERE appointment_id = '$appointmentID' ";
    $result = mysqli_query($connection,$sql);

    if($result_query AND $result) {
        $alert="The Virtual Consultation Is Successfully Completed";
            header("Location:../views/doctor/online_consultation.php?s=".$alert);
        }else{
         $alert="Error";
            header("Location:../views/doctor/online_consultation.php?s=".$alert);
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
			header("Location:../views/doctor/appointments_book.php?s=".$alert);
		}else{
		 $alert="Error";
			header("Location:../views/doctor/appointments_book.php?s=".$alert);
		}	
	}


?>