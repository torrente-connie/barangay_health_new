<?php


  error_reporting(1); 
  
  // session info here
  session_start();

  $doctor_id = $_SESSION['doctor_id']; // get session doctor id
  $doctor_fullname = $_SESSION['doctor_fullname']; // get session doctor fullname
  $doctor_image = $_SESSION['doctor_image'];

  if($_SESSION['doctor_image'] == '') {
    $doctor_image = "../../assets/img/avatar/avatar-1.png";
  } else {
    $doctor_image = $doctor_image;
  }


  // header links here
  require("scripts_header.php");

  // db connection
  require("../../backend/dbconn.php");
  $connection = dbConn();

?>
<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">
      <div class="navbar-bg" style="background-color:rgba(40, 102, 199, 0.97)"></div>
      <nav class="navbar navbar-expand-lg main-navbar" style="background-color:rgba(40, 102, 199, 0.97)">
        <a href="dashboard.php" class="navbar-brand sidebar-gone-hide text-capitalize"><img class="sidebar-gone-hide" src="../../assets/img/bh-logo-2.png">
        </a>
        <img class="sidebar-gone-hide rounded-circle" src="../../assets/img/liloan-logo-2.png" style="height: 85px; width: 90px; padding:10px;">
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

            // notification here
            require("show_notification.php");
          
            // profile dropdown here
            require("show_listdropdown.php"); 

// code here

          $get_time_interval = $_GET['ti'];
          $get_sched_id =  $_GET['sched_id'];

          // sql query to display the doctor schedule; 

          $sqlDoctorSchedule = "SELECT * FROM doctor_schedule WHERE schedule_id = '$get_sched_id' ";
          $result = mysqli_query($connection,$sqlDoctorSchedule);

          while($row = mysqli_fetch_assoc($result)) {
             $get_startime = $row['schedule_start_time'];
             $get_endtime = $row['schedule_end_time'];
          }


    
          // interval can be place as $interval = "15 mins"  
          // interval options 15, 30, 45 and 60                  
          function create_time_range($start, $end, $interval, $format = '12') {
              $startTime = strtotime($start); 
              $endTime   = strtotime($end);
              $returnTimeFormat = ($format == '24')?'g:i:s A':'G:i:s';

              $current   = time(); 
              $addTime   = strtotime('+'.$interval, $current); 
              $diff      = $addTime - $current;

              $times = array(); 
              while ($startTime < $endTime) { 
                  $times[] = date($returnTimeFormat, $startTime); 
                  $startTime += $diff; 
              } 
              $times[] = date($returnTimeFormat, $startTime); 
              return $times; 
          }


          $display_time_interval = $get_time_interval.' '."mins";
          $display_start_time = $get_startime; 
          $display_end_time = $get_endtime;

    
          // create array of time ranges 
          $times = create_time_range($display_start_time, $display_end_time, $display_time_interval);

           ?>

        </ul>
      </nav>

      <nav class="navbar navbar-secondary navbar-expand-lg">
        <div class="container">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="dashboard.php" class="nav-link"><i class="fas fa-columns"></i><span>Dashboard</span></a>
            </li>
          
             <li class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="fas fa-calendar-check"></i>
                  <span>Manage Appointments</span>
                </a>
                  <ul class="dropdown-menu" style="display: none;">
                      <li class="nav-item"><a href="appointments_book.php" class="nav-link" style="padding-right:0 !important"> <span>Face to Face Appointment</span> </a></li>
                      <li class="nav-item"><a href="appointments_oc.php" class="nav-link"> <span>Virtual Consultation</span> </a></li>
                    </ul>
                </li>

               <li class="nav-item">
                   <a href="online_consultation.php" class="nav-link"><i class="fas fa-notes-medical"></i><span>Virtual Consultation</span></a>
               </li>

            <li class="nav-item">
              <a href="patients.php" class="nav-link"><i class="fas fa-user-friends"></i><span>Manage Patients</span></a>
            </li>

            

            <li class="nav-item active">
              <a href="schedules.php" class="nav-link"><i class="fas fa-clock"></i><span>Schedules</span></a>
            </li>

          </ul>
        </div>
      </nav>

        <!-- Main Content -->
      <div class="main-content" style="min-height: 566px;">
        <section class="section">
          <div class="section-header">
            <h1>Add Time Schedules</h1>
          
          </div>
          <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <form method="POST" action="../../backend/doctor_schedules_time.php">
                   <div class="card-header">
                 <h4></h4>
              </div>
                    <div class="card-body">

                      <input type="hidden" value="<?php echo $get_sched_id ?>" name="scheduleID">

                       <input type="hidden" value="<?php echo $get_time_interval ?>" name="timeInterval">

                          <div class="row">
                            <div class="form-group col-md-4 col-12">

                              <label>Start Time</label>
                                <select class="form-control" name="time_start">
                                   <option hidden selected>Select End Time</option> 
                                <?php 

                                foreach($times as $key=>$val)  { 

                                // this display the time into AM / PM format          
                                require("show_display_time_format.php");

                                       
                                ?> 

                               <option value="<?php echo $val; ?>"><?php echo $display_val; ?></option>

                                <?php } ?>
                              </select>
                            </div>

                             <div class="form-group col-md-4 col-12">
                              <label>End Time</label>
                                 <select class="form-control" name="time_end">
                                    <option hidden selected>Select End Time</option> 
                              <?php 

                              foreach($times as $key=>$val)  { 

                              // this display the time into AM / PM format          
                              require("show_display_time_format.php");

                                     
                              ?> 

                             <option value="<?php echo $val; ?>"><?php echo $display_val; ?></option>

                              <?php } ?>

                             </select>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-left">
                      <button name="addDoctorSchedTimeSubmit" class="btn btn-primary">Submit</button>
                      <a href="schedule_time.php?sched_id=<?php echo $get_sched_id ?>&ti=<?php echo $get_time_interval ?>" class="btn btn-danger"> Cancel </a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

     
        </section>
      </div>
    </div>


    
  
      <!-- <footer class="main-footer" style="background-color:rgba(40, 102, 199, 0.97)">
        <div class="container">
        <div class="footer-left text-white">
          © 2021 BRGYHEALTH: Barangay Health Center Appointment, Scheduling and Online Consultation System
        </div> 
      </div>
      </footer> -->

    </div>


   <!-- Menu for Footer Links -->
    <?php require("scripts_footer.php"); ?>
    <!-- -->


  </body>
</html>