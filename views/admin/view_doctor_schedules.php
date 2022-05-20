<?php 
  
  // session info here
  session_start();

  $admin_id = $_SESSION['admin_id']; // get session admin id
  $admin_fullname = $_SESSION['admin_fullname']; // get session admin fullname
  $admin_image = $_SESSION['admin_image'];

   if($_SESSION['admin_image'] == '') {
    $admin_image = "../../assets/img/avatar/avatar-1.png";
  } else {
    $admin_image = $admin_image;
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


            // patient information 
            $doctor_id = $_GET['did'];

            $sql = "SELECT * FROM user WHERE user_id = '$doctor_id' ";
            $result = mysqli_query($connection,$sql);

            while($row = mysqli_fetch_assoc($result)) {
              $account_id = $row['user_account_id'];
              $account_type = $row['user_type'];

               // user full name
               $firstname    = ucfirst($row['user_firstname']);
               $middlename   = ucfirst($row['user_middlename']);
               $lastname     = ucfirst($row['user_lastname']);

               $fullname = $firstname.' '.$middlename[0].'.'.' '.$lastname;

               // user info
               $email = $row['user_email'];
               $phonenumber = $row['user_cnum'];

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
                    <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="fas fa-user-friends"></i><span>Accounts</span></a>
                    <ul class="dropdown-menu" style="display: none;">
                      <li class="nav-item"><a href="accounts_patient.php" class="nav-link"> <span>Patient</span> </a></li>
                      <li class="nav-item"><a href="accounts_doctor.php" class="nav-link"> <span>Doctor</span> </a></li>
                      <li class="nav-item"><a href="accounts_bhw.php" class="nav-link"> <span>Barangay Health Worker</span> </a></li>
                    </ul>
                </li>

         <!--  <li class="nav-item">
              <a href="activity_logs.php" class="nav-link"><i class="fas fa-clipboard-list"></i><span>Activity Logs</span></a>
             </li> -->

             <li class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="fas fa-calendar-check"></i>
                  <span>Appointments</span>
                </a>
                  <ul class="dropdown-menu" style="display: none;">
                      <li class="nav-item"><a href="appointments_book.php" class="nav-link" style="padding-right:0 !important"> <span>Face to Face Appointment</span> </a></li>
                      <li class="nav-item"><a href="appointments_oc.php" class="nav-link"> <span>Virtual Consultation</span> </a></li>
                      <li class="nav-item"><a href="appointments_walk_in.php" class="nav-link"> <span>Walk-in Appointment</span> </a></li>
                    </ul>
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
            <h1>Schedules</h1>
            </div>

   
        <div class="section-body">
            <div class="card">
              <div class="card-header">
                 <h4></h4>
                   <div class="card-header-action">
                    <a href="schedules.php" class="btn btn-danger btn-sm">Return</a>
                  </div>
               </div>

                <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th>Available Day</th>
                          <th>Available Time</th>
                          <!-- <th>Status</th> -->
                        </tr>

                      <?php 

                      // query for getting doctor schedules
                      $sqlDoctorSched = "SELECT * FROM doctor_schedule ds
                      JOIN user u 
                      ON ds.doctor_id = u.user_id 
                      WHERE u.user_bool = '1' AND u.user_type = 'Doctor' AND 
                      ds.doctor_id = '$doctor_id' ORDER BY ds.schedule_day ASC
                      ";

                      $resultDoctorSched = mysqli_query($connection,$sqlDoctorSched);
                      while($rowDoctorSched = mysqli_fetch_assoc($resultDoctorSched)) {

                        // doctor account id
                        $account_id   = $rowDoctorSched['user_account_id'];

                        // doctor full name
                        $firstname    = ucfirst($rowDoctorSched['user_firstname']);
                        $middlename   = ucfirst($rowDoctorSched['user_middlename']);
                        $lastname     = ucfirst($rowDoctorSched['user_lastname']);

                        $fullname = $firstname.' '.$middlename[0].'.'.' '.$lastname;

                          

                        // doctor schedule
                        $sched_day    = $rowDoctorSched['schedule_day'];
                        $sched_start  = $rowDoctorSched['schedule_start_time']; 
                        $sched_end    = $rowDoctorSched['schedule_end_time'];

                        $format_start = date("h:i:A", strtotime($sched_start));
                        $format_end   = date("h:i:A", strtotime($sched_end));

                         if($sched_day == 0) {
                          $display_day = "Sunday";
                        } else if($sched_day == 1) {
                          $display_day = "Monday";
                        } else if($sched_day == 2) {
                          $display_day = "Tuesday";
                        } else if($sched_day == 3) {
                          $display_day = "Wednesday";
                        } else if($sched_day == 4) {
                          $display_day = "Thursday";
                        } else if($sched_day == 5) {
                          $display_day = "Friday";
                        } else if($sched_day == 6) {
                          $display_day = "Saturday";
                        } 


                      ?>   
                      <tr>
                        <td><?php echo $display_day ?></td>
                        <td><?php echo $format_start ?> - <?php echo $format_end ?> </td>
                      </tr>

                      <?php 
                          }
                        ?>

                        </tbody>
                      </table>                    
                    </div>
                  </div>
              <div class="card-footer bg-whitesmoke"> </div>
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