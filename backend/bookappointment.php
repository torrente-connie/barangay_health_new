<?php

require("dbconn.php");


// code for add new doctor

if(isset($_POST['bookAppointmentSubmit'])) {
	
	$appointment_type = $_POST['book_appointment'];

	if($appointment_type == 'bookappointment') {
		bookAppointment();
	} else if($appointment_type == 'onlineappointment') {
		onlineConsultation();
	} else if($appointment_type == 'walkinappointment') {
		walkInConsultation();
	}
}

function bookAppointment() {
	$conn = dbConn();
	
	$get_doctor_id				= $_POST['selected_doctor_id'];
	$patient_user_id 			= $_POST['patient_user_id']; // who made the booking
	$patient_firstname 			= $_POST['patient_firstname']; // info of patient
	$patient_middlename 		= $_POST['patient_middlename']; 
	$patient_lastname 			= $_POST['patient_lastname'];
	$patient_email				= $_POST['patient_email']; 
	$patient_phonenumber		= $_POST['patient_phonenumber'];
	$date_selected 				= $_POST['selected_date'];
	$appointmentsched_selected	= $_POST['selected_asched'];
	$healthservices 			= $_POST['selected_service'];
	$bookappointment 			= $_POST['book_appointment'];

	$appointment_status			= 1;
	$appointment_reason			= "";
	$appointment_bool			= 1;

	$old_date = explode('/', $date_selected); 
	$new_data = $old_date[2].'-'.$old_date[0].'-'.$old_date[1];

	// appointment code;
	$appointment_code 			= "";
    $appointment_code_status    = 0;

	$sql = "INSERT INTO appointment (appointment_id,appointment_doctor_id,appointment_patient_id,appointment_patient_fname,appointment_patient_mname,appointment_patient_lname,appointment_patient_email,appointment_patient_pnum,appointment_selected_date,appointment_selected_time,appointment_selected_service,appointment_type,appointment_status,appointment_reason,appointment_code,appointment_code_status,appointment_bool) VALUES (NULL,'$get_doctor_id','$patient_user_id','$patient_firstname','$patient_middlename','$patient_lastname','$patient_email','$patient_phonenumber','$new_data','$appointmentsched_selected','$healthservices','$bookappointment','$appointment_status','$appointment_reason','$appointment_code','$appointment_code_status','$appointment_bool')";
	$result = mysqli_query($conn,$sql);


	// notification message

	$notif_pname = $patient_firstname.' '.$patient_middlename.'. '.$patient_lastname;
	$notif_pdate = $new_data;

	$notif_message = "Patient ".$notif_pname." Has Successfully Booked Face to Face Appointment On" .$notif_pdate;

	$notif_admin = 0;
	$notif_patient = $patient_user_id;
	$notif_doctor = $get_doctor_id;
	$notif_bhw = 0;

	$notif_status = 0;
	$notif_usertype = 'bhw';
	// current date time
	date_default_timezone_set('Asia/Manila');
    $notif_datetime = date('Y/m/d H:i:s');

	$insertNotification = "INSERT INTO notification (`notification_id`,`notification_admin_id`,`notification_patient_id`,`notification_doctor_id`,`notification_bhw_id`,`notification_message`,`notification_status`,`notification_usertype`,`notification_datetime`) VALUES (NULL,'$notif_admin','$notif_patient','$notif_doctor','$notif_bhw','$notif_message','$notif_status','$notif_usertype','$notif_datetime')";
	$resultNotification = mysqli_query($conn,$insertNotification);

	if($result AND $resultNotification){
		 $alert="Successfully Booked A Face to Face Appointment";
			header("Location:../home_schedules.php?s=".$alert);
		}else{
		 $alert="Error";
          //var_dump($conn);
          //var_dump($sql);
         header("Location:../home_schedules.php?f=".$alert);
		}
 }

 function onlineConsultation() {

 	$conn = dbConn();
	
	$get_doctor_id				= $_POST['selected_doctor_id'];
	$patient_user_id 			= $_POST['patient_user_id']; // who made the booking
	$patient_firstname 			= $_POST['patient_firstname']; // info of patient
	$patient_middlename 		= $_POST['patient_middlename']; 
	$patient_lastname 			= $_POST['patient_lastname'];
	$patient_email				= $_POST['patient_email']; 
	$patient_phonenumber		= $_POST['patient_phonenumber'];
	$date_selected 				= $_POST['selected_date'];
	$appointmentsched_selected	= $_POST['selected_asched'];
	$healthservices 			= "Virtual Consultation";
	$onlineconsultation 		= $_POST['book_appointment'];

	$appointment_status			= 1;
	$appointment_reason			= "";
	$appointment_bool			= 1;

	$old_date = explode('/', $date_selected); 
	$new_data = $old_date[2].'-'.$old_date[0].'-'.$old_date[1];

    	// appointment code;
	$appointment_code 			= "";
    $appointment_code_status    = 0;

	$sql = "INSERT INTO appointment (appointment_id,appointment_doctor_id,appointment_patient_id,appointment_patient_fname,appointment_patient_mname,appointment_patient_lname,appointment_patient_email,appointment_patient_pnum,appointment_selected_date,appointment_selected_time,appointment_selected_service,appointment_type,appointment_status,appointment_reason,appointment_code,appointment_code_status,appointment_bool) VALUES (NULL,'$get_doctor_id','$patient_user_id','$patient_firstname','$patient_middlename','$patient_lastname','$patient_email','$patient_phonenumber','$new_data','$appointmentsched_selected','$healthservices','$onlineconsultation','$appointment_status','$appointment_reason','$appointment_code','$appointment_code_status','$appointment_bool')";
	$result = mysqli_query($conn,$sql);

	// notification message

	$notif_pname = $patient_firstname.' '.$patient_middlename.'. '.$patient_lastname;
	$notif_pdate = $new_data;

	$notif_message = "Patient ".$notif_pname." Has Successfully Booked Virtual Consultation On  "  .$notif_pdate;

	$notif_admin = 0;
	$notif_patient = $patient_user_id;
	$notif_doctor = $get_doctor_id;
	$notif_bhw = 0;

	$notif_status = 0;
	$notif_usertype = 'bhw';
	// current date time
	date_default_timezone_set('Asia/Manila');
    $notif_datetime = date('Y/m/d H:i:s');

	$insertNotification = "INSERT INTO notification (`notification_id`,`notification_admin_id`,`notification_patient_id`,`notification_doctor_id`,`notification_bhw_id`,`notification_message`,`notification_status`,`notification_usertype`,`notification_datetime`) VALUES (NULL,'$notif_admin','$notif_patient','$notif_doctor','$notif_bhw','$notif_message','$notif_status','$notif_usertype','$notif_datetime')";
	$resultNotification = mysqli_query($conn,$insertNotification);


	if($result AND $resultNotification) {
		 $alert="Successfully Booked A Virtual Consultation Appointment";
			header("Location:../home_schedules.php?s=".$alert);
		}else{
		 $alert="Error";
         header("Location:../home_schedules.php?f=".$alert);
		}
	}

function walkInConsultation() {
	$conn = dbConn();
	
	$patient_account_id 		= $_POST['patient_account_id'];


	if(empty($patient_account_id)) {
		$patient_user_id = 0;
	} else {
		$accountID = $patient_account_id;
		$sqlAccountId = "SELECT * FROM user WHERE user_account_id = '$accountID' AND user_type = 'Patient' ";
		$resultAccountId = mysqli_query($conn,$sqlAccountId);
		$rowAccountId = mysqli_fetch_assoc($resultAccountId);

		if(mysqli_num_rows($resultAccountId) > 0) {
			$patient_user_id = $rowAccountId['user_id'];
		} else {
			$alert="Only Add Patient Account";
       		header("Location:../home_schedules.php?f=".$alert);
		}	
		
	}

	$get_doctor_id				= $_POST['selected_doctor_id'];
	$patient_firstname 			= $_POST['patient_firstname']; // info of patient
	$patient_middlename 		= $_POST['patient_middlename']; 
	$patient_lastname 			= $_POST['patient_lastname'];
	$patient_email				= $_POST['patient_email']; 
	$patient_phonenumber		= $_POST['patient_phonenumber'];
	$date_selected 				= $_POST['selected_date'];
	$appointmentsched_selected	= $_POST['selected_asched'];
	$healthservices 			= $_POST['selected_service'];
	$bookappointment 			= $_POST['book_appointment'];

	$appointment_status			= 13; // only for walk-ins must be double digits
	$appointment_reason			= "";
	$appointment_bool			= 1;

	$old_date = explode('/', $date_selected); 
	$new_data = $old_date[2].'-'.$old_date[0].'-'.$old_date[1];

	// appointment code;
	$appointment_code 			= "";
    $appointment_code_status    = 0;

	$sql = "INSERT INTO appointment (appointment_id,appointment_doctor_id,appointment_patient_id,appointment_patient_fname,appointment_patient_mname,appointment_patient_lname,appointment_patient_email,appointment_patient_pnum,appointment_selected_date,appointment_selected_time,appointment_selected_service,appointment_type,appointment_status,appointment_reason,appointment_code,appointment_code_status,appointment_bool) VALUES (NULL,'$get_doctor_id','$patient_user_id','$patient_firstname','$patient_middlename','$patient_lastname','$patient_email','$patient_phonenumber','$new_data','$appointmentsched_selected','$healthservices','$bookappointment','$appointment_status','$appointment_reason','$appointment_code','$appointment_code_status','$appointment_bool')";
	$result = mysqli_query($conn,$sql);

	// notification message

	$notif_pname = $patient_firstname.' '.$patient_middlename.'. '.$patient_lastname;
	$notif_pdate = $new_data;

	$notif_message = "Patient ".$notif_pname." Has Successfully Booked Walk-In Appointment On  "  .$notif_pdate;

	$notif_admin = 0;
	$notif_patient = $patient_user_id;
	$notif_doctor = $get_doctor_id;
	$notif_bhw = 0;

	$notif_status = 0;
	$notif_usertype = 'bhw';
	// current date time
	date_default_timezone_set('Asia/Manila');
    $notif_datetime = date('Y/m/d H:i:s');

	$insertNotification = "INSERT INTO notification (`notification_id`,`notification_admin_id`,`notification_patient_id`,`notification_doctor_id`,`notification_bhw_id`,`notification_message`,`notification_status`,`notification_usertype`,`notification_datetime`) VALUES (NULL,'$notif_admin','$notif_patient','$notif_doctor','$notif_bhw','$notif_message','$notif_status','$notif_usertype','$notif_datetime')";
	$resultNotification = mysqli_query($conn,$insertNotification);

	if($result AND $resultNotification) {
		 $alert="Successfully Booked An Appointment";
			header("Location:../home_schedules.php?s=".$alert);
		}else{
		 $alert="Error";
        //  var_dump($conn);
        //  var_dump($sql);
        	header("Location:../home_schedules.php?f=".$alert);
		}
 	}
?>