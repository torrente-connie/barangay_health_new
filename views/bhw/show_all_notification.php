<?php 
  
  // session info here
  session_start();

  $bhw_id = $_SESSION['bhw_id']; // get session bhw id
  $bhw_fullname = $_SESSION['bhw_fullname']; // get session bhw fullname
  $bhw_image = $_SESSION['bhw_image'];

  if($_SESSION['bhw_image'] == '') {
    $bhw_image = "../../assets/img/avatar/avatar-1.png";
  } else {
    $bhw_image = $bhw_image;
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
                  <span>Appointments</span>
                </a>
                  <ul class="dropdown-menu" style="display: none;">
                      <li class="nav-item"><a href="appointments_book.php" class="nav-link" style="padding-right:0 !important"> <span>Face to Face Appointment</span> </a></li>
                      <li class="nav-item"><a href="appointments_oc.php" class="nav-link"> <span>Virtual Consultation</span> </a></li>
                      <li class="nav-item dropdown"><a class="nav-link has-dropdown">Walk-in Appointment</a>
                        <ul class="dropdown-menu">
                          <li class="nav-item"><a href="appointments_walk_in.php" class="nav-link">With Account</a></li>
                          <li class="nav-item"><a href="appointments_walk_in_noacc.php" class="nav-link">Without Account</a></li>
                        </ul>
                      </li>
                    </ul>
                </li>

                 <li class="nav-item">
                       <a href="medical_history.php" class="nav-link"><i class="fas fa-pen"></i><span>Medical History</span></a>
                     </li>


          </ul>
        </div>
      </nav>

            <!-- Main Content -->
      <div class="main-content" style="min-height: 566px;">
        <section class="section">
          <div class="section-header">
            <h1>Show All Notifications</h1>
            </div>

   
        <div class="section-body">
            <div class="card">
              <div class="card-header">
                 <h4></h4>
               </div>

                <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered" id="table-subject">
                        <thead class="thead-light">
                          <tr>
                            <th>Notification Message</th>
                            <th>Notification Date and Time</th>
                           </tr>
                        </thead>
                        <tbody>

                      <?php 

                      // query getting all notifications
                      $sqlNotification = "SELECT * FROM notification WHERE notification_usertype = 'bhw' OR notification_bhw_id = '$bhw_id' AND notification_status = 1 ORDER BY notification_datetime DESC
                      ";

                      $resultNotification = mysqli_query($connection,$sqlNotification);
                      while($rowNotification = mysqli_fetch_assoc($resultNotification)) {

                       $notification_message = $rowNotification['notification_message'];
                       $notification_datetime = $rowNotification['notification_datetime'];

                       $datetime_format = date('m/d/Y h:i A',strtotime($rowNotification['notification_datetime']));

                      ?>

                        <tr>
                          <td><?php echo $notification_message ?> </td>
                          <td><?php echo $datetime_format ?></td>
                        </tr>
                      
                      <?php } ?>

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
    <br>

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