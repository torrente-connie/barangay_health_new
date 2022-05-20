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

            // code here 

            $schedule_id = $_GET['sched_id'];

            

            $time_interval = $_GET['ti'];

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
            <h1>Time Schedules - </h1>
            </div>

   
        <div class="section-body">
            <div class="card">
              <div class="card-header">
                 <h4></h4>
                  <div class="card-header-action">
                    <a href="add_schedule_time.php?sched_id=<?php echo $schedule_id ?>&ti=<?php echo $time_interval?>" class="btn btn-success btn-sm">Add Time Schedules</a>
                     <a href="schedules.php" class="btn btn-danger btn-sm">Return</a>
                  </div>
              </div>

                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th>Available Start Time</th>
                          <th>Available End Time</th>
                          <th></th>
                        </tr>

                      <?php 
                      // query for getting doctor schedules
                      $sqlTimeSched = "SELECT * FROM doctor_schedule_time dst
                      WHERE dst.schedule_id = '$schedule_id'
                      ";

                      $resultTimeSched = mysqli_query($connection,$sqlTimeSched);
                      while($rowTimeSched = mysqli_fetch_assoc($resultTimeSched)) {

                      
                        $time_sched_id = $rowTimeSched['schedule_time_id'];

                        // doctor schedule
                        $sched_start  = $rowTimeSched['schedule_start_time']; 
                        $sched_end    = $rowTimeSched['schedule_end_time'];
                       
                        // time format

                        $format_start = date("h:i:A", strtotime($sched_start));
                        $format_end   = date("h:i:A", strtotime($sched_end));



                      ?>   
                      <tr>
                        <td><?php echo $format_start ?> </td>
                        <td><?php echo $format_end ?> </td>
                        <!-- <td><span></span></td> -->
                        <td><a class="btn btn-danger" href="../../backend/doctor_schedules_time.php?timeschedID=<?php echo $time_sched_id?>&ti=<?php echo $time_interval ?>&schedID=<?php echo $schedule_id ?>">Delete</a></td>
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