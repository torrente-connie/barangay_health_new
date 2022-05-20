<?php 

  require("scripts_header.php");

  // db connection
  require("backend/dbconn.php");
  $connection = dbConn();
  
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

            <li class="nav-item active">
              <a href="home_schedules.php" class="nav-link"><i class="fas fa-clock"></i><span>Schedules</span></a>
            </li>
           
            <li class="nav-item">
              <a href="home_appointments.php" class="nav-link"><i class="fas fa-calendar-check"></i><span>Appointments</span></a>
            </li>


          </ul>
        </div>
      </nav>

        <!-- Main Content -->
      <div class="main-content" style="min-height: 566px;">
        <section class="section">
          <div class="section-header">
            <h1>Doctor Schedules</h1>
            </div>

   
        <div class="section-body">
            <div class="card">
              <div class="card-header">
                 <h4></h4>
                  <div class="card-header-action">
                   <!--  <a href="doctorschedules_view_more.php" class="btn btn-primary btn-sm">View More</a> -->
                  </div>
              </div>

            <div class="card-body">
            <div class="row">
             <?php 
           
             // $sql = "SELECT DISTINCT(doctor_id) FROM doctor_schedule ds
             // JOIN user d 
             // ON ds.doctor_id = d.user_id
             // ";

             $sql = "SELECT * FROM user WHERE user_type = 'Doctor'";
             $result = mysqli_query($connection,$sql);

             while($row = mysqli_fetch_assoc($result)) {

              // doctor full name
              $firstname    = ucfirst($row['user_firstname']);
              $middlename   = ucfirst($row['user_middlename']);
              $lastname     = ucfirst($row['user_lastname']);

              $fullname = $firstname.' '.$middlename.'.'.' '.$lastname;

              $doctor_id    = $row['user_id'];

              if($row['user_image'] == "") {
                $doctor_image = "img/avatar/avatar-1.png";
              } else {
                $doctor_image = $row['user_image'];
              }

             ?>

              <div class="col-lg-6">
                <ul class="list-unstyled">
                 <li class="media mt-3">
                      <img class="mr-4" style="width:100px;height:100px;" src="assets/<?php echo $doctor_image ?>" alt="avatar">
                      <div class="media-body">
                        <div class="float-right text-primary"></div>
                        <div class="media-title"><h4>Dr. <?php echo $fullname ?></h4></div>
                        <span class="text-small text-muted"><h5>General Physician</h5></span><br><br>

                      <?php 
                        if(!empty($_SESSION['patient_id'])) {
                      ?>

                      <a href="book_appointments.php?adid=<?php echo $doctor_id?>" class="btn btn-primary btn-sm text-white">Book An Appointment </a>
                       
                      <?php 

                      } else if((!empty($_SESSION['bhw_id']))) { 

                      ?>

                      <a href="book_appointments.php?adid=<?php echo $doctor_id?>" class="btn btn-primary btn-sm text-white">Book An Appointment </a>
                     
                      <?php 

                      } else {

                      ?>

                      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#bookAppointment"> Book An Appointment </button>
                      
                      <?php } ?>


                      </div>
                    </li>
                  </ul>
                </div>

              <div class="col-lg-6">
                 <ul class="list-group mb-5">
                    <li class="list-group-item text-center bg-primary text-white text-bold"><h5>Doctor Schedules</h5></li>
                   <?php 

                    $sqlSched = "SELECT * FROM doctor_schedule WHERE doctor_id = '$doctor_id' ORDER BY schedule_day ASC ";
                    $result1 = mysqli_query($connection,$sqlSched);
                    while($row2 = mysqli_fetch_assoc($result1)) {

                    // doctor schedules
                    $day = $row2['schedule_day'];
                    $start_time = $row2['schedule_start_time'];
                    $end_time = $row2['schedule_end_time'];

                    // time format

                    $format_start = date("h:i:A", strtotime($start_time));
                    $format_end   = date("h:i:A", strtotime($end_time));

                     if($day == 0) {
                      $display_day = "Sunday";
                    } else if($day == 1) {
                      $display_day = "Monday";
                    } else if($day == 2) {
                      $display_day = "Tuesday";
                    } else if($day == 3) {
                      $display_day = "Wednesday";
                    } else if($day == 4) {
                      $display_day = "Thursday";
                    } else if($day == 5) {
                      $display_day = "Friday";
                    } else if($day == 6) {
                      $display_day = "Saturday";
                    } 


                   ?> 

                   <li class="list-group-item"><h5><?php echo $display_day ?> - <?php echo $format_start ?> to <?php echo $format_end?> </h5></li>
                   <?php } ?>
                  </ul>
                </div>

              <?php  }
                ?>

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

   <!-- Modals -->

  <!-- Add Subject Modal -->
         <!-- <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal" data-backdrop="static" data-keyboard="false"> -->
        <div class="modal fade" tabindex="-1" role="dialog" id="bookAppointment">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Login</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
              </div>
             <div class="card-body">
                <!-- <form method="POST" action="#" class="needs-validation" novalidate="">
                 -->   
                <form method="POST" action="backend/login.php">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required="" autofocus="">
                    <!-- <div class="invalid-feedback">
                      Please fill in your email
                    </div> -->
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    <!--   <div class="float-right">
                        <a href="forgot_password.php" class="text-small">
                          Forgot Password?
                        </a>
                      </div> -->
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required="">
                
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      Don't have an account? 
                      <a href="create_account.php">
                          Create One
                        </a>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" name="loginHome" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>

               <!--   <div class="row sm-gutters">
                
                  <div class="col-6">
                    <a class="btn btn-block btn-lg btn-social btn-google">
                      <span class="fab fa-google"></span> Google
                    </a>                   
                  </div>

                    <div class="col-6">
                    <a class="btn btn-block btn-lg btn-social btn-facebook">
                      <span class="fab fa-facebook"></span> Facebook
                    </a>
                  </div>
                </div> -->

              </div>
            </div>
          </div>
        </div>


   <!-- Menu for Footer Links -->
    <?php require("scripts_footer.php"); ?>
    <!-- -->


  </body>
</html>