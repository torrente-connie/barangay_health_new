<?php

require("dbconn.php");


// add new schedules for doctor

if(isset($_POST['addDoctorSchedSubmit'])) {
	addDoctorSched();
}


function addDoctorSched() {
	$conn = dbConn();

	$doctor_id 	= $_POST['doctorID'];
	$day 		= $_POST['sched_day'];
	$start_time = $_POST['sched_start'];
	$end_time 	= $_POST['sched_end'];
	$time_interval = 60;

	$status = '1';
	$bool = '1';

	$sql = "INSERT INTO doctor_schedule (schedule_id,doctor_id,schedule_day,schedule_start_time,schedule_end_time,schedule_time_interval,schedule_status,schedule_bool) VALUES (NULL,'$doctor_id','$day','$start_time','$end_time','$time_interval','$status','$bool')";
	$result = mysqli_query($conn,$sql);


	if($result){
		 $alert="Added New Schedule";
			header("Location:../views/doctor/schedules.php?s=".$alert);
		}else{
		 $alert="Error";
			header("Location:../views/doctor/schedules.php?s=".$alert);
		}

}

if(isset($_POST['updateDoctorTimeSchedule'])) {
	updateDoctorSched();
}

function updateDoctorSched() {
	$conn = dbConn();

	$ti = $_POST['schedID'];
	$time_interval = $_POST['time_interval'];

	$status = '1';
	$bool = '1';

	$sql = "UPDATE doctor_schedule SET `schedule_time_interval` = '$time_interval' WHERE `schedule_id` = '$ti' ";
	$result = mysqli_query($conn,$sql);

	if($result){
		 $alert="Updated Time Schedule";
			header("Location:../views/doctor/schedules.php?s=".$alert);
		}else{
		 $alert="Error";
			header("Location:../views/doctor/schedules.php?s=".$alert);
		}

}


// code for add new doctor

if(isset($_POST['addBhwSubmitBtn'])) {
	addBhw();
}

function addBhw() {
	$conn = dbConn();
	
	// info from form
	$bhw_fname = $_POST['bhw_firstname'];
	$bhw_mname = $_POST['bhw_middlename'];
	$bhw_lname = $_POST['bhw_lastname'];
	$bhw_email = $_POST['bhw_email'];
	$bhw_pnum = $_POST['bhw_phonenumber'];
	$bhw_dob = $_POST['bhw_dob'];


    // user type,status and bool 
    $bhw_type = 'Barangay Health Worker';
    $bhw_status = 1;
    $bhw_bool = 1;


	// get unique id number, username and password 
	$getUniqueSql = "SELECT COUNT(*) FROM user 
	WHERE user_type = 'Barangay Health Worker' ";
	$getUniqueResult = mysqli_query($conn,$getUniqueSql);
	$displayUnique = mysqli_fetch_array($getUniqueResult);
	$getUniqueYear = date("Y");
	$getUniqueAccNum = '066';
	$bhw_uname = 'BH'.''.$getUniqueYear.''.$getUniqueAccNum.''.$displayUnique[0];
	$bhw_pass = md5($bhw_uname);

    $sql = "INSERT INTO user (user_id,user_account_id,user_email,user_password,user_firstname,user_middlename,user_lastname,user_dob,user_cnum,user_type,user_status,user_bool) VALUES
	(NULL,'$bhw_uname','$bhw_email','$bhw_pass','$bhw_fname','$bhw_mname','$bhw_lname','$bhw_dob','$bhw_pnum','$bhw_type','$bhw_status','$bhw_bool')";

	$result = mysqli_query($conn,$sql);

	if($result){
		 $alert="Added New Barangay Health Worker";
			header("Location:../views/admin/accounts_bhw.php?s=".$alert);
		}else{
		 $alert="Error Cannot Add This Doctor";
			header("Location:../views/admin/accounts_bhw.php?f=".$alert);
		}
 }

// soft delete for subject data
if(isset($_POST['updateStudentSubmit'])){
  studentUpdate();
}

function studentUpdate(){
  $conn = dbConn();
	$studentId 			= $_POST['student_id'];
	$firstname 			= $_POST['student_firstname'];
	$lastname 			= $_POST['student_lastname'];
	$middlename 		= $_POST['student_middlename'];
	$contact 			= $_POST['student_contactnumber'];
	
	$sql = "UPDATE `student` SET `student_first_name` = '$firstname' , `student_middle_name` = '$middlename', `student_last_name` = '$lastname' , `student_contactnumber` = '$contact' WHERE `student_id`= '$studentId' ";

  $result = mysqli_query($conn, $sql);

	if($result){
		$str="Updated Student Information";
		header("Location:../views/admin/student.php?s=".$str);
		}else{
		header("Location:../views/admin/student.php?f=".$str);
		}
}


?>