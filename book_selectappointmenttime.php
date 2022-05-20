<?php 

require("backend/dbconn.php");

$connection = dbConn();

if(isset($_POST['dayOfWeek'])) {
  $appointment_docid = $_POST['appointmentID'];
  $dayOfWeek = $_POST['dayOfWeek'];

  $sqlSched = "SELECT * FROM doctor_schedule WHERE doctor_id = '$appointment_docid' AND schedule_day = '$dayOfWeek' ";
  $result1 = mysqli_query($connection,$sqlSched);
  $output = "";

  $output = '';                          
  while($row2 = mysqli_fetch_assoc($result1)) {

  $schedule_id = $row2['schedule_id'];

  }

  $getScheduleID = $schedule_id;
  $sqlTimeSched = "SELECT * FROM doctor_schedule_time WHERE schedule_id = '$getScheduleID' ";
  $result2 = mysqli_query($connection,$sqlTimeSched);
  while($row3 = mysqli_fetch_assoc($result2)) {

    $fnl_schedule_time_id = $row3['schedule_time_id'];

    $fnl_start_time = $row3['schedule_start_time'];
    $fnl_end_time = $row3['schedule_end_time'];

    $fnl_format_start = date("h:i:A", strtotime($fnl_start_time));
    $fnl_format_end   = date("h:i:A", strtotime($fnl_end_time));

    echo "<option value=".$fnl_schedule_time_id.">".$fnl_format_start." to ".$fnl_format_end." </option>" ;

      $data = array(
       'option' => $output
      );

  echo json_encode($data);

  }

}

?>