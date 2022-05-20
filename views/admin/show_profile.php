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

  $displayCurrentUserInfo = "SELECT * FROM user WHERE user_type = 'Administrator' AND user_id = '$admin_id'";
  $resultDisplay = mysqli_query($connection,$displayCurrentUserInfo);


  while($rowDisplay = mysqli_fetch_assoc($resultDisplay)) {
      $account_id     = $rowDisplay['user_account_id'];
      $account_type   = $rowDisplay['user_type'];
      $account_email  = $rowDisplay['user_email'];
      $account_phone  = $rowDisplay['user_cnum'];
      $account_dob    = $rowDisplay['user_dob'];
     
      if($rowDisplay['user_image'] == '') {
         $account_profile = "../../assets/img/avatar/avatar-1.png";
      } else {
         $account_profile = $rowDisplay['user_image'];
      }

      // user full name
      $firstname    = ucfirst($rowDisplay['user_firstname']);
      $middlename   = ucfirst($rowDisplay['user_middlename']);
      $lastname     = ucfirst($rowDisplay['user_lastname']);

      $fullname = $firstname.' '.$middlename.'.'.' '.$lastname;
  }
  
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
          
          ?>

          <!-- profile here -->
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="../<?php echo $admin_image ?>" class="rounded-circle mr-1" style="width:30px;height:30px;">
            <div class="d-sm-none d-lg-inline-block text-capitalize">Hi, <?php echo $admin_fullname; ?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item has-icon" href="show_changepassword.php" style="cursor: pointer">
                <i class="fas fa-unlock"></i> Change Password
              </a>
              <a class="dropdown-item active has-icon" href="show_profile.php" style="cursor: pointer">
                <i class="far fa-user"></i> Profile
              </a>
              <div class="dropdown-divider"></div>
              <a href="../../logout.php" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>

        
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

            <li class="nav-item">
              <a href="schedules.php" class="nav-link"><i class="fas fa-clock"></i><span>Schedules</span></a>
            </li>


          </ul>
        </div>
      </nav>


    <!-- Main Content -->
     <div class="main-content" style="min-height: 566px;">
        <section class="section">
          <div class="section-header">
            <h1>Account Profile</h1>
          </div>
          <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                  <div class="profile-widget-header">
                    <img alt="image" src="../<?php echo $account_profile ?>" class="rounded-circle profile-widget-picture" style="width:100px;height: 100px;">
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Account ID</div>
                        <div class="profile-widget-item-value"><?php echo $account_id ?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Account Type</div>
                        <div class="profile-widget-item-value"><?php echo $account_type ?></div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-widget-description">
                    <div class="profile-widget-name"> <?php echo $fullname ?> </div>
                      <ul class="list-group list-group-flush">
                      <li class="list-group-item">Email: <?php echo $account_email ?></li>
                      <li class="list-group-item">Phone: <?php echo $account_phone ?></li>
                     
                    </ul>
                   
                  </div>
                  <div class="card-footer text-center">
                    <hr>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                  <form action="../../backend/admin_profile.php" method="POST" enctype="multipart/form-data">
                    <div class="card-header">
                      <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">

                        <input type="hidden" name="user_id" value="<?php echo $admin_id ?>">
                        <input type="hidden" name="account_image" value="<?php echo $account_profile ?>">


                        <div class="row">
                            <div class="form-group col-md-12 col-12">
                               <label>Profile Picture</label>
                                 <input type="file" class="form-control" name="profile_image">
                              </div>
                          </div>

                        <div class="row">
                          <div class="form-group col-md-4 col-12">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="firstname" value="<?php echo $firstname ?>" >
                          </div>
                           <div class="form-group col-md-4 col-12">
                            <label>Middle Name</label>
                            <input type="text" class="form-control" name="middlename" value="<?php echo $middlename ?>" >
                          </div>
                          <div class="form-group col-md-4 col-12">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lastname" value="<?php echo $lastname ?>">
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-7 col-12">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $account_email ?>">
                          </div>
                          <div class="form-group col-md-5 col-12">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo $account_phone ?>">
                          </div>
                        </div>
                       </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary" type="submit" name="editAdminProfile">Save Changes</button>
                      <a href="dashboard.php"  class="btn btn-danger text-white">Cancel</a>
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