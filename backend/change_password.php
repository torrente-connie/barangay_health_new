<?php 

 require("dbconn.php");
 $connection = dbConn();


// admin accounts
if(isset($_POST['adminChangePasswordSubmit'])) {

	$usertype = 'Administrator';
	
	$admin_id = $_POST['admin_id'];
	$old = md5($_POST['old_password']);
	$new = md5($_POST['new_password']);
 	$confirm = md5($_POST['confirm_new_password']);

    if($new == $confirm){
		$sql = "SELECT * FROM user WHERE user_id ='$admin_id' AND user_password = '$old'  ";
		$result = mysqli_query($connection,$sql);
		$row = mysqli_fetch_row($result);

		$userID = $row[0];
		$oldPass = $row[3];

		if($userID == $admin_id && $oldPass == $old) {
			$sql = "UPDATE user SET user_password = '$new' WHERE user_id = '$admin_id' AND user_type = '$usertype' ";
			$result = mysqli_query($connection,$sql);

			if($result){
				$str = "User Password Successfully Changed";
				header("Location:../views/admin/show_changepassword.php?success=".$str);
			}else{
				echo "ERROR!". mysqli_error($connection);
			}

		}else{
			$str = "Wrong Current Password";
			header("Location:../views/admin/show_changepassword.php?error=".$str);
		}
	}else{
		$str = "Password not match!";
		header("Location:../views/admin/show_changepassword.php?error=".$str);
	}

}

// bhw accounts
if(isset($_POST['bhwChangePasswordSubmit'])) {

	$usertype = 'Barangay Health Worker';
	
	$bhw_id = $_POST['bhw_id'];
	$old = md5($_POST['old_password']);
	$new = md5($_POST['new_password']);
 	$confirm = md5($_POST['confirm_new_password']);

    if($new == $confirm){
		$sql = "SELECT * FROM user WHERE user_id ='$bhw_id' AND user_password = '$old'  ";
		$result = mysqli_query($connection,$sql);
		$row = mysqli_fetch_row($result);

		$userID = $row[0];
		$oldPass = $row[3];

		if($userID == $bhw_id && $oldPass == $old) {
			$sql = "UPDATE user SET user_password = '$new' WHERE user_id = '$bhw_id' AND user_type = '$usertype' ";
			$result = mysqli_query($connection,$sql);

			if($result){
				$str = "User Password Successfully Changed";
				header("Location:../views/bhw/show_changepassword.php?success=".$str);
			}else{
				echo "ERROR!". mysqli_error($connection);
			}

		}else{
			$str = "Wrong Current Password";
			header("Location:../views/bhw/show_changepassword.php?error=".$str);
		}
	}else{
		$str = "Password not match!";
		header("Location:../views/bhw/show_changepassword.php?error=".$str);
	}

}

// doctor accounts
if(isset($_POST['doctorChangePasswordSubmit'])) {

	$usertype = 'Doctor';
	
	$doctor_id = $_POST['doctor_id'];
	$old = md5($_POST['old_password']);
	$new = md5($_POST['new_password']);
 	$confirm = md5($_POST['confirm_new_password']);

    if($new == $confirm) {
		$sql = "SELECT * FROM user WHERE user_id ='$doctor_id' AND user_password = '$old'  ";
		$result = mysqli_query($connection,$sql);
		$row = mysqli_fetch_row($result);

		$userID = $row[0];
		$oldPass = $row[3];

		if($userID == $doctor_id && $oldPass == $old) {
			$sql = "UPDATE user SET user_password = '$new' WHERE user_id = '$doctor_id' AND user_type = '$usertype' ";
			$result = mysqli_query($connection,$sql);

			if($result){
				$str = "User Password Successfully Changed";
				header("Location:../views/doctor/show_changepassword.php?success=".$str);
			}else{
				echo "ERROR!". mysqli_error($connection);
			}

		}else{
			$str = "Wrong Current Password";
			header("Location:../views/doctor/show_changepassword.php?error=".$str);
		}
	}else{
		$str = "Password not match!";
		header("Location:../views/doctor/show_changepassword.php?error=".$str);
	}

}

// patient accounts
if(isset($_POST['patientChangePasswordSubmit'])) {

	$usertype = 'Patient';
	
	$patient_id = $_POST['patient_id'];
	$old = md5($_POST['old_password']);
	$new = md5($_POST['new_password']);
 	$confirm = md5($_POST['confirm_new_password']);

    if($new == $confirm){
		$sql = "SELECT * FROM user WHERE user_id ='$patient_id' AND user_password = '$old'  ";
		$result = mysqli_query($connection,$sql);
		$row = mysqli_fetch_row($result);

		$userID = $row[0];
		$oldPass = $row[3];

		if($userID == $patient_id && $oldPass == $old) {
			$sql = "UPDATE user SET user_password = '$new' WHERE user_id = '$patient_id' AND user_type = '$usertype' ";
			$result = mysqli_query($connection,$sql);

			if($result){
				$str = "User Password Successfully Changed";
				header("Location:../views/patient/show_changepassword.php?success=".$str);
			}else{
				echo "ERROR!". mysqli_error($connection);
			}

		}else{
			$str = "Wrong Current Password";
			header("Location:../views/patient/show_changepassword.php?error=".$str);
		}
	}else{
		$str = "Password not match!";
		header("Location:../views/patient/show_changepassword.php?error=".$str);
	}

}


?>