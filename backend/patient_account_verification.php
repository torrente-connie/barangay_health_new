<?php

require("dbconn.php");


// add new schedules for doctor

if(isset($_POST['accountVerification'])) {
	accountVerification();
}


function accountVerification() {
	$conn = dbConn();

	$patient_id = $_POST['patient_id'];
	$verification_code = $_POST['verification_code'];

	$sqlVerify = "SELECT * FROM user WHERE user_id = '$patient_id' ";
	$resultVerify = mysqli_query($conn,$sqlVerify);
	$rowVerify = mysqli_fetch_assoc($resultVerify);

	$match_code = $rowVerify['user_account_code'];

	if($verification_code == $match_code) {

	$sql = "UPDATE user SET user_account_status = 1 WHERE user_id = '$patient_id' ";
	$result = mysqli_query($conn,$sql);

	if($result){
		 $last_id = mysqli_insert_id($conn);
		 //$alert="Added New Account";
			header("Location:../views/patient/show_profile.php?s=".$alert);
		}else{
		 $alert="Error";
			header("Location:../login.php?s=".$alert);
		}
	} else {
		$alert = "Error Wrong Verification Code";
			var_dump($conn);
			//header("Location:../views/patient/dashboard.php?s=".$alert);
	}
 }





?>