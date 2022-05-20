<?php 
require("dbconn.php");

if(isset($_POST['addDoctorSchedTimeSubmit'])) {
	addDoctorSched();
}


function addDoctorSched() {
	
	$conn 	= dbConn();
	$get_schedule = $_POST['scheduleID'];
	$get_timeinterval = $_POST['timeInterval'];
	$get_start_time = $_POST['time_start'];
	$get_end_time = $_POST['time_end'];
	$get_time_bool = 1;


	$sql = "INSERT INTO doctor_schedule_time (schedule_time_id,schedule_id,schedule_start_time,schedule_end_time,schedule_time_status,schedule_time_bool) VALUES (NULL,'$get_schedule','$get_start_time','$get_end_time','$get_timeinterval','$get_time_bool')";
	$result = mysqli_query($conn,$sql);

	if($result){
		 //$alert="Added New Time Schedule";
			header("Location:../views/doctor/schedule_time.php?sched_id=$get_schedule&ti=$get_timeinterval");
		}else{
		 $alert="Error";
			header("Location:../views/doctor/schedule_time.php?sched_id=$get_schedule&ti=$get_timeinterval&s=".$alert);
		}


}


if(isset($_GET['timeschedID']) && isset($_GET['ti']) && isset($_GET['schedID'])) {
	deleteTimeSched();
}

function deleteTimeSched() {

	$conn = dbConn();

	$sched_id = $_GET['schedID'];
	$timesched_id = $_GET['timeschedID'];
	$time_interval = $_GET['ti'];

	$sql = "DELETE FROM doctor_schedule_time WHERE schedule_time_id = '$timesched_id' ";
	$result = mysqli_query($conn,$sql);

	var_dump($timesched_id);

	var_dump($time_interval);

	if($result) {
		header("Location:../views/doctor/schedule_time.php?sched_id=$sched_id&ti=$time_interval");
	} else {
		header("Location:../views/doctor/schedule_time.php?sched_id=$sched_id&ti=$time_interval");
	}

}





?>