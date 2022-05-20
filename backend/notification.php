<?php

require('dbconn.php');

$con = dbConn();

if(isset($_POST['view'])) {

  $session_id = $_POST['session_id']; 

  if(empty($session_id)) {
    $display_session = 0;
  } else {
    $display_session = $session_id;
  }

  $session_login = $_POST['session_login'];

// notifications view for barangay health worker
 if($session_login == 'bhw') { 

  if($_POST["view"] != '')
  {

   $session_id = $_POST['session_id'];
   $update_query = "UPDATE notification SET notification_status = '1' 
   WHERE notification_status = '0' AND notification_usertype = 'bhw' OR notification_bhw_id = '$display_session'
   ";
   mysqli_query($con, $update_query);
  }

$query = "SELECT * FROM notification 
WHERE notification_usertype = 'bhw' OR notification_bhw_id = '$display_session'
ORDER BY notification_id DESC LIMIT 5 ";
$result = mysqli_query($con, $query);

$output = '';

if(mysqli_num_rows($result) > 0)

{

while($row = mysqli_fetch_array($result))
{
  $datetime_format = date('m/d/Y h:i A',strtotime($row['notification_datetime']));

  $output .= '
  <a href="#" class="dropdown-item">
    <div class="dropdown-item-icon bg-info text-white">
      <i class="fas fa-bell" style="padding:12px;"></i>
    </div>
 <div class="dropdown-item-desc">
     <b>'.$row["notification_message"].'
     <div class="time text-primary">'.$datetime_format.'</div>
    </div>
  </a>
  ';
  }
} else {
    $output .= '<a href="#" class="dropdown-item">
    <div class="dropdown-item-icon bg-info text-white">
      <i class="fas fa-bell" style="padding:12px;"></i>
    </div>
 <div class="dropdown-item-desc">
     <b> You have no notifications available
    </div>
  </a>';
}

$status_query = "SELECT * FROM notification 
WHERE notification_status = 0 AND (notification_usertype = 'bhw' OR notification_bhw_id = '$display_session')
ORDER BY notification_id DESC LIMIT 5
";
$result_query = mysqli_query($con, $status_query);
$count = mysqli_num_rows($result_query);

$data = array(
   'notification' => $output,
   'unseen_notification'  => $count
);
  echo json_encode($data);
 

// notifications view for patient
 } elseif ($session_login == 'patient') {

  if($_POST["view"] != '')

  {

   $session_id = $_POST['session_id'];

    if(empty($session_id)) {
      $display_session = 0;
    } else {
      $display_session = $session_id;
    }

   $update_query = "UPDATE notification SET notification_status = '1' 
   WHERE notification_status = '0' 
   AND notification_patient_id = '$display_session'
   OR notification_usertype = 'patient'  
   ";
   mysqli_query($con, $update_query);
  }

$query = "SELECT * FROM notification 
WHERE notification_patient_id = '$display_session' 
OR notification_usertype = 'patient'
ORDER BY notification_id DESC LIMIT 5 ";
$result = mysqli_query($con, $query);
$output = '';

if(mysqli_num_rows($result) > 0)
{

while($row = mysqli_fetch_array($result))
{
  $datetime_format = date('m/d/Y h:i A',strtotime($row['notification_datetime']));

  $output .= '
  <a href="#" class="dropdown-item">
    <div class="dropdown-item-icon bg-info text-white">
      <i class="fas fa-bell" style="padding:12px;"></i>
    </div>
 <div class="dropdown-item-desc">
     <b>'.$row["notification_message"].'
     <div class="time text-primary">'.$datetime_format.'</div>
    </div>
  </a>
  ';
  }
} else {
    $output .= '<a href="#" class="dropdown-item">
    <div class="dropdown-item-icon bg-info text-white">
      <i class="fas fa-bell" style="padding:12px;"></i>
    </div>
 <div class="dropdown-item-desc">
     <b> You have no notifications available
    </div>
  </a>';
}

$status_query = "SELECT * FROM notification 
WHERE notification_status = 0 AND (notification_usertype = 'patient' OR notification_patient_id = '$display_session')
";
$result_query = mysqli_query($con, $status_query);
$count = mysqli_num_rows($result_query);

$data = array(
   'notification' => $output,
   'unseen_notification'  => $count
);
  echo json_encode($data);
 
// notifications view for doctor
} elseif ($session_login == 'doctor') {

  if($_POST["view"] != '')
  {
   
   $session_id = $_POST['session_id'];

    if(empty($session_id)) {
      $display_session = 0;
    } else {
      $display_session = $session_id;
    }

   $update_query = "UPDATE notification SET notification_status = '1' 
   WHERE notification_status = '0' 
   AND notification_doctor_id = '$display_session'  
   OR notification_usertype = 'doctor'
   ";
   mysqli_query($con, $update_query);
  }

$query = "SELECT * FROM notification 
WHERE notification_doctor_id = '$display_session' 
OR notification_usertype = 'doctor'
ORDER BY notification_id DESC LIMIT 5 ";
$result = mysqli_query($con, $query);
$output = '';

if(mysqli_num_rows($result) > 0)
{

while($row = mysqli_fetch_array($result))
{
  $datetime_format = date('m/d/Y h:i A',strtotime($row['notification_datetime']));

  $output .= '
  <a href="#" class="dropdown-item">
    <div class="dropdown-item-icon bg-info text-white">
      <i class="fas fa-bell" style="padding:12px;"></i>
    </div>
 <div class="dropdown-item-desc">
     <b>'.$row["notification_message"].'
     <div class="time text-primary">'.$datetime_format.'</div>
    </div>
  </a>
  ';
  }
} else {
    $output .= '<a href="#" class="dropdown-item">
    <div class="dropdown-item-icon bg-info text-white">
      <i class="fas fa-bell" style="padding:12px;"></i>
    </div>
 <div class="dropdown-item-desc">
     <b> You have no notifications available
    </div>
  </a>';
}

$status_query = "SELECT * FROM notification 
WHERE notification_status = 0 AND (notification_doctor_id = '$display_session' OR notification_usertype = 'doctor')
";
$result_query = mysqli_query($con, $status_query);
$count = mysqli_num_rows($result_query);

$data = array(
   'notification' => $output,
   'unseen_notification'  => $count
);
  echo json_encode($data);
 
 } else if($session_login == 'admin') {
    if($_POST["view"] != '') {
     $session_id = $_POST['session_id'];

      if(empty($session_id)) {
      $display_session = 0;
    } else {
      $display_session = $session_id;
    }

     $update_query = "UPDATE notification SET notification_status = '1' 
     WHERE notification_status = '0' AND notification_usertype = 'admin'
     ";
     mysqli_query($con, $update_query);
   }

   $query = "SELECT * FROM notification 
   WHERE  notification_usertype = 'admin'
   ORDER BY notification_id DESC LIMIT 5 ";
   $result = mysqli_query($con, $query);
   $output = '';

   if(mysqli_num_rows($result) > 0)
    {

    while($row = mysqli_fetch_array($result))
    {
      $datetime_format = date('m/d/Y h:i A',strtotime($row['notification_datetime']));

      $output .= '
      <a href="#" class="dropdown-item">
        <div class="dropdown-item-icon bg-info text-white">
          <i class="fas fa-bell" style="padding:12px;"></i>
        </div>
     <div class="dropdown-item-desc">
         <b>'.$row["notification_message"].'
         <div class="time text-primary">'.$datetime_format.'</div>
        </div>
      </a>
      ';
      }
    } else {
        $output .= '<a href="#" class="dropdown-item">
        <div class="dropdown-item-icon bg-info text-white">
          <i class="fas fa-bell" style="padding:12px;"></i>
        </div>
     <div class="dropdown-item-desc">
         <b> You have no notifications available
        </div>
      </a>';
    }

    $status_query = "SELECT * FROM notification 
    WHERE notification_status = 0 AND (notification_usertype = 'admin' OR notification_admin_id = '$display_session')
    ";
    $result_query = mysqli_query($con, $status_query);
    $count = mysqli_num_rows($result_query);

    $data = array(
       'notification' => $output,
       'unseen_notification'  => $count
    );
      echo json_encode($data);


 }

}


?>