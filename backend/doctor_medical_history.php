<?php

require("dbconn.php");

if(isset($_POST['addPatientMedicalDescription'])) {
	addPatientMedicalDescription();
}


function addPatientMedicalDescription() {
	$conn = dbConn();

	$plist_id = $_POST['plist_id']; // only for return
	
	// save this into database
	$plist_user_id = $_POST['plist_user_id'];

	if($plist_user_id == 0) {
		$patient_user_id = 0;
	} else {
		$patient_user_id = $plist_user_id;
	}

	$plist_doctor_id = $_POST['plist_doctor_id'];
	$plist_appointment_id = $_POST['plist_appointment_id'];
	$plist_firstname = $_POST['plist_firstname'];
	$plist_middlename = $_POST['plist_middlename'];
	$plist_lastname = $_POST['plist_lastname'];
	$plist_atype = $_POST['plist_atype'];
	$plist_mservice = $_POST['plist_mservice'];



	$patient_age = $_POST['patient_age'];
	$patient_allergy = $_POST['patient_allergy'];
	$patient_symptoms = $_POST['patient_symptoms'];
	$patient_temperature = $_POST['patient_temperature'];
	$patient_hr = $_POST['patient_hr'];
	$patient_bp = $_POST['patient_bp'];
	$patient_pr = $_POST['patient_pr'];


	$patient_comments = $_POST['patient_comments'];

	if($_POST['patient_prescription'] == "") {
		$patient_prescription = "";
	} else {
		$patient_prescription = $_POST['patient_prescription'];
	}

	$plist_date = $_POST['plist_date'];
	$plist_stime = $_POST['plist_stime'];
	$plist_etime = $_POST['plist_etime'];
	
	 date_default_timezone_set('Asia/Manila');
    $plist_datetime = date('Y/m/d H:i:s');

	$status = '1';
	$bool = '1';

	$sql = "INSERT INTO medical_history (medical_history_id,medical_history_user_id,medical_history_doctor_id,medical_history_appointment_id,medical_history_pfname,medical_history_pmname,medical_history_plname,medical_history_page,medical_history_pallergy,medical_history_psymptoms,medical_history_ptemp,medical_history_pheart,medical_history_pbp,medical_history_pulse,medical_history_pcomments,medical_history_pprescription,medical_history_appointment_type,medical_history_medical_service,medical_history_date,medical_history_stime,medical_history_etime,medical_history_datetime,medical_history_status,medical_history_bool) VALUES (NULL,'$patient_user_id','$plist_doctor_id','$plist_appointment_id','$plist_firstname','$plist_middlename','$plist_lastname','$patient_age','$patient_allergy','$patient_symptoms','$patient_temperature','$patient_hr','$patient_bp','$patient_pr','$patient_comments','$patient_prescription','$plist_atype','$plist_mservice','$plist_date','$plist_stime','$plist_etime','$plist_datetime','$status','$bool')";
	$result = mysqli_query($conn,$sql);

	// completed appointment
	$query = "UPDATE appointment SET `appointment_status` = '0' WHERE appointment_id = '$plist_appointment_id' ";
    $result_query = mysqli_query($conn,$query);

    // completed patient list
    $query2 = "UPDATE patient_list SET `patient_list_status` = '0' WHERE patient_list_id = '$plist_id' ";
    $result_query2 = mysqli_query($conn,$query2);


	if($result AND $result_query AND $result_query2) {
		 $alert="Patient Appointment Successfully Completed";
			header("Location:../views/doctor/patients.php?s=".$alert);
		} else {
		 $alert="Error";
		 	header("Location:../views/doctor/patients_add_description.php?plid=$plist_id&s=".$alert);
		}

}




?>