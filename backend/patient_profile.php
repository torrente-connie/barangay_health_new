<?php

require("dbconn.php");

if(isset($_POST['editPatientProfile'])) {
	editPatientProfile();
}


function editPatientProfile() {
  $conn 	= dbConn();
  $id 		= $_POST['user_id'];
  $fname 	= $_POST['firstname'];
  $mname 	= $_POST['middlename'];
  $lname 	= $_POST['lastname'];
  $email	= $_POST['email'];
  $phone	= $_POST['phone'];

  // for image
  $file = "";
  $maxsize = 5242880; // 5MB
  $date = date("Y-m-d");
  if(isset($_FILES['profile_image'])) {
    if($_FILES['profile_image']['type'] == "image/png" || $_FILES['profile_image']['type'] == "image/jpeg") {
      if($_FILES['profile_image']['type'] == "image/png" || $_FILES['profile_image']['type'] == "image/jpeg") {
        if($_FILES['profile_image']['type'] < $maxsize) {
          $file = "../assets/img/profile_pictures/" .$date."_".$_FILES['profile_image']['name'];
              move_uploaded_file($_FILES['profile_image']['tmp_name'], $file);  
               $display_files = $file;                 
                 }
               }
             }
           }
  // end of image

  // check image if empty 
  if($display_files == "") {
    $display_files = $_POST['account_image'];
  }


  $sql = "UPDATE user SET `user_firstname` = '$fname', `user_middlename` = '$mname', `user_lastname` = '$lname', `user_cnum` = '$phone', `user_email` = '$email', `user_image` = '$display_files' WHERE `user_id` = '$id' ";
  $result = mysqli_query($conn,$sql);

  if($result){
	$alert="Added New Schedule";
		header("Location:../views/patient/show_profile.php?s=".$alert);
	  }else{
	$alert="Error";
		header("Location:../views/patient/show_profile.php?s=".$alert);
	   }


}




?>