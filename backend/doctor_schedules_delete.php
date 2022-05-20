<?php

require("dbconn.php");

//fetch data for subject using update,delete and view
if(isset($_GET['sched_id'])){
  deleteDoctorSchedules();
}

function deleteDoctorSchedules() {

   $conn = dbConn();	
   $sched_id = $_GET['sched_id'];

   $sqlDelete = "DELETE FROM doctor_schedule WHERE schedule_id = '$sched_id' ";
   $resultDelete = mysqli_query($conn,$sqlDelete);

   $sqlDeleteTime = "DELETE FROM doctor_schedule_time WHERE schedule_id = '$sched_id' ";
   $resultDeleteTime = mysqli_query($conn,$sqlDeleteTime);

	if($resultDelete AND $resultDeleteTime){
		 $alert="Successfully Deleted Schedule";
			header("Location:../views/doctor/schedules.php?s=".$alert);
		}else{
		 $alert="Error Delete Doctor Schedule";
		 	header("Location:../views/doctor/schedules.php?f=".$alert);
		}
}


?>