<?php

require("dbconn.php");


// code for add new doctor

if(isset($_POST['addDoctorSubmitBtn'])) {
	addDoctor();
}

function addDoctor() {
	$conn = dbConn();
	
	// info from form
	$doc_fname = $_POST['doctor_firstname'];
	$doc_mname = $_POST['doctor_middlename'];
	$doc_lname = $_POST['doctor_lastname'];
	$doc_email = $_POST['doctor_email'];
	$doc_pnum = $_POST['doctor_phonenumber'];
	$doc_dob = $_POST['doctor_dob'];


    // user type,status and bool 
    $doc_type = 'Doctor';
    $doc_status = 1;
    $doc_bool = 1;

    // add default image;
    $doc_default_image = '../assets/img/user.png';


	// get unique id number, username and password 
	$getUniqueSql = "SELECT COUNT(*) FROM user 
	WHERE user_type = 'Doctor' ";
	$getUniqueResult = mysqli_query($conn,$getUniqueSql);
	$displayUnique = mysqli_fetch_array($getUniqueResult);
	$getUniqueYear = date("Y");
	$getUniqueAccNum = '068';
	$doc_uname = 'BH'.''.$getUniqueYear.''.$getUniqueAccNum.''.$displayUnique[0];
	$doc_pass = md5($doc_email);

    $sql = "INSERT INTO user (user_id,user_account_id,user_email,user_password,user_firstname,user_middlename,user_lastname,user_dob,user_cnum,user_type,user_image,user_status,user_bool) VALUES
	(NULL,'$doc_uname','$doc_email','$doc_pass','$doc_fname','$doc_mname','$doc_lname','$doc_dob','$doc_pnum','$doc_type','$doc_default_image','$doc_status','$doc_bool')";

	$result = mysqli_query($conn,$sql);

	if($result){
		 $alert="Added New Doctor";
			header("Location:../views/admin/accounts_doctor.php?s=".$alert);
		}else{
		 $alert="Error Cannot Add This Doctor";
			header("Location:../views/admin/accounts_doctor.php?f=".$alert);
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