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
                    <a href="doctorschedules_view_more.php" class="btn btn-primary btn-sm">View More</a>
                  </div>
              </div>

            <div class="card-body">
           <div class="table-responsive">
                      <table class="table table-hover table-bordered" id="table-subject">
                        <thead class="thead-light">
                          <tr>
                            <th>Account ID</th>
                            <th>Fullname</th>
                            <th>User Type</th>
                            <th>Contact Number</th>
                            <th>Date of Birth</th>
                          </tr>
                        </thead>
                        <tbody>

                      <?php 

                      // query for getting patient
                      $sqlPatient = "SELECT * FROM user
                      WHERE user_type = 'Doctor'
                      ";

                      $resultPatient = mysqli_query($connection,$sqlPatient);
                      while($rowPatient = mysqli_fetch_assoc($resultPatient)) {

                        // user account id
                        $account_id   = $rowPatient['user_account_id'];

                        // user full name
                        $firstname    = ucfirst($rowPatient['user_firstname']);
                        $middlename   = ucfirst($rowPatient['user_middlename']);
                        $lastname     = ucfirst($rowPatient['user_lastname']);

                        $fullname = $firstname.' '.$middlename.'.'.' '.$lastname;

                        // user info
                        $user_dob  = $rowPatient['user_dob'];
                        $user_cnum = ucfirst($rowPatient['user_cnum']); 
                        $user_type = ucfirst($rowPatient['user_type']);

                      ?>

                        <tr>
                          <td><?php echo $account_id ?> </td>
                          <td><?php echo $fullname ?></td>
                          <td><div class="badge badge-primary"><?php echo $user_type ?></div></td>
                          <td><?php echo $user_cnum ?></td>
                          <td><?php echo $user_dob ?></td>
                         
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