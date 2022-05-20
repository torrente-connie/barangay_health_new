<?php 
  
  require("scripts_header.php");

  // db connection
  require("backend/dbconn.php");
  $connection = dbConn();

$sql = "SELECT 
        d.user_account_id as doctor_account,
        d.user_firstname  as doc_fname, 
        d.user_middlename as doc_mname, 
        d.user_lastname   as doc_lname,
        p.user_firstname  as patient_fname,
        p.user_middlename as patient_mname,
        p.user_lastname   as patient_lname,
        p.user_account_id as patient_account,
        a.appointment_id as appointment_id,
        a.appointment_patient_fname as appoint_pfname,
        a.appointment_patient_mname as appoint_pmname,
        a.appointment_patient_lname as appoint_plname,
        a.appointment_patient_email as appoint_pemail,
        a.appointment_patient_pnum as appoint_ppnum,
        a.appointment_selected_date as appoint_date,
        a.appointment_selected_time as appoint_dst_id, 
        dst.schedule_start_time as appoint_start_time,
        dst.schedule_end_time as appoint_end_time,
        a.appointment_selected_service as appoint_service,
        a.appointment_type as appointment_type,
        a.appointment_status as appointment_status,
        a.appointment_reason as appointment_reason
        FROM appointment a
        JOIN user d 
        ON a.appointment_doctor_id = d.user_id 
        LEFT JOIN user p 
        ON a.appointment_patient_id = p.user_id 
        JOIN doctor_schedule_time dst 
        ON a.appointment_selected_time = dst.schedule_time_id";
$result = mysqli_query($connection,$sql);
$getRow = mysqli_fetch_assoc($result);

$data  = array();
$i=0;

  foreach($result as $row) {

    $status = $row['appointment_status'];

    $patient_pfname = $row['appoint_pfname'];
    $patient_pmname = $row['appoint_pmname'];
    $patient_plname = $row['appoint_plname'];

    $patient_pfullname = $patient_pfname.' '.$patient_pmname.'. '.$patient_plname;

    $doctor_pfname = $row['doc_fname'];
    $doctor_pmname = $row['doc_mname'];
    $doctor_plname = $row['doc_lname'];

    $doctor_pfullname = $doctor_pfname.' '.$doctor_pmname.'. '.$doctor_plname;

  
    // check if status is pending
    if($status == 1) {
      $date = $row['appoint_date'];
      $start_time = $row['appoint_start_time'];
      $end_time = $row['appoint_end_time'];

      // $data[$i]['title'] = $row['patient_fname'] . ' - ' . $row['appoint_service'] .' (Pending)';
      //$data[$i]['title'] = $patient_pfullname . ' - ' . $row['appoint_service'];
      $data[$i]['title'] = $row['appoint_service'];
      $data[$i]['start'] =  date('Y-m-d H:i:s', strtotime("$date $start_time"));
      $data[$i]['end'] =  date('Y-m-d H:i:s', strtotime("$date $end_time"));
      $data[$i]['color'] =  '#6777ef';
      $data[$i]['textColor'] = 'white';
      $i++;

    // check if status is reschedule
    } else if($status == 2) {
      $date = $row['appoint_date'];
      $start_time = $row['appoint_start_time'];
      $end_time = $row['appoint_end_time'];

      //$data[$i]['title'] = $patient_pfullname . ' - ' . $row['appoint_service'];
      $data[$i]['title'] = $row['appoint_service'];
      $data[$i]['start'] =  date('Y-m-d H:i:s', strtotime("$date $start_time"));
      $data[$i]['end'] =  date('Y-m-d H:i:s', strtotime("$date $end_time"));
      $data[$i]['color'] =  '#fc544b';
      $data[$i]['textColor'] = 'white';
      $i++;

    // check if status accepted
    } else if($status == 3) {
      $date = $row['appoint_date'];
      $start_time = $row['appoint_start_time'];
      $end_time = $row['appoint_end_time'];

      //$data[$i]['title'] = $patient_pfullname . ' - ' . $row['appoint_service'];
      $data[$i]['title'] = $row['appoint_service'];
      $data[$i]['start'] =  date('Y-m-d H:i:s', strtotime("$date $start_time"));
      $data[$i]['end'] =  date('Y-m-d H:i:s', strtotime("$date $end_time"));
      $data[$i]['color'] =  '#3abaf4';
      $data[$i]['textColor'] = 'white';
      $i++;

    // check if status approved
    } else if($status == 4) {
      $date = $row['appoint_date'];
      $start_time = $row['appoint_start_time'];
      $end_time = $row['appoint_end_time'];

      //$data[$i]['title'] = $patient_pfullname . ' - ' . $row['appoint_service'];
      $data[$i]['title'] = $row['appoint_service'];
      $data[$i]['start'] =  date('Y-m-d H:i:s', strtotime("$date $start_time"));
      $data[$i]['end'] =  date('Y-m-d H:i:s', strtotime("$date $end_time"));
      $data[$i]['color'] =  '#47c363';
      $data[$i]['textColor'] = 'white';
      $i++;

    // check if status reschedule
    } else if($status == 5) {
      $date = $row['appoint_date'];
      $start_time = $row['appoint_start_time'];
      $end_time = $row['appoint_end_time'];

      //$data[$i]['title'] = $patient_pfullname . ' - ' . $row['appoint_service'];
      $data[$i]['title'] = $row['appoint_service'];
      $data[$i]['start'] =  date('Y-m-d H:i:s', strtotime("$date $start_time"));
      $data[$i]['end'] =  date('Y-m-d H:i:s', strtotime("$date $end_time"));
      $data[$i]['color'] =  '#fc544b';
      $data[$i]['textColor'] = 'white';
      $i++;

    // check if status confirmed
    } else if($status == 6) {
      $date = $row['appoint_date'];
      $start_time = $row['appoint_start_time'];
      $end_time = $row['appoint_end_time'];

      //$data[$i]['title'] = $patient_pfullname . ' - ' . $row['appoint_service'];
      $data[$i]['title'] = $row['appoint_service'];
      $data[$i]['start'] =  date('Y-m-d H:i:s', strtotime("$date $start_time"));
      $data[$i]['end'] =  date('Y-m-d H:i:s', strtotime("$date $end_time"));
      $data[$i]['color'] =  '#6777ef';
      $data[$i]['textColor'] = 'white';
      $i++;

    // check if status confirmed
    } else if($status == 7) {
      $date = $row['appoint_date'];
      $start_time = $row['appoint_start_time'];
      $end_time = $row['appoint_end_time'];

      //$data[$i]['title'] = $patient_pfullname . ' - ' . $row['appoint_service'];
      $data[$i]['title'] = $row['appoint_service'];
      $data[$i]['start'] =  date('Y-m-d H:i:s', strtotime("$date $start_time"));
      $data[$i]['end'] =  date('Y-m-d H:i:s', strtotime("$date $end_time"));
      $data[$i]['color'] =  '#6777ef';
      $data[$i]['textColor'] = 'white';
      $i++;

    // check if status no-show
    } else if($status == 8) {
      $date = $row['appoint_date'];
      $start_time = $row['appoint_start_time'];
      $end_time = $row['appoint_end_time'];

      //$data[$i]['title'] = $patient_pfullname . ' - ' . $row['appoint_service'];
      $data[$i]['title'] = $row['appoint_service'];
      $data[$i]['start'] =  date('Y-m-d H:i:s', strtotime("$date $start_time"));
      $data[$i]['end'] =  date('Y-m-d H:i:s', strtotime("$date $end_time"));
      $data[$i]['color'] =  '#fc544b';
      $data[$i]['textColor'] = 'white';
      $i++;

    // check if status completed
    } else if($status == 0) {
      $date = $row['appoint_date'];
      $start_time = $row['appoint_start_time'];
      $end_time = $row['appoint_end_time'];

      //$data[$i]['title'] = $patient_pfullname . ' - ' . $row['appoint_service'];
      $data[$i]['title'] = $row['appoint_service'];
      $data[$i]['start'] =  date('Y-m-d H:i:s', strtotime("$date $start_time"));
      $data[$i]['end'] =  date('Y-m-d H:i:s', strtotime("$date $end_time"));
      $data[$i]['color'] =  '#47c363';
      $data[$i]['textColor'] = 'white';
      $i++;
    } else if($status == 14) {
      $date = $row['appoint_date'];
      $start_time = $row['appoint_start_time'];
      $end_time = $row['appoint_end_time'];

      //$data[$i]['title'] = $patient_pfullname . ' - ' . $row['appoint_service'];
      $data[$i]['title'] = $row['appoint_service'];
      $data[$i]['start'] =  date('Y-m-d H:i:s', strtotime("$date $start_time"));
      $data[$i]['end'] =  date('Y-m-d H:i:s', strtotime("$date $end_time"));
      $data[$i]['color'] =  '#6777ef';
      $data[$i]['textColor'] = 'white';
      $i++;
    } else if($status == 17) {
      $date = $row['appoint_date'];
      $start_time = $row['appoint_start_time'];
      $end_time = $row['appoint_end_time'];

      //$data[$i]['title'] = $patient_pfullname . ' - ' . $row['appoint_service'];
      $data[$i]['title'] = $row['appoint_service'];
      $data[$i]['start'] =  date('Y-m-d H:i:s', strtotime("$date $start_time"));
      $data[$i]['end'] =  date('Y-m-d H:i:s', strtotime("$date $end_time"));
      $data[$i]['color'] =  '#47c363';
      $data[$i]['textColor'] = 'white';
      $i++;
    }
  }

 $data = json_encode($data);
  
?>

<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">
      <div class="navbar-bg" style="background-color:rgba(40, 102, 199, 0.97)"></div>
      <nav class="navbar navbar-expand-lg main-navbar" style="background-color:rgba(40, 102, 199, 0.97)">
        <a href="home_page.php" class="navbar-brand sidebar-gone-hide text-capitalize"><img class="sidebar-gone-hide" src="assets/img/bh-logo-2.png">
        </a>
        <img class="sidebar-gone-hide rounded-circle" src="assets/img/liloan-logo-2.png" style="height: 85px; width: 90px; padding:10px;">
        <div class="navbar-nav">
          <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
         </div>
      
       <form class="form-inline ml-auto">
          <ul class="navbar-nav">
            <!-- <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li> -->
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">

           <?php 
          
            // profile dropdown here
            require("show_listdropdown.php"); 

          ?>

        
        </ul>
      </nav>

      <nav class="navbar navbar-secondary navbar-expand-lg">
        <div class="container">
          <ul class="navbar-nav">

            <li class="nav-item">
              <a href="home_schedules.php" class="nav-link"><i class="fas fa-clock"></i><span>Schedules</span></a>
            </li>
           
            <li class="nav-item active">
              <a href="home_appointments.php" class="nav-link"><i class="fas fa-calendar-check"></i><span>Appointments</span></a>
            </li>


          </ul>
        </div>
      </nav>

        <!-- Main Content -->
      <div class="main-content" style="min-height: 566px;">
        <section class="section">
          <div class="section-header">
            <h1>Appointment Calendar</h1>
            </div>


        <div class="section-body">
            <div class="card">
            
                <div class="card-body">
                  <div id="calendar">
                    
                  </div>
                </div>

              <div class="card-footer bg-whitesmoke"> </div>
            </div>
          </div>
         </section>
      </div>
    </div>

  
      <footer class="main-footer" style="background-color:rgba(40, 102, 199, 0.97)">
        <div class="container">
        <div class="footer-left text-white">
          © 2021 BRGYHEALTH: Barangay Health Center Appointment, Scheduling and Online Consultation System
        </div> 
      </div>
      </footer>

    </div>

    <div id="calendarModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Event Description</h4>
            </div>
            <div id="modalBody" class="modal-body">
            <h4 id="modalTitle" class="modal-title"></h4>
                <ul class="list-group mt-2">
                      <li class="list-group-item ">
                        Date: <span id="modalShowDate"></span>
                      </li>
                      <li class="list-group-item">
                        Schedule Time: <span id="modalShowTime"></span>
                      </li>
                      </span>
                      </li>
                    </ul>     

               <div class="form-group mt-4">
                  
                    <button class="btn btn-danger" tabindex="4" data-dismiss="modal">
                      Close
                    </button>
                  </div>
        </div>
    </div>
    </div>

   <!-- Menu for Footer Links -->
    <?php require("scripts_footer.php"); ?>
    <!-- -->


  </body>
</html>
