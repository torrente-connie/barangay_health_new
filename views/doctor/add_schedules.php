<?php 
  
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


            // require("show_time_array.php");

             $get = "add_time_array";

             if($get == "add_time_array") {
                      $time = array(
                                   "00:00" => "12:00 AM", 
                                   "01:00" => "1:00 AM", 
                                   "02:00" => "2:00 AM", 
                                   "03:00" => "3:00 AM", 
                                   "04:00" => "4:00 AM", 
                                   "05:00" => "5:00 AM", 
                                   "06:00" => "6:00 AM", 
                                   "07:00" => "7:00 AM", 
                                   "08:00" => "8:00 AM", 
                                   "09:00" => "9:00 AM", 
                                   "10:00" => "10:00 AM", 
                                   "11:00" => "11:00 AM", 
                                   "12:00" => "12:00 PM", 
                                   "13:00" => "1:00 PM", 
                                   "14:00" => "2:00 PM", 
                                   "15:00" => "3:00 PM", 
                                   "16:00" => "4:00 PM", 
                                   "17:00" => "5:00 PM", 
                                   "18:00" => "6:00 PM", 
                                   "19:00" => "7:00 PM", 
                                   "20:00" => "8:00 PM", 
                                   "21:00" => "9:00 PM", 
                                   "22:00" => "10:00 PM", 
                                   "23:00" => "11:00 PM", 
                                   "24:00" => "12:00 PM",
                           );
                    }
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
            <h1>Add Doctor Schedule</h1>
          
          </div>
          <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <form method="POST" action="../../backend/doctor_schedules.php">
                   <div class="card-header">
                 <h4></h4>
              </div>
                    <div class="card-body">

                      <input type="hidden" value="<?php echo $doctor_id ?>" name="doctorID">

                        <div class="row">
                          <div class="form-group col-md-6 col-12">
                            <label>Day</label>
                              <select class="form-control" name="sched_day" required>
                                <option hidden selected value="">Select A Day</option>
                                <option value="0">Sunday</option>
                                <option value="1">Monday</option>
                                <option value="2">Tuesday</option>
                                <option value="3">Wednesday</option>
                                <option value="4">Thursday</option>
                                <option value="5">Friday</option>
                                <option value="6">Saturday</option>
                              </select>
                          </div>  
                        </div>
                          <div class="row">
                            <div class="form-group col-md-4 col-12">
                              <label>Start Time</label>
                              <select class="form-control" name="sched_start">
                                <option hidden selected>Select Start Time</option>
                                <?php 

                                foreach($time AS $timeValue => $rowStartTime) {

                                ?>
                                <option value="<?php echo $timeValue ?>"><?php echo $rowStartTime ?></option>
                                <?php } ?>
                              </select>
                            </div>
                             <div class="form-group col-md-4 col-12">
                              <label>End Time</label>
                              <select class="form-control" name="sched_end">
                                <option hidden selected>Select End Time</option>
                                <?php 

                                foreach($time AS $timeValue => $rowEndTime) {

                                ?>
                                <option value="<?php echo $timeValue ?>"><?php echo $rowEndTime ?></option>
                                <?php } ?>
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-left">
                      <button name="addDoctorSchedSubmit" class="btn btn-primary">Submit</button>
                      <a href="schedules.php" class="btn btn-danger">Cancel</a>
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